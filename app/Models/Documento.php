<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $table = 'documentos';

    protected $fillable = [
        'titulo',
        'tipo',
        'descripcion',
        'archivo_path',
        'archivo_nombre',
        'categoria',
        'creado_por',
    ];

    /**
     * Atributos que deben ser agregados al array/JSON
     */
    protected $appends = ['archivo_url'];

    /**
     * Relación con el usuario que creó el documento
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
