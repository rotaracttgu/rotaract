<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ingreso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ingresos';
    protected $guarded = [];

    protected $fillable = [
        'descripcion',
        'categoria',
        'monto',
        'fecha',
        'fuente',
        'metodo_pago',
        'comprobante',
        'referencia',
        'notas',
        'usuario_registro_id',
        'estado',
    ];

    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relaciones
    public function usuarioRegistro()
    {
        return $this->belongsTo(\App\Models\User::class, 'usuario_registro_id');
    }

    // Scopes
    public function scopeConfirmados($query)
    {
        return $query->where('estado', 'confirmado');
    }

    public function scopePorCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    public function scopePorFecha($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
    }

    // Métodos
    public static function totalPorPeriodo($fechaInicio, $fechaFin)
    {
        return self::confirmados()
                   ->porFecha($fechaInicio, $fechaFin)
                   ->sum('monto');
    }
}