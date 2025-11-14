<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $table = 'consultas';

    protected $fillable = [
        'usuario_id',
        'asunto',
        'mensaje',
        'estado',
        'respuesta',
        'respondido_por',
        'respondido_at',
        'prioridad',
    ];

    protected $casts = [
        'respondido_at' => 'datetime',
    ];

    /**
     * Relación con el usuario que hizo la consulta
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Relación con el usuario que respondió
     */
    public function respondedor()
    {
        return $this->belongsTo(User::class, 'respondido_por');
    }
}
