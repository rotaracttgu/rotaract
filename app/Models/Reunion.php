<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reunion extends Model
{
    use HasFactory;

    protected $table = 'reunions';

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_hora',
        'lugar',
        'tipo',
        'estado',
        'asistentes_esperados',
        'observaciones',
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
        'asistentes_esperados' => 'integer',
    ];

    // Relación con Asistencias
    public function asistencias()
    {
        return $this->hasMany(AsistenciaReunion::class);
    }

    // Calcular porcentaje de asistencia
    public function porcentajeAsistencia()
    {
        $totalAsistentes = $this->asistencias()->where('asistio', true)->count();
        return $this->asistentes_esperados > 0 
            ? round(($totalAsistentes / $this->asistentes_esperados) * 100, 2) 
            : 0;
    }
}
