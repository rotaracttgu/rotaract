<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartaPatrocinio extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_envio',
        'destinatario',
        'contacto',
        'proyecto_id',
        'monto_solicitado',
        'estado', // enviada, respondida, pendiente, sin_respuesta
        'fecha_respuesta',
        'contenido',
        'usuario_id',
    ];

    protected $casts = [
        'fecha_envio' => 'date',
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
