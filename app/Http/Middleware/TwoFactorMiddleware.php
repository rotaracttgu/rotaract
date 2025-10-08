<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Aquí va la lógica de verificación en dos pasos
        // Por ejemplo, verificar si el usuario tiene la 2FA activa y si ya la verificó

        if (auth()->check() && auth()->user()->two_factor_enabled) {
            if (!session('2fa_verified')) {
                return redirect()->route('2fa.verify');
            }
        }

        return $next($request);
    }
}