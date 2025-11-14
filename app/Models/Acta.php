<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acta extends Model
{
    use HasFactory;

    protected $table = 'actas';

    protected $fillable = [
        'titulo',
        'fecha_reunion',
        'tipo_reunion',
        'contenido',
        'asistentes',
        'archivo_path',
        'creado_por',
    ];

    protected $casts = [
        'fecha_reunion' => 'date',
    ];

    /**
     * Atributos que deben ser agregados al array/JSON
     */
    protected $appends = ['archivo_url'];

    /**
     * Relación con el usuario que creó el acta
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    /**
     * Accessor para obtener la URL del archivo
     */
    public function getArchivoUrlAttribute()
    {
        return $this->archivo_path ? asset('storage/' . $this->archivo_path) : null;
    }
}
