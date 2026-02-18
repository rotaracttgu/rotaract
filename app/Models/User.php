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
        'rotary_id',
        'dni',
        'telefono',
        'fecha_juramentacion',
        'fecha_cumpleaños',
        'activo',
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
        'password_changed_at',
        'password_expires_at',
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
            'activo' => 'boolean',
            'fecha_juramentacion' => 'date',
            'fecha_cumpleaños' => 'date',
            'password_changed_at' => 'datetime',
            'password_expires_at' => 'datetime',
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
            return route('secretaria.dashboard');
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

    // ============================================
    // MÉTODOS DE CADUCIDAD DE CONTRASEÑA
    // ============================================

    /**
     * Verificar si la contraseña del usuario ha expirado
     */
    public function passwordExpired(): bool
    {
        if (!\App\Models\Parametro::obtener('politica_contrasenas_activa', true)) {
            return false;
        }

        if (!$this->password_expires_at) {
            return false;
        }

        return now()->greaterThan($this->password_expires_at);
    }

    /**
     * Verificar cuántos días faltan para que venza la contraseña
     * Retorna null si no hay fecha de vencimiento
     * Retorna número negativo si ya expiró
     */
    public function diasParaVencerContrasena(): ?int
    {
        if (!$this->password_expires_at) {
            return null;
        }

        return (int) now()->diffInDays($this->password_expires_at, false);
    }

    /**
     * Actualizar la contraseña y recalcular fecha de vencimiento
     */
    public function renovarContrasena(string $nuevaContrasena): void
    {
        $diasVigencia = \App\Models\Parametro::obtener('dias_vigencia_contrasena', 90);

        $this->password            = bcrypt($nuevaContrasena);
        $this->password_changed_at = now();
        $this->password_expires_at = now()->addDays($diasVigencia);
        $this->save();
    }

    /**
     * Verificar si debe mostrar aviso de próximo vencimiento
     */
    public function debeAvisarVencimiento(): bool
    {
        if (!\App\Models\Parametro::obtener('politica_contrasenas_activa', true)) {
            return false;
        }

        $dias = $this->diasParaVencerContrasena();

        if ($dias === null) {
            return false;
        }

        $diasAviso = \App\Models\Parametro::obtener('dias_aviso_contrasena', 7);

        return $dias >= 0 && $dias <= $diasAviso;
    }
}