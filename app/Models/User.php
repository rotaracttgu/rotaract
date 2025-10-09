<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'two_factor_enabled',
        'two_factor_code',
        'two_factor_expires_at',
        'two_factor_verified_at', // ← AGREGADO
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_code',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_enabled' => 'boolean',
            'two_factor_expires_at' => 'datetime',
            'two_factor_verified_at' => 'datetime', // ← AGREGADO
        ];
    }

    /**
     * Relación: Un usuario puede estar asociado a un miembro del club (1:1)
     */
    public function miembro()
    {
        return $this->hasOne(Miembro::class, 'user_id', 'id');
    }

    /**
     * Verificar si el usuario es Super Admin
     */
    public function isSuperAdmin()
    {
        return $this->hasRole('Super Admin');
    }

    /**
     * Verificar si el usuario es Presidente
     */
    public function isPresidente()
    {
        return $this->hasRole('Presidente');
    }

    /**
     * Verificar si el usuario es Vicepresidente
     */
    public function isVicepresidente()
    {
        return $this->hasRole('Vicepresidente');
    }

    /**
     * Verificar si el usuario es Tesorero
     */
    public function isTesorero()
    {
        return $this->hasRole('Tesorero');
    }

    /**
     * Verificar si el usuario es Secretario
     */
    public function isSecretario()
    {
        return $this->hasRole('Secretario');
    }

    /**
     * Verificar si el usuario es Vocero
     */
    public function isVocero()
    {
        return $this->hasRole('Vocero');
    }

    /**
     * Verificar si el usuario es Aspirante
     */
    public function isAspirante()
    {
        return $this->hasRole('Aspirante');
    }

    /**
     * Obtener el dashboard correspondiente según el rol (retorna la URL)
     */
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
        
        return route('dashboard'); // Dashboard por defecto
    }

    /**
     * Obtener el nombre del rol principal
     */
    public function getRolPrincipal()
    {
        return $this->roles->first()?->name ?? 'Sin Rol';
    }

    /**
     * Verificar si el código 2FA es válido
     */
    public function isValidTwoFactorCode($code)
    {
        return $this->two_factor_code === $code && 
               $this->two_factor_expires_at > now();
    }
}