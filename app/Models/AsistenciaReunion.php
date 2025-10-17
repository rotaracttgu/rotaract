<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsistenciaReunion extends Model
{
    use HasFactory;

    protected $table = 'asistencias_reunions';

    protected $fillable = [
        'reunion_id',
        'usuario_id',
        'asistio',
        'hora_llegada',
        'tipo_asistencia',
        'observaciones',
    ];

    protected $casts = [
        'asistio' => 'boolean',
    ];

    // Relación con Reunion
    public function reunion()
    {
        return $this->belongsTo(Reunion::class);
    }

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
