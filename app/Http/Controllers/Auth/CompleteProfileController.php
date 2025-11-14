<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\BitacoraSistema;

class CompleteProfileController extends Controller
{
    private function getPreguntasPredefinidas(): array
    {
        return [
            '¿Cuál es el nombre de tu primera mascota?',
            '¿En qué ciudad naciste?',
            '¿Cuál es el nombre de soltera de tu madre?',
            '¿Cuál fue el nombre de tu primer colegio?',
            '¿Cuál es tu comida favorita?',
            '¿Cuál es el nombre de tu mejor amigo de la infancia?',
            '¿En qué calle vivías cuando eras niño?',
            '¿Cuál es tu película favorita?',
            '¿Cuál es el segundo nombre de tu padre?',
            '¿Cuál es tu color favorito?',
        ];
    }

    public function showForm()
    {
        $user = auth()->user();

        if (!$user->isFirstLogin()) {
            return redirect($user->getDashboardRoute());
        }

        $preguntasPredefinidas = $this->getPreguntasPredefinidas();

        return view('auth.complete-profile', compact('user', 'preguntasPredefinidas'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'dni' => ['required', 'string', 'max:20', 'unique:users,dni,' . $user->id],
            'telefono' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->letters()->numbers()->symbols()],
            'tipo_pregunta_1' => ['required', 'in:predefinida,personalizada'],
            'pregunta_predefinida_1' => ['required_if:tipo_pregunta_1,predefinida'],
            'pregunta_personalizada_1' => ['required_if:tipo_pregunta_1,personalizada', 'max:255'],
            'respuesta_seguridad_1' => ['required', 'string', 'min:3', 'max:255'],
            'tipo_pregunta_2' => ['required', 'in:predefinida,personalizada'],
            'pregunta_predefinida_2' => ['required_if:tipo_pregunta_2,predefinida'],
            'pregunta_personalizada_2' => ['required_if:tipo_pregunta_2,personalizada', 'max:255'],
            'respuesta_seguridad_2' => ['required', 'string', 'min:3', 'max:255'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.unique' => 'Este nombre de usuario ya está en uso.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'dni.required' => 'El DNI/Cédula es obligatorio.',
            'dni.unique' => 'Este DNI/Cédula ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'respuesta_seguridad_1.required' => 'Debes responder la primera pregunta de seguridad.',
            'respuesta_seguridad_2.required' => 'Debes responder la segunda pregunta de seguridad.',
            'respuesta_seguridad_1.min' => 'La respuesta debe tener al menos 3 caracteres.',
            'respuesta_seguridad_2.min' => 'La respuesta debe tener al menos 3 caracteres.',
        ]);

        $pregunta1 = $validated['tipo_pregunta_1'] === 'predefinida' 
            ? $validated['pregunta_predefinida_1'] 
            : $validated['pregunta_personalizada_1'];

        $pregunta2 = $validated['tipo_pregunta_2'] === 'predefinida' 
            ? $validated['pregunta_predefinida_2'] 
            : $validated['pregunta_personalizada_2'];

        $user->update([
            'name' => $validated['name'],
            'apellidos' => $validated['apellidos'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'dni' => $validated['dni'],
            'telefono' => $validated['telefono'] ?? null,
            'password' => Hash::make($validated['password']),
            'pregunta_seguridad_1' => $pregunta1,
            'respuesta_seguridad_1' => strtolower(trim($validated['respuesta_seguridad_1'])),
            'pregunta_seguridad_2' => $pregunta2,
            'respuesta_seguridad_2' => strtolower(trim($validated['respuesta_seguridad_2'])),
        ]);

        $user->markProfileAsCompleted();

        // ⭐ CORRECCIÓN: Pasar UN ARRAY, no parámetros separados
        BitacoraSistema::registrar([
            'accion' => 'update',
            'modulo' => 'usuarios',
            'tabla' => 'users',
            'registro_id' => $user->id,
            'descripcion' => "Usuario completó su perfil por primera vez: {$user->name} {$user->apellidos}",
            'estado' => 'exitoso',
            'datos_nuevos' => [
                'username' => $user->username,
                'email' => $user->email,
                'dni' => $user->dni,
                'telefono' => $user->telefono,
                'perfil_completado' => true,
            ],
        ]);

        return redirect($user->getDashboardRoute())
            ->with('success', '¡Perfil completado exitosamente! Bienvenido al sistema.');
    }
}