<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Miembro extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'miembros';
    
    // Llave primaria
    protected $primaryKey = 'MiembroID';
    
    // Laravel no manejará timestamps automáticamente porque tu tabla no tiene created_at/updated_at
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'DNI_Pasaporte',
        'Nombre',
        'Rol',
        'Correo',
        'FechaIngreso',
        'Apuntes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'FechaIngreso' => 'date',
    ];

    /**
     * Relación: Un miembro puede tener un usuario del sistema (1:1)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relación: Un miembro puede tener varios teléfonos
     */
    public function telefonos()
    {
        return $this->hasMany(Telefono::class, 'MiembroID', 'MiembroID');
    }

    /**
     * Relación: Un miembro puede participar en varios proyectos
     */
    public function participaciones()
    {
        return $this->hasMany(Participacion::class, 'MiembroID', 'MiembroID');
    }

    /**
     * Relación: Un miembro puede tener varios pagos de membresía
     */
    public function pagosmembresia()
    {
        return $this->hasMany(PagoMembresia::class, 'MiembroID', 'MiembroID');
    }

    /**
     * Relación: Un miembro puede tener asistencias registradas
     */
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'MiembroID', 'MiembroID');
    }

    /**
     * Relación: Un miembro puede tener documentos asociados
     */
    public function documentos()
    {
        return $this->hasMany(Documento::class, 'MiembroID', 'MiembroID');
    }

    /**
     * Relación: Un miembro puede ser responsable de proyectos
     */
    public function proyectosResponsable()
    {
        return $this->hasMany(Proyecto::class, 'ResponsableID', 'MiembroID');
    }

    /**
     * Relación: Un miembro puede tener movimientos financieros
     */
    public function movimientos()
    {
        return $this->hasMany(Movimiento::class, 'MiembroID', 'MiembroID');
    }

    /**
     * Scope: Obtener solo miembros activos (que tienen usuario del sistema)
     */
    public function scopeConUsuario($query)
    {
        return $query->whereNotNull('user_id');
    }

    /**
     * Scope: Obtener miembros sin usuario del sistema
     */
    public function scopeSinUsuario($query)
    {
        return $query->whereNull('user_id');
    }

    /**
     * Verificar si el miembro tiene acceso al sistema
     */
    public function tieneAccesoSistema()
    {
        return !is_null($this->user_id);
    }

    /**
     * Obtener el rol del sistema (no el rol del club)
     */
    public function getRolSistema()
    {
        if ($this->user) {
            return $this->user->roles->first()?->name;
        }
        return null;
    }
}