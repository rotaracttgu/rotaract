<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Egreso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gastos';
    protected $guarded = [];

    protected $fillable = [
        'descripcion',
        'categoria',
        'monto',
        'fecha',
        'proveedor',
        'metodo_pago',
        'comprobante',
        'referencia',
        'notas',
        'usuario_registro_id',
        'usuario_aprobacion_id',
        'estado',
        'tipo',
        'cuenta_origen',
        'cuenta_destino',
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

    public function usuarioAprobacion()
    {
        return $this->belongsTo(\App\Models\User::class, 'usuario_aprobacion_id');
    }

    // Scopes
    public function scopeAprobados($query)
    {
        return $query->where('estado', 'aprobado');
    }

    public function scopePagados($query)
    {
        return $query->where('estado', 'pagado');
    }

    public function scopePorCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    public function scopePorFecha($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
    }

    public function scopePendientesAprobacion($query)
    {
        return $query->where('estado', 'pendiente')->whereNull('usuario_aprobacion_id');
    }

    // Métodos
    public static function totalPorPeriodo($fechaInicio, $fechaFin)
    {
        return self::pagados()
                   ->porFecha($fechaInicio, $fechaFin)
                   ->sum('monto');
    }

    public static function totalPorCategoria($categoria, $fechaInicio, $fechaFin)
    {
        return self::pagados()
                   ->porCategoria($categoria)
                   ->porFecha($fechaInicio, $fechaFin)
                   ->sum('monto');
    }
}
