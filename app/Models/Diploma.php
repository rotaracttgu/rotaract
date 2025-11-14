<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diploma extends Model
{
    use HasFactory;

    protected $table = 'diplomas';

    protected $fillable = [
        'miembro_id',
        'tipo',
        'motivo',
        'fecha_emision',
        'archivo_path',
        'emitido_por',
        'enviado_email',
        'fecha_envio_email',
    ];

    protected $casts = [
        'fecha_emision' => 'date',
        'fecha_envio_email' => 'datetime',
        'enviado_email' => 'boolean',
    ];

    /**
     * Atributos que deben ser agregados al array/JSON
     */
    protected $appends = ['archivo_url'];

    /**
     * Relación con el miembro que recibe el diploma
     */
    public function miembro()
    {
        return $this->belongsTo(User::class, 'miembro_id');
    }

    /**
     * Relación con el usuario que emitió el diploma
     */
    public function emisor()
    {
        return $this->belongsTo(User::class, 'emitido_por');
    }

    /**
     * Relación con la tabla miembros (si existe)
     */
    public function miembroDetalle()
    {
        return $this->hasOneThrough(
            Miembro::class,
            User::class,
            'id', // Clave foránea en users
            'user_id', // Clave foránea en miembros
            'miembro_id', // Clave local en diplomas
            'id' // Clave local en users
        );
    }

    /**
     * Accessor para obtener la URL del archivo
     */
    public function getArchivoUrlAttribute()
    {
        return $this->archivo_path ? asset('storage/' . $this->archivo_path) : null;
    }
}
