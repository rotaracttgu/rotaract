<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Si el usuario NO tiene 2FA habilitado, dejar pasar
        if (!$user->two_factor_enabled) {
            return $next($request);
        }

        // ===== VERIFICAR SI YA SE VERIFICÓ EN ESTA SESIÓN =====
        if (session('2fa_verified_user_' . $user->id)) {
            return $next($request);
        }
        // =======================================================

        // Si está en la página de verificación 2FA, dejar pasar
        if ($request->routeIs('2fa.show') || $request->routeIs('2fa.verify') || $request->routeIs('2fa.resend')) {
            return $next($request);
        }

        // Redirigir a verificación 2FA
        return redirect()->route('2fa.show');
    }
}