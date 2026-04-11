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

class SoporteAdminController extends Controller
{
    private const ROLES = ['Admin', 'Super Admin'];

    public function index(Request $request): View
    {
        $this->assertResponderRole();

        $status = $request->query('status');

        $tickets = SoporteTicket::query()
            ->with('user')
            ->withCount([
                'mensajes as unread_user_messages_count' => function ($query): void {
                    $query->where('is_admin', false)->whereNull('read_at');
                },
            ])
            ->when($status, function ($query, $status): void {
                $query->where('status', $status);
            })
            ->orderByRaw("FIELD(status, 'abierto', 'en_proceso', 'resuelto', 'cerrado')")
            ->orderByDesc('updated_at')
            ->paginate(30);

        $stats = [
            'abiertos' => SoporteTicket::query()->where('status', 'abierto')->count(),
            'en_proceso' => SoporteTicket::query()->where('status', 'en_proceso')->count(),
            'resueltos' => SoporteTicket::query()->where('status', 'resuelto')->count(),
            'cerrados' => SoporteTicket::query()->where('status', 'cerrado')->count(),
            'sin_leer' => SoporteMensaje::query()->where('is_admin', false)->whereNull('read_at')->count(),
        ];

        return view('soporte.admin-index', [
            'tickets' => $tickets,
            'stats' => $stats,
            'status' => $status,
        ]);
    }

    public function show(SoporteTicket $ticket): View
    {
        $this->assertResponderRole();

        $ticket->load(['user', 'mensajes.sender']);

        SoporteMensaje::query()
            ->where('soporte_ticket_id', $ticket->id)
            ->where('is_admin', false)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('soporte.admin-show', [
            'ticket' => $ticket,
            'statusOptions' => ['abierto', 'en_proceso', 'resuelto', 'cerrado'],
        ]);
    }

    public function reply(Request $request, SoporteTicket $ticket): RedirectResponse
    {
        $this->assertResponderRole();

        $validated = $request->validate([
            'message' => ['required', 'string', 'min:1', 'max:4000'],
            'status' => ['nullable', 'in:abierto,en_proceso,resuelto,cerrado'],
        ]);

        DB::transaction(function () use ($ticket, $validated): void {
            SoporteMensaje::create([
                'soporte_ticket_id' => $ticket->id,
                'sender_id' => Auth::id(),
                'message' => $validated['message'],
                'is_admin' => true,
            ]);

            $newStatus = $validated['status'] ?? 'en_proceso';

            $ticket->update([
                'status' => $newStatus,
                'last_admin_message_at' => now(),
                'responded_at' => now(),
                'closed_at' => $newStatus === 'cerrado' ? now() : null,
            ]);

            $this->notificarUsuario(
                $ticket->user_id,
                'Respuesta de soporte',
                "Soporte respondio tu ticket #{$ticket->id}: {$ticket->subject}",
                route($this->resolveUserShowRoute($ticket->user), $ticket->id),
                $ticket->id
            );
        });

        return redirect()
            ->route('admin.soporte.show', $ticket->id)
            ->with('success', 'Respuesta enviada al usuario.');
    }

    public function updateStatus(Request $request, SoporteTicket $ticket): RedirectResponse
    {
        $this->assertResponderRole();

        $validated = $request->validate([
            'status' => ['required', 'in:abierto,en_proceso,resuelto,cerrado'],
        ]);

        $ticket->update([
            'status' => $validated['status'],
            'closed_at' => $validated['status'] === 'cerrado' ? now() : null,
            'responded_at' => in_array($validated['status'], ['resuelto', 'cerrado'], true) ? now() : $ticket->responded_at,
        ]);

        $this->notificarUsuario(
            $ticket->user_id,
            'Estado de ticket actualizado',
            "Tu ticket #{$ticket->id} cambio a estado: {$validated['status']}",
            route($this->resolveUserShowRoute($ticket->user), $ticket->id),
            $ticket->id
        );

        return redirect()
            ->route('admin.soporte.show', $ticket->id)
            ->with('success', 'Estado actualizado correctamente.');
    }

    public function messages(Request $request, SoporteTicket $ticket): JsonResponse
    {
        $this->assertResponderRole();

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
            ->where('is_admin', false)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json([
            'messages' => $messages,
            'last_id' => SoporteMensaje::query()->where('soporte_ticket_id', $ticket->id)->max('id') ?? 0,
            'status' => $ticket->status,
        ]);
    }

    private function assertResponderRole(): void
    {
        $roles = Auth::user()->getRoleNames();
        $isResponder = $roles->contains('Admin') || $roles->contains('Super Admin');

        abort_unless($isResponder, 403, 'No autorizado para soporte.');
    }

    private function resolveUserShowRoute(User $user): string
    {
        if ($user->hasRole('Socio')) {
            return 'socio.soporte.show';
        }

        if ($user->hasRole('Vocero')) {
            return 'vocero.soporte.show';
        }

        if ($user->hasRole('Tesorero')) {
            return 'tesorero.soporte.show';
        }

        if ($user->hasRole('Secretario') || $user->hasRole('Secretaria')) {
            return 'secretaria.soporte.show';
        }

        if ($user->hasRole('Presidente')) {
            return 'presidente.soporte.show';
        }

        if ($user->hasRole('Vicepresidente')) {
            return 'vicepresidente.soporte.show';
        }

        return 'socio.soporte.show';
    }

    private function notificarUsuario(int $usuarioId, string $titulo, string $mensaje, string $url, int $ticketId): void
    {
        Notificacion::create([
            'usuario_id' => $usuarioId,
            'tipo' => 'soporte',
            'titulo' => $titulo,
            'mensaje' => $mensaje,
            'icono' => 'fas fa-headset',
            'color' => 'indigo',
            'url' => $url,
            'relacionado_id' => $ticketId,
            'relacionado_tipo' => SoporteTicket::class,
        ]);
    }
}
