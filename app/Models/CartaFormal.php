<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartaFormal extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_envio',
        'destinatario',
        'contacto',
        'tipo', // invitacion, agradecimiento, solicitud, notificacion, felicitacion, comunicado
        'asunto',
        'contenido',
        'estado', // enviada, borrador
        'respuesta_recibida',
        'fecha_respuesta',
        'usuario_id',
    ];

    protected $casts = [
        'fecha_envio' => 'date',
        'fecha_respuesta' => 'date',
        'respuesta_recibida' => 'boolean',
    ];

    // Relación con Usuario (quien creó la carta)
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
