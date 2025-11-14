<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BitacoraSistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SecurityQuestionPasswordResetController extends Controller
{
    /**
     * Mostrar formulario para ingresar email/username
     */
    public function showIdentifyForm()
    {
        return view('auth.security-questions.identify');
    }

    /**
     * Verificar que el usuario existe y mostrar preguntas
     */
    public function showQuestions(Request $request)
    {
        $request->validate([
            'identifier' => ['required', 'string'],
        ]);

        $user = User::where('email', $request->identifier)
            ->orWhere('username', $request->identifier)
            ->first();

        if (!$user) {
            return back()->withErrors(['identifier' => 'No se encontró ningún usuario con ese email o nombre de usuario.']);
        }

        if (!$user->pregunta_seguridad_1 || !$user->pregunta_seguridad_2) {
            return back()->withErrors(['identifier' => 'Este usuario no tiene preguntas de seguridad configuradas.']);
        }

        // Guardar en sesión para poder volver en caso de error
        session([
            'recovery_user_id' => $user->id,
            'recovery_pregunta1' => $user->pregunta_seguridad_1,
            'recovery_pregunta2' => $user->pregunta_seguridad_2,
        ]);

        return view('auth.security-questions.answer', [
            'user' => $user,
            'pregunta1' => $user->pregunta_seguridad_1,
            'pregunta2' => $user->pregunta_seguridad_2,
        ]);
    }

    /**
     * Verificar respuestas y mostrar formulario de nueva contraseña
     */
    public function verifyAnswers(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'respuesta_1' => ['required', 'string'],
            'respuesta_2' => ['required', 'string'],
        ]);

        $user = User::findOrFail($request->user_id);

        $respuesta1Correcta = $user->checkSecurityAnswer(1, $request->respuesta_1);
        $respuesta2Correcta = $user->checkSecurityAnswer(2, $request->respuesta_2);

        if (!$respuesta1Correcta || !$respuesta2Correcta) {
            BitacoraSistema::registrar([
                'user_id' => $user->id,
                'accion' => 'recuperacion_fallida',
                'modulo' => 'autenticacion',
                'descripcion' => "Intento fallido de recuperación de contraseña para: {$user->email}",
                'estado' => 'fallido',
            ]);

            // ⭐ CORREGIDO: Volver a mostrar las preguntas con el error
            return view('auth.security-questions.answer', [
                'user' => $user,
                'pregunta1' => session('recovery_pregunta1', $user->pregunta_seguridad_1),
                'pregunta2' => session('recovery_pregunta2', $user->pregunta_seguridad_2),
            ])->withErrors([
                'respuestas' => '❌ Una o ambas respuestas son incorrectas. Por favor, verifica e intenta nuevamente.'
            ]);
        }

        // Limpiar sesión de recovery
        session()->forget(['recovery_user_id', 'recovery_pregunta1', 'recovery_pregunta2']);

        // Respuestas correctas - mostrar formulario de nueva contraseña
        return view('auth.security-questions.reset-password', [
            'user' => $user,
            'token' => encrypt($user->id . '|' . now()->timestamp),
        ]);
    }

    /**
     * Actualizar la contraseña
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required', 'string'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->letters()->numbers()->symbols()],
        ], [
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        try {
            $decrypted = decrypt($request->token);
            [$userId, $timestamp] = explode('|', $decrypted);

            // Verificar que el token no tenga más de 15 minutos
            if (now()->timestamp - $timestamp > 900) {
                return back()->withErrors(['token' => 'El enlace ha expirado. Por favor inicia el proceso nuevamente.']);
            }

            $user = User::findOrFail($userId);
            $user->password = Hash::make($request->password);
            $user->save();

            // Resetear intentos de login
            $user->resetLoginAttempts();

            BitacoraSistema::registrar([
                'user_id' => $user->id,
                'accion' => 'cambio_password',
                'modulo' => 'autenticacion',
                'descripcion' => "Contraseña restablecida exitosamente usando preguntas de seguridad: {$user->email}",
                'estado' => 'exitoso',
            ]);

            return redirect()->route('login')->with('success', '¡Contraseña restablecida exitosamente! Ya puedes iniciar sesión con tu nueva contraseña.');

        } catch (\Exception $e) {
            return back()->withErrors(['token' => 'Token inválido. Por favor inicia el proceso nuevamente.']);
        }
    }
}