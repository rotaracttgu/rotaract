<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\Parametro; // ⭐ NUEVO
use App\Models\User;      // ⭐ NUEVO

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string'],  // Quitamos 'email' para permitir username
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Convertir el input a mayúsculas si es nombre de usuario
        $inputValue = $this->input('email');
        
        // Determinar si el input es email o nombre de usuario
        $loginField = filter_var($inputValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        
        // Si es nombre de usuario, convertir a mayúsculas
        if ($loginField === 'name') {
            $inputValue = strtoupper($inputValue);
        }

        // ⭐ NUEVO: Buscar el usuario antes de intentar autenticar
        $user = User::where($loginField, $inputValue)->first();

        // ⭐ NUEVO: Verificar si la cuenta está bloqueada
        if ($user && $user->isAccountLocked()) {
            $minutosRestantes = $user->getRemainingLockTime();
            
            throw ValidationException::withMessages([
                'email' => "Tu cuenta ha sido bloqueada por múltiples intentos fallidos. Podrás intentar nuevamente en {$minutosRestantes} minutos o contacta al administrador.",
            ]);
        }

        // Intentar autenticar con el campo correcto
        if (!Auth::attempt([
            $loginField => $inputValue,
            'password' => $this->input('password')
        ], $this->boolean('remember'))) {
            
            // ⭐ NUEVO: Incrementar intentos fallidos si el usuario existe
            if ($user) {
                $maxIntentos = Parametro::obtener('max_intentos_login', 3);
                $user->incrementLoginAttempts();
                
                $intentosRestantes = $maxIntentos - $user->failed_login_attempts;
                
                // Si aún quedan intentos
                if ($intentosRestantes > 0) {
                    RateLimiter::hit($this->throttleKey());
                    
                    throw ValidationException::withMessages([
                        'email' => "Credenciales incorrectas. Te quedan {$intentosRestantes} intentos antes de que tu cuenta sea bloqueada.",
                    ]);
                } else {
                    // Ya se bloqueó la cuenta
                    RateLimiter::hit($this->throttleKey());
                    
                    throw ValidationException::withMessages([
                        'email' => "Tu cuenta ha sido bloqueada por exceder el número máximo de intentos fallidos. Contacta al administrador.",
                    ]);
                }
            }
            
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // ⭐ NUEVO: Login exitoso - resetear intentos
        if ($user) {
            $user->resetLoginAttempts();
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}