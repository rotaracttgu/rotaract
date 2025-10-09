<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\TwoFactorCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TwoFactorController extends Controller
{
    public function show()
    {
        return view('auth.two-factor-challenge');
    }

    public function generateCode()
    {
        $user = Auth::user();
        $code = rand(100000, 999999);
        
        $user->two_factor_code = (string) $code;
        $user->two_factor_expires_at = now()->addMinutes(10);
        $user->save();
        
        $user->notify(new TwoFactorCode($code));
        
        return back()->with('success', 'Código enviado a tu correo electrónico.');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric|digits:6',
        ]);

        $user = Auth::user();
        $inputCode = trim($request->code);

        Log::info('DEBUG 2FA - Código ingresado: [' . $inputCode . '] - Código BD: [' . $user->two_factor_code . ']');

        if ($user->two_factor_code == $inputCode && 
            $user->two_factor_expires_at && 
            $user->two_factor_expires_at->isFuture()) {
            
            // ===== SESIÓN PERSISTENTE - YA NO PEDIR 2FA DE NUEVO =====
            session(['2fa_verified' => true]);
            session(['2fa_verified_user_' . $user->id => true]); // Persistente por usuario
            // ==========================================================
            
            // ===== MARCAR EMAIL COMO VERIFICADO AUTOMÁTICAMENTE =====
            if (!$user->email_verified_at) {
                $user->email_verified_at = now();
            }
            // ========================================================
            
            // Limpiar código usado
            $user->two_factor_code = null;
            $user->two_factor_expires_at = null;
            $user->save();
            
            return redirect()->intended($user->getDashboardRoute());
        }

        return back()->withErrors(['code' => 'El código es incorrecto o ha expirado.']);
    }

    public function enable()
    {
        $user = Auth::user();
        $user->two_factor_enabled = true;
        $user->save();
        
        return back()->with('success', 'Autenticación de dos factores habilitada.');
    }

    public function disable()
    {
        $user = Auth::user();
        $user->two_factor_enabled = false;
        $user->two_factor_code = null;
        $user->two_factor_expires_at = null;
        $user->save();
        
        return back()->with('success', 'Autenticación de dos factores deshabilitada.');
    }
}