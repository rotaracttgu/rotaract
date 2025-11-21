<?php

namespace App\Traits;

use App\Services\NotificacionService;
use Illuminate\Support\Facades\Auth;

/**
 * Trait ManagesNotifications
 *
 * Maneja toda la lógica compartida de gestión de notificaciones
 * entre todos los controladores
 */
trait ManagesNotifications
{
    /**
     * Muestra el centro de notificaciones
     */
    public function notificaciones()
    {
        // Auto-marcar todas las notificaciones como leídas al entrar
        \App\Models\Notificacion::where('usuario_id', auth()->id())
            ->where('leida', false)
            ->update(['leida' => true, 'leida_en' => now()]);

        $notificacionService = app(NotificacionService::class);

        // Obtener todas las notificaciones del usuario actual
        $notificaciones = $notificacionService->obtenerTodas(auth()->id(), 50);

        // Contar notificaciones no leídas (ahora será 0)
        $noLeidas = 0;

        // Determinar la vista según el controlador
        $vista = $this->getNotificationsView();

        return view($vista, compact('notificaciones', 'noLeidas'));
    }

    /**
     * Marcar una notificación como leída
     */
    public function marcarNotificacionLeida($id)
    {
        $notificacionService = app(NotificacionService::class);
        $notificacionService->marcarComoLeida($id);

        return response()->json(['success' => true]);
    }

    /**
     * Marcar todas las notificaciones como leídas
     */
    public function marcarTodasNotificacionesLeidas()
    {
        $notificacionService = app(NotificacionService::class);
        $notificacionService->marcarTodasComoLeidas(auth()->id());

        return response()->json(['success' => true]);
    }

    /**
     * Verificar actualizaciones para notificaciones en tiempo real
     */
    public function verificarActualizaciones()
    {
        try {
            $notificacionService = app(NotificacionService::class);

            $ultimasNotificaciones = $notificacionService->obtenerNoLeidas(Auth::id());

            if ($ultimasNotificaciones instanceof \Illuminate\Database\Eloquent\Builder ||
                $ultimasNotificaciones instanceof \Illuminate\Database\Query\Builder) {
                $ultimasNotificaciones = $ultimasNotificaciones->take(1)->get();
            } elseif ($ultimasNotificaciones instanceof \Illuminate\Support\Collection) {
                $ultimasNotificaciones = $ultimasNotificaciones->take(1);
            } else {
                $ultimasNotificaciones = \Illuminate\Support\Collection::make($ultimasNotificaciones)->take(1);
            }

            if ($ultimasNotificaciones->isEmpty()) {
                return response()->json([
                    'hay_nuevas' => false,
                    'notificaciones' => [],
                    'success' => true,
                    'notificaciones_nuevas' => 0
                ]);
            }

            $notificacion = $ultimasNotificaciones->first();

            return response()->json([
                'success' => true,
                'notificaciones_nuevas' => $ultimasNotificaciones->count(),
                'ultima_notificacion' => [
                    'id' => $notificacion->id,
                    'titulo' => $notificacion->titulo,
                    'mensaje' => $notificacion->mensaje,
                    'icono' => $notificacion->icono ?? 'fa-bell',
                    'color' => $notificacion->color ?? 'blue',
                    'url' => $notificacion->url ?? '#',
                    'created_at' => $notificacion->created_at->diffForHumans()
                ],
                'timestamp' => now()->timestamp
            ]);

        } catch (\Exception $e) {
            \Log::error('Error verificando notificaciones: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'notificaciones_nuevas' => 0,
                'mensaje' => 'Error al verificar actualizaciones'
            ], 500);
        }
    }

    /**
     * Obtener la vista de notificaciones según el controlador
     * Este método debe ser implementado por el controlador que use el trait
     */
    abstract protected function getNotificationsView(): string;
}
