<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartaFormal extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_carta',
        'destinatario',
        'asunto',
        'contenido',
        'tipo', // Invitacion, Agradecimiento, Solicitud, Notificacion, Otro
        'estado', // Borrador, Enviada, Recibida
        'fecha_envio',
        'usuario_id',
        'observaciones',
    ];

    protected $casts = [
        'fecha_envio' => 'date',
    ];

    // Relación con Usuario (quien creó la carta)
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
