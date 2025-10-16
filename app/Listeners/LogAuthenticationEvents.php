<?php

namespace App\Listeners;

use App\Models\BitacoraSistema;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\PasswordReset;

class LogAuthenticationEvents
{
    /**
     * Manejar evento de login exitoso
     */
    public function handleLogin(Login $event)
    {
        try {
            BitacoraSistema::registrar([
                'user_id' => $event->user->id,
                'usuario_nombre' => $event->user->name,
                'usuario_email' => $event->user->email,
                'usuario_rol' => $event->user->getRolPrincipal(),
                'accion' => 'login',
                'modulo' => 'autenticacion',
                'descripcion' => "Inicio de sesión exitoso de {$event->user->name}",
                'estado' => 'exitoso',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al registrar login en bitácora: ' . $e->getMessage());
        }
    }

    /**
     * Manejar evento de login fallido
     */
    public function handleFailed(Failed $event)
    {
        try {
            BitacoraSistema::registrar([
                'usuario_email' => $event->credentials['email'] ?? 'desconocido',
                'accion' => 'login_fallido',
                'modulo' => 'autenticacion',
                'descripcion' => "Intento fallido de inicio de sesión para: " . ($event->credentials['email'] ?? 'desconocido'),
                'estado' => 'fallido',
                'error_mensaje' => 'Credenciales inválidas',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al registrar login fallido en bitácora: ' . $e->getMessage());
        }
    }

    /**
     * Manejar evento de logout
     */
    public function handleLogout(Logout $event)
    {
        try {
            if ($event->user) {
                BitacoraSistema::registrar([
                    'user_id' => $event->user->id,
                    'usuario_nombre' => $event->user->name,
                    'usuario_email' => $event->user->email,
                    'usuario_rol' => $event->user->getRolPrincipal(),
                    'accion' => 'logout',
                    'modulo' => 'autenticacion',
                    'descripcion' => "Cierre de sesión de {$event->user->name}",
                    'estado' => 'exitoso',
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Error al registrar logout en bitácora: ' . $e->getMessage());
        }
    }

    /**
     * Manejar evento de registro de nuevo usuario
     */
    public function handleRegistered(Registered $event)
    {
        try {
            BitacoraSistema::registrar([
                'user_id' => $event->user->id,
                'usuario_nombre' => $event->user->name,
                'usuario_email' => $event->user->email,
                'accion' => 'registro',
                'modulo' => 'autenticacion',
                'tabla' => 'users',
                'registro_id' => $event->user->id,
                'descripcion' => "Nuevo usuario registrado: {$event->user->name}",
                'estado' => 'exitoso',
                'datos_nuevos' => [
                    'name' => $event->user->name,
                    'email' => $event->user->email,
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al registrar registro en bitácora: ' . $e->getMessage());
        }
    }

    /**
     * Manejar evento de cambio de contraseña
     */
    public function handlePasswordReset(PasswordReset $event)
    {
        try {
            BitacoraSistema::registrar([
                'user_id' => $event->user->id,
                'usuario_nombre' => $event->user->name,
                'usuario_email' => $event->user->email,
                'usuario_rol' => $event->user->getRolPrincipal(),
                'accion' => 'cambio_password',
                'modulo' => 'autenticacion',
                'descripcion' => "Contraseña restablecida para {$event->user->name}",
                'estado' => 'exitoso',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al registrar cambio de password en bitácora: ' . $e->getMessage());
        }
    }
}