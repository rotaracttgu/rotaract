<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckFirstLogin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si el usuario está autenticado y es su primer login
        if (auth()->check() && auth()->user()->isFirstLogin()) {
            // Si ya está en la ruta de completar perfil, continuar
            if ($request->routeIs('profile.complete.form') || $request->routeIs('profile.complete.store')) {
                return $next($request);
            }
            
            // Si está intentando acceder a otra ruta, redirigir a completar perfil
            return redirect()->route('profile.complete.form')
                ->with('warning', 'Debes completar tu perfil antes de continuar.');
        }

        return $next($request);
    }
}