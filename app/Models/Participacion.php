<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participacion extends Model
{
    use HasFactory;

    protected $table = 'participaciones';
    protected $primaryKey = 'ParticipacionID';
    public $timestamps = false;

    protected $fillable = [
        'MiembroID',
        'ProyectoID',
        'Rol',
        'FechaIngreso',
        'FechaSalida',
        'EstadoParticipacion',
    ];

    protected $casts = [
        'FechaIngreso' => 'date',
        'FechaSalida' => 'date',
    ];

    /**
     * Relación con Miembro
     */
    public function miembro()
    {
        return $this->belongsTo(Miembro::class, 'MiembroID', 'MiembroID');
    }

    /**
     * Relación con Proyecto
     */
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'ProyectoID', 'ProyectoID');
    }
}
