<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordRenewalController extends Controller
{
    /**
     * Mostrar el formulario de renovación de contraseña
     */
    public function showForm()
    {
        $usuario = auth()->user();

        return view('auth.password-renewal', [
            'usuario'         => $usuario,
            'diasRestantes'   => $usuario->diasParaVencerContrasena(),
            'passwordExpired' => $usuario->passwordExpired(),
        ]);
    }

    /**
     * Procesar la renovación de contraseña
     */
    public function store(Request $request)
    {
        $request->validate([
            'password_actual'   => ['required', 'string'],
            'password'          => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ], [
            'password_actual.required'  => 'Debes ingresar tu contraseña actual.',
            'password.required'         => 'La nueva contraseña es requerida.',
            'password.confirmed'        => 'La confirmación de contraseña no coincide.',
            'password.min'              => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        $usuario = auth()->user();

        // Verificar contraseña actual
        if (!Hash::check($request->password_actual, $usuario->password)) {
            return back()->withErrors(['password_actual' => 'La contraseña actual no es correcta.']);
        }

        // No permitir reusar la misma contraseña
        if (Hash::check($request->password, $usuario->password)) {
            return back()->withErrors(['password' => 'La nueva contraseña no puede ser igual a la actual.']);
        }

        $usuario->renovarContrasena($request->password);

        return redirect()->route('dashboard')
            ->with('success', '¡Contraseña renovada exitosamente! Tu nueva contraseña es válida por ' . \App\Models\Parametro::obtener('dias_vigencia_contrasena', 90) . ' días.');
    }
}
