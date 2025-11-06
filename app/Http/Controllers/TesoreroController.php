<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NotificacionService;

class TesoreroController extends Controller
{
    /**
     * Muestra la página de bienvenida del módulo Tesorero
     */
    public function welcome()
    {
        return view('modulos.tesorero.welcome');
    }

    /**
     * Muestra el dashboard principal del Tesorero
     */
    public function index()
    {
        return view('modulos.tesorero.dashboard');
    }

    /**
     * Muestra el calendario financiero
     */
    public function calendario()
    {
        return view('modulos.tesorero.calendario');
    }

    /**
     * Muestra la gestión de finanzas
     */
    public function finanzas()
    {
        return view('modulos.tesorero.finanza');
    }
    
    // ============================================================================
    // NOTIFICACIONES
    // ============================================================================

    /**
     * Muestra el centro de notificaciones
     */
    public function notificaciones()
    {
        $notificacionService = app(NotificacionService::class);
        
        // Obtener todas las notificaciones del usuario actual
        $notificaciones = $notificacionService->obtenerTodas(auth()->id(), 50);
        
        // Contar notificaciones no leídas
        $noLeidas = $notificaciones->where('leida', false)->count();
        
        return view('modulos.tesorero.notificaciones', compact('notificaciones', 'noLeidas'));
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
}
