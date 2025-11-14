<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartaPatrocinio extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_carta',
        'destinatario',
        'descripcion',
        'monto_solicitado',
        'estado', // Pendiente, Aprobada, Rechazada, En Revision
        'fecha_solicitud',
        'fecha_respuesta',
        'proyecto_id',
        'usuario_id',
        'observaciones',
    ];

    protected $casts = [
        'fecha_solicitud' => 'date',
        'fecha_respuesta' => 'date',
        'monto_solicitado' => 'decimal:2',
    ];

    // Relación con Proyecto (tabla existente 'proyectos')
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id', 'ProyectoID');
    }

    // Relación con Usuario (quien creó la carta)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
