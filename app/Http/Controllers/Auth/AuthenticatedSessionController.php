<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Notifications\TwoFactorCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // Si el usuario tiene 2FA habilitado pero no está verificado, redirigir a 2FA
        if ($user->two_factor_enabled && !$user->two_factor_verified_at) {
            // Generar código de 6 dígitos
            $code = rand(100000, 999999);

            // Guardar código y tiempo de expiración (10 minutos)
            $user->two_factor_code = $code;
            $user->two_factor_expires_at = now()->addMinutes(10);
            $user->save();

            // Enviar código por email
            $user->notify(new TwoFactorCode($code));

            // Redirigir a la página de verificación 2FA
            return redirect()->route('2fa.verify')->with('success', 'Se ha enviado un código de verificación a tu correo electrónico.');
        }

        // Si no tiene 2FA o ya está verificado, redirigir normalmente al dashboard
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}