<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PagoMembresia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'membresias';
    protected $guarded = [];

    protected $fillable = [
        'usuario_id',
        'miembro_id',
        'tipo_pago',
        'tipo_membresia',
        'monto',
        'fecha_pago',
        'fecha_vencimiento',
        'metodo_pago',
        'periodo_inicio',
        'periodo_fin',
        'comprobante',
        'numero_comprobante',
        'numero_referencia',
        'banco_origen',
        'notas',
        'estado',
    ];

    protected $casts = [
        'fecha_pago' => 'date',
        'fecha_vencimiento' => 'date',
        'periodo_inicio' => 'date',
        'periodo_fin' => 'date',
        'monto' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function scopeActivas($query)
    {
        return $query->where('estado', 'activa');
    }

    public function scopeVencidas($query)
    {
        return $query->where('estado', 'vencida');
    }

    public function scopePorPeriodo($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha_pago', [$fechaInicio, $fechaFin]);
    }
}
