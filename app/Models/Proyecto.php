<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    // Usar la tabla existente
    protected $table = 'proyectos';
    protected $primaryKey = 'ProyectoID';
    public $timestamps = false; // La tabla existente no tiene timestamps

    protected $fillable = [
        'Nombre',
        'Descripcion',
        'FechaInicio',
        'FechaFin',
        'Estatus',
        'EstadoProyecto',
        'Presupuesto',
        'TipoProyecto',
        'ResponsableID',
    ];

    protected $casts = [
        'FechaInicio' => 'date',
        'FechaFin' => 'date',
        'Presupuesto' => 'decimal:2',
    ];

    // Relación con Miembro (responsable del proyecto)
    public function responsable()
    {
        return $this->belongsTo(\App\Models\Miembro::class, 'ResponsableID', 'MiembroID');
    }

    // Relación con Participaciones del módulo Vicepresidente
    public function participaciones()
    {
        return $this->hasMany(ParticipacionProyecto::class, 'proyecto_id', 'ProyectoID');
    }

    // Relación con Cartas de Patrocinio
    public function cartasPatrocinio()
    {
        return $this->hasMany(CartaPatrocinio::class, 'proyecto_id', 'ProyectoID');
    }
    
    // Relación con Participaciones existente de la tabla
    public function participacionesOriginales()
    {
        return $this->hasMany(\App\Models\Participacion::class, 'ProyectoID', 'ProyectoID');
    }
}
