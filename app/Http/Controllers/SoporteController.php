<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\SoporteMensaje;
use App\Models\SoporteTicket;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SoporteController extends Controller
{
    private const RESPONDER_ROLES = ['Admin', 'Super Admin'];

    public function index(): View|RedirectResponse
    {
        $user = Auth::user();

        if ($this->canRespond($user)) {
            return redirect()->route('admin.soporte.index');
        }

        $tickets = SoporteTicket::query()
            ->where('user_id', $user->id)
            ->with('ultimoMensaje.sender')
            ->withCount([
                'mensajes as unread_admin_messages_count' => function ($query): void {
                    $query->where('is_admin', true)->whereNull('read_at');
                },
            ])
            ->orderByDesc('updated_at')
            ->paginate(20);

        return view('soporte.user-index', [
            'tickets' => $tickets,
            'layout' => $this->resolveLayout($user),
            'routePrefix' => $this->resolveRoutePrefix($user),
        ]);
    }

    public function create(): View
    {
        $user = Auth::user();
        $this->assertCanCreate($user);

        return view('soporte.user-create', [
            'layout' => $this->resolveLayout($user),
            'routePrefix' => $this->resolveRoutePrefix($user),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $this->assertCanCreate($user);

        $validated = $request->validate([
            'subject' => ['required', 'string', 'max:200'],
            'priority' => ['required', 'in:baja,media,alta,urgente'],
            'message' => ['required', 'string', 'min:5', 'max:4000'],
        ]);

        $ticket = DB::transaction(function () use ($validated, $user): SoporteTicket {
            $ticket = SoporteTicket::create([
                'user_id' => $user->id,
                'subject' => $validated['subject'],
                'priority' => $validated['priority'],
                'status' => 'abierto',
                'last_user_message_at' => now(),
            ]);

            SoporteMensaje::create([
                'soporte_ticket_id' => $ticket->id,
                'sender_id' => $user->id,
                'message' => $validated['message'],
                'is_admin' => false,
            ]);

            $this->notificarRespondedores(
                'Nuevo ticket de soporte',
                "{$user->name} creo un ticket: {$ticket->subject}",
                route('admin.soporte.show', $ticket->id),
                $ticket->id
            );

            return $ticket;
        });

        return redirect()
            ->route($this->resolveRoutePrefix($user).'.soporte.show', $ticket->id)
            ->with('success', 'Consulta enviada al equipo de soporte. Respuesta objetivo: 24h.');
    }

    public function show(SoporteTicket $ticket): View
    {
        $user = Auth::user();
        $this->assertTicketOwner($ticket, $user->id);

        $ticket->load(['mensajes.sender', 'user']);

        SoporteMensaje::query()
            ->where('soporte_ticket_id', $ticket->id)
            ->where('is_admin', true)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('soporte.user-show', [
            'ticket' => $ticket,
            'layout' => $this->resolveLayout($user),
            'routePrefix' => $this->resolveRoutePrefix($user),
            'canReply' => in_array($ticket->status, ['abierto', 'en_proceso', 'resuelto'], true),
        ]);
    }

    public function reply(Request $request, SoporteTicket $ticket): RedirectResponse
    {
        $user = Auth::user();
        $this->assertTicketOwner($ticket, $user->id);

        $validated = $request->validate([
            'message' => ['required', 'string', 'min:1', 'max:4000'],
        ]);

        DB::transaction(function () use ($ticket, $user, $validated): void {
            SoporteMensaje::create([
                'soporte_ticket_id' => $ticket->id,
                'sender_id' => $user->id,
                'message' => $validated['message'],
                'is_admin' => false,
            ]);

            $newStatus = in_array($ticket->status, ['resuelto', 'cerrado'], true) ? 'abierto' : $ticket->status;

            $ticket->update([
                'status' => $newStatus,
                'last_user_message_at' => now(),
                'closed_at' => $newStatus === 'cerrado' ? now() : null,
            ]);

            $this->notificarRespondedores(
                'Nuevo mensaje en ticket',
                "{$user->name} respondio en ticket #{$ticket->id}",
                route('admin.soporte.show', $ticket->id),
                $ticket->id
            );
        });

        return redirect()
            ->route($this->resolveRoutePrefix($user).'.soporte.show', $ticket->id)
            ->with('success', 'Mensaje enviado a soporte.');
    }

    public function messages(Request $request, SoporteTicket $ticket): JsonResponse
    {
        $user = Auth::user();
        $this->assertTicketOwner($ticket, $user->id);

        $afterId = (int) $request->query('after_id', 0);

        $query = SoporteMensaje::query()
            ->where('soporte_ticket_id', $ticket->id)
            ->with('sender:id,name,username')
            ->orderBy('id');

        if ($afterId > 0) {
            $query->where('id', '>', $afterId);
        }

        $messages = $query->get()->map(function (SoporteMensaje $message): array {
            return [
                'id' => $message->id,
                'message' => $message->message,
                'is_admin' => $message->is_admin,
                'sender_name' => $message->sender->username ?? $message->sender->name,
                'created_at' => optional($message->created_at)->format('d/m/Y H:i'),
            ];
        })->values();

        SoporteMensaje::query()
            ->where('soporte_ticket_id', $ticket->id)
            ->where('is_admin', true)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json([
            'messages' => $messages,
            'last_id' => SoporteMensaje::query()->where('soporte_ticket_id', $ticket->id)->max('id') ?? 0,
            'status' => $ticket->status,
        ]);
    }

    public function notificationsSummary(): JsonResponse
    {
        $user = Auth::user();

        if ($this->canRespond($user)) {
            $unreadCount = SoporteMensaje::query()
                ->where('is_admin', false)
                ->whereNull('read_at')
                ->whereHas('ticket', function ($query): void {
                    $query->whereIn('status', ['abierto', 'en_proceso', 'resuelto']);
                })
                ->count();

            $openTickets = SoporteTicket::query()
                ->whereIn('status', ['abierto', 'en_proceso', 'resuelto'])
                ->count();

            return response()->json([
                'unread_count' => $unreadCount,
                'open_tickets' => $openTickets,
                'is_admin' => true,
            ]);
        }

        $unreadCount = SoporteMensaje::query()
            ->where('is_admin', true)
            ->whereNull('read_at')
            ->whereHas('ticket', function ($query) use ($user): void {
                $query->where('user_id', $user->id)->whereIn('status', ['abierto', 'en_proceso', 'resuelto']);
            })
            ->count();

        return response()->json([
            'unread_count' => $unreadCount,
            'open_tickets' => SoporteTicket::query()->where('user_id', $user->id)->whereIn('status', ['abierto', 'en_proceso', 'resuelto'])->count(),
            'is_admin' => false,
        ]);
    }

    private function resolveLayout(User $user): string
    {
        if ($user->hasRole('Socio')) {
            return 'modulos.socio.layout';
        }

        if ($user->hasRole('Tesorero')) {
            return 'modulos.tesorero.layout';
        }

        if ($user->hasRole('Secretario') || $user->hasRole('Secretaria')) {
            return 'modulos.secretaria.layout';
        }

        if ($user->hasRole('Presidente')) {
            return 'modulos.presidente.layout';
        }

        if ($user->hasRole('Vicepresidente')) {
            return 'modulos.vicepresidente.layout';
        }

        if ($user->hasAnyRole(self::RESPONDER_ROLES)) {
            return 'layouts.app-admin';
        }

        return 'layouts.app';
    }

    private function resolveRoutePrefix(User $user): string
    {
        if ($user->hasRole('Socio')) {
            return 'socio';
        }

        if ($user->hasRole('Vocero')) {
            return 'vocero';
        }

        if ($user->hasRole('Tesorero')) {
            return 'tesorero';
        }

        if ($user->hasRole('Secretario') || $user->hasRole('Secretaria')) {
            return 'secretaria';
        }

        if ($user->hasRole('Presidente')) {
            return 'presidente';
        }

        if ($user->hasRole('Vicepresidente')) {
            return 'vicepresidente';
        }

        return 'socio';
    }

    private function assertCanCreate(User $user): void
    {
        abort_if($this->canRespond($user), 403, 'Admin/Super Admin solo responden tickets.');
    }

    private function canRespond(User $user): bool
    {
        $roleNames = $user->getRoleNames();

        return $roleNames->contains('Admin') || $roleNames->contains('Super Admin');
    }

    private function assertTicketOwner(SoporteTicket $ticket, int $userId): void
    {
        abort_if($ticket->user_id !== $userId, 403, 'No autorizado para este ticket.');
    }

    private function notificarRespondedores(string $titulo, string $mensaje, string $url, int $ticketId): void
    {
        // Avoid Spatie role() scope here because it throws if one role does not exist.
        $usuarios = User::query()
            ->whereHas('roles', function ($query): void {
                $query->whereIn('name', self::RESPONDER_ROLES);
            })
            ->pluck('id');

        foreach ($usuarios as $usuarioId) {
            Notificacion::create([
                'usuario_id' => $usuarioId,
                'tipo' => 'soporte',
                'titulo' => $titulo,
                'mensaje' => $mensaje,
                'icono' => 'fas fa-headset',
                'color' => 'blue',
                'url' => $url,
                'relacionado_id' => $ticketId,
                'relacionado_tipo' => SoporteTicket::class,
            ]);
        }
    }
}
