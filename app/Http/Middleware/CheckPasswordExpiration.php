<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPasswordExpiration
{
    /**
     * Rutas que están exentas de la verificación de caducidad
     */
    private array $rutasExentas = [
        'contrasena.renovar.form',
        'contrasena.renovar.store',
        'logout',
        'profile.complete.form',
        'profile.complete.store',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        // Solo aplica a usuarios autenticados
        if (!auth()->check()) {
            return $next($request);
        }

        $usuario = auth()->user();

        // Exentar rutas especiales
        foreach ($this->rutasExentas as $ruta) {
            if ($request->routeIs($ruta)) {
                return $next($request);
            }
        }

        // No interrumpir peticiones AJAX/JSON
        if ($request->ajax() || $request->wantsJson()) {
            return $next($request);
        }

        // Si la contraseña ha vencido, forzar renovación
        if ($usuario->passwordExpired()) {
            return redirect()->route('contrasena.renovar.form')
                ->with('error', 'Tu contraseña ha vencido. Debes renovarla para continuar.');
        }

        return $next($request);
    }
}
