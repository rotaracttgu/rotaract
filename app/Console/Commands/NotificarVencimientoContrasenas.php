<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Notificacion;
use App\Models\Parametro;
use App\Mail\PasswordExpirationWarningMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificarVencimientoContrasenas extends Command
{
    protected $signature   = 'contrasenas:notificar-vencimiento';
    protected $description = 'Revisa contraseñas próximas a vencer y envía notificaciones internas y por correo';

    public function handle(): int
    {
        if (!Parametro::obtener('politica_contrasenas_activa', true)) {
            $this->info('Política de contraseñas desactivada. No se procesó ningún usuario.');
            return self::SUCCESS;
        }

        $diasAviso    = (int) Parametro::obtener('dias_aviso_contrasena', 7);
        $fechaLimite  = now()->addDays($diasAviso);

        // Usuarios cuya contraseña vence en los próximos $diasAviso días (y que no ha vencido aún)
        $usuarios = User::whereNotNull('password_expires_at')
            ->where('password_expires_at', '<=', $fechaLimite)
            ->where('password_expires_at', '>=', now())
            ->where('activo', true)
            ->get();

        $this->info("Usuarios con contraseña próxima a vencer: {$usuarios->count()}");

        foreach ($usuarios as $usuario) {
            $dias = (int) now()->diffInDays($usuario->password_expires_at, false);

            $this->procesarUsuario($usuario, $dias);
        }

        // Usuarios con contraseña ya vencida (notificar una vez al día si no tienen notificación reciente)
        $vencidos = User::whereNotNull('password_expires_at')
            ->where('password_expires_at', '<', now())
            ->where('activo', true)
            ->get();

        $this->info("Usuarios con contraseña vencida: {$vencidos->count()}");

        foreach ($vencidos as $usuario) {
            $tieneNotifHoy = Notificacion::where('usuario_id', $usuario->id)
                ->where('tipo', 'contrasena_vencida')
                ->whereDate('created_at', today())
                ->exists();

            if (!$tieneNotifHoy) {
                $this->crearNotificacionInterna($usuario, 0, true);
            }
        }

        $this->info('Proceso finalizado.');
        return self::SUCCESS;
    }

    private function procesarUsuario(User $usuario, int $dias): void
    {
        // Evitar duplicar notificación del mismo día
        $tieneNotifHoy = Notificacion::where('usuario_id', $usuario->id)
            ->where('tipo', 'contrasena_por_vencer')
            ->whereDate('created_at', today())
            ->exists();

        if ($tieneNotifHoy) {
            $this->line("  ↳ {$usuario->email} ya tiene notificación hoy. Omitido.");
            return;
        }

        // Notificación interna
        $this->crearNotificacionInterna($usuario, $dias, false);

        // Correo
        try {
            Mail::to($usuario->email)->send(new PasswordExpirationWarningMail($usuario, $dias));
            $this->line("  ✉  Correo enviado a {$usuario->email} ({$dias} días restantes)");
        } catch (\Throwable $e) {
            Log::error("Error enviando correo de vencimiento a {$usuario->email}: " . $e->getMessage());
            $this->error("  ✗  Error al enviar correo a {$usuario->email}: " . $e->getMessage());
        }
    }

    private function crearNotificacionInterna(User $usuario, int $dias, bool $vencida): void
    {
        if ($vencida) {
            Notificacion::create([
                'usuario_id'      => $usuario->id,
                'tipo'            => 'contrasena_vencida',
                'titulo'          => '¡Tu contraseña ha vencido!',
                'mensaje'         => 'Tu contraseña ha caducado. Debes renovarla para poder acceder al sistema.',
                'icono'           => 'fas fa-lock',
                'color'           => 'red',
                'url'             => '/contrasena/renovar',
                'leida'           => false,
                'relacionado_tipo' => 'password_policy',
            ]);
        } else {
            $urgencia = $dias <= 2 ? '¡URGENTE! ' : '';
            Notificacion::create([
                'usuario_id'      => $usuario->id,
                'tipo'            => 'contrasena_por_vencer',
                'titulo'          => "{$urgencia}Tu contraseña vence en {$dias} día(s)",
                'mensaje'         => "Tu contraseña vencerá en {$dias} día(s). Te recomendamos renovarla pronto para evitar interrupciones en tu acceso.",
                'icono'           => $dias <= 2 ? 'fas fa-exclamation-triangle' : 'fas fa-clock',
                'color'           => $dias <= 2 ? 'red' : 'yellow',
                'url'             => '/contrasena/renovar',
                'leida'           => false,
                'relacionado_tipo' => 'password_policy',
            ]);
        }

        $this->line("  🔔 Notificación interna creada para {$usuario->email}");
    }
}
