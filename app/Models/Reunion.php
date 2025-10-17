<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reunion extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo', // directiva, general, comite, extraordinaria
        'fecha',
        'hora',
        'lugar',
        'total_esperados',
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora' => 'datetime',
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
        return $this->total_esperados > 0 
            ? round(($totalAsistentes / $this->total_esperados) * 100, 2) 
            : 0;
    }
}
