<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $table = 'documentos';
    protected $primaryKey = 'DocumentoID';
    public $incrementing = true;

    protected $fillable = [
        'Titulo',
        'tipo',
        'descripcion',
        'archivo_path',
        'archivo_nombre',
        'categoria',
        'creado_por',
        'visible_para_todos',
    ];

    protected $casts = [
        'visible_para_todos' => 'boolean',
    ];

    /**
     * Atributos que deben ser agregados al array/JSON
     */
    protected $appends = ['archivo_url', 'titulo'];

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
    
    /**
     * Accessor para obtener el título (compatibilidad con JavaScript)
     */
    public function getTituloAttribute()
    {
        return $this->attributes['Titulo'] ?? null;
    }
    
    /**
     * Mutator para establecer el título
     */
    public function setTituloAttribute($value)
    {
        $this->attributes['Titulo'] = $value;
    }
}

