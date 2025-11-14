<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, LogsActivity;

    protected $fillable = [
        'name',
        'apellidos',
        'username',
        'email',
        'dni',
        'telefono',
        'password',
        'first_login',
        'pregunta_seguridad_1',
        'respuesta_seguridad_1',
        'pregunta_seguridad_2',
        'respuesta_seguridad_2',
        'profile_completed_at',
        'two_factor_enabled',
        'two_factor_code',
        'two_factor_expires_at',
        'two_factor_verified_at',
        'failed_login_attempts',
        'locked_until',
        'is_locked',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_code',
        'respuesta_seguridad_1',
        'respuesta_seguridad_2',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'first_login' => 'boolean',
            'profile_completed_at' => 'datetime',
            'two_factor_enabled' => 'boolean',
            'two_factor_expires_at' => 'datetime',
            'two_factor_verified_at' => 'datetime',
            'locked_until' => 'datetime',
            'is_locked' => 'boolean',
        ];
    }

    protected $sensitiveAttributes = [
        'password',
        'remember_token',
        'two_factor_code',
        'respuesta_seguridad_1',
        'respuesta_seguridad_2',
    ];

    public function getActivityDescription($action)
    {
        $descriptions = [
            'created' => "Nuevo usuario registrado: {$this->name}",
            'updated' => "Usuario actualizado: {$this->name}",
            'deleted' => "Usuario eliminado: {$this->name}",
            'restored' => "Usuario restaurado: {$this->name}",
        ];

        return $descriptions[$action] ?? "Acción {$action} en usuario: {$this->name}";
    }

    public function bitacoras()
    {
        return $this->hasMany(BitacoraSistema::class, 'user_id');
    }

    public function miembro()
    {
        return $this->hasOne(Miembro::class, 'user_id', 'id');
    }

    // ============================================
    // MÉTODOS DE ROLES
    // ============================================

    public function isSuperAdmin()
    {
        return $this->hasRole('Super Admin');
    }

    public function isPresidente()
    {
        return $this->hasRole('Presidente');
    }

    public function isVicepresidente()
    {
        return $this->hasRole('Vicepresidente');
    }

    public function isTesorero()
    {
        return $this->hasRole('Tesorero');
    }

    public function isSecretario()
    {
        return $this->hasRole('Secretario');
    }

    public function isVocero()
    {
        return $this->hasRole('Vocero');
    }

    public function isAspirante()
    {
        return $this->hasRole('Aspirante');
    }

    public function getDashboardRoute()
    {
        if ($this->isSuperAdmin()) {
            return route('admin.dashboard');
        } elseif ($this->isPresidente()) {
            return route('presidente.dashboard');
        } elseif ($this->isVicepresidente()) {
            return route('vicepresidente.dashboard');
        } elseif ($this->isTesorero()) {
            return route('tesorero.dashboard');
        } elseif ($this->isSecretario()) {
            return route('secretario.dashboard');
        } elseif ($this->isVocero()) {
            return route('vocero.dashboard');
        } elseif ($this->isAspirante()) {
            return route('aspirante.dashboard');
        }
        
        return route('dashboard');
    }

    public function getRolPrincipal()
    {
        return $this->roles->first()?->name ?? 'Sin Rol';
    }

    // ============================================
    // MÉTODOS 2FA
    // ============================================

    public function isValidTwoFactorCode($code)
    {
        return $this->two_factor_code === $code && 
               $this->two_factor_expires_at > now();
    }

    // ============================================
    // MÉTODOS PARA BLOQUEO DE CUENTAS
    // ============================================

    public function isAccountLocked(): bool
    {
        if (!$this->is_locked) {
            return false;
        }

        if ($this->locked_until && now()->greaterThan($this->locked_until)) {
            $this->unlock();
            return false;
        }

        return true;
    }

    public function incrementLoginAttempts(): void
    {
        $maxIntentos = Parametro::obtener('max_intentos_login', 3);
        
        $this->failed_login_attempts++;
        
        if ($this->failed_login_attempts >= $maxIntentos) {
            $this->lockAccount();
        }
        
        $this->save();
    }

    public function lockAccount(): void
    {
        $tiempoBloqueo = Parametro::obtener('tiempo_bloqueo_minutos', 15);
        
        $this->is_locked = true;
        $this->locked_until = now()->addMinutes($tiempoBloqueo);
        $this->save();
    }

    public function unlock(): void
    {
        $this->is_locked = false;
        $this->locked_until = null;
        $this->failed_login_attempts = 0;
        $this->save();
    }

    public function resetLoginAttempts(): void
    {
        $this->failed_login_attempts = 0;
        $this->is_locked = false;
        $this->locked_until = null;
        $this->save();
    }

    public function getRemainingLockTime(): int
    {
        if (!$this->is_locked || !$this->locked_until) {
            return 0;
        }

        return max(0, now()->diffInMinutes($this->locked_until, false));
    }

    // ============================================
    // ⭐ NUEVOS MÉTODOS PARA PRIMER LOGIN
    // ============================================

    /**
     * Verificar si es el primer login del usuario
     */
    public function isFirstLogin(): bool
    {
        return $this->first_login === true;
    }

    /**
     * Marcar el perfil como completado
     */
    public function markProfileAsCompleted(): void
    {
        $this->first_login = false;
        $this->profile_completed_at = now();
        $this->save();
    }

    /**
     * Verificar respuesta de seguridad
     */
    public function checkSecurityAnswer(int $questionNumber, string $answer): bool
    {
        $column = "respuesta_seguridad_{$questionNumber}";
        return strtolower(trim($this->$column)) === strtolower(trim($answer));
    }

    /**
     * Obtener nombre completo
     */
    public function getNombreCompletoAttribute(): string
    {
        return trim($this->name . ' ' . $this->apellidos);
    }
}