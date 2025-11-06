<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';

    protected $fillable = [
        'usuario_id',
        'tipo',
        'titulo',
        'mensaje',
        'icono',
        'color',
        'url',
        'leida',
        'leida_en',
        'relacionado_id',
        'relacionado_tipo',
    ];

    protected $casts = [
        'leida' => 'boolean',
        'leida_en' => 'datetime',
    ];

    /**
     * Relación con el usuario que recibe la notificación
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Marcar la notificación como leída
     */
    public function marcarComoLeida()
    {
        $this->update([
            'leida' => true,
            'leida_en' => now(),
        ]);
    }

    /**
     * Scope para obtener solo notificaciones no leídas
     */
    public function scopeNoLeidas($query)
    {
        return $query->where('leida', false);
    }

    /**
     * Scope para obtener notificaciones por tipo
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Scope para obtener notificaciones del usuario actual
     */
    public function scopeDelUsuario($query, $usuarioId)
    {
        return $query->where('usuario_id', $usuarioId);
    }
}
