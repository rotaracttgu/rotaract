<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipacionProyecto extends Model
{
    use HasFactory;

    protected $fillable = [
        'proyecto_id',
        'usuario_id',
        'nivel_involucramiento', // alto, medio, bajo
        'actividades_realizadas',
        'observaciones',
    ];

    protected $casts = [
        'actividades_realizadas' => 'integer',
    ];

    // Relación con Proyecto (tabla existente 'proyectos')
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id', 'ProyectoID');
    }

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
