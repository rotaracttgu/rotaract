<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presupuesto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'presupuestos_categorias';
    protected $guarded = [];

    protected $fillable = [
        'categoria',
        'monto_presupuestado',
        'monto_gastado',
        'periodo',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'observaciones',
        'usuario_id',
    ];

    protected $casts = [
        'periodo' => 'date',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'monto_presupuestado' => 'decimal:2',
        'monto_gastado' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(\App\Models\User::class, 'usuario_id');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    public function scopePorPeriodo($query, $periodo)
    {
        return $query->where('periodo', $periodo);
    }

    // Métodos útiles
    public function getMontoRestanteAttribute()
    {
        return max(0, $this->monto_presupuestado - $this->monto_gastado);
    }

    public function getPorcentajeUsadoAttribute()
    {
        if ($this->monto_presupuestado == 0) {
            return 0;
        }
        return round(($this->monto_gastado / $this->monto_presupuestado) * 100, 2);
    }

    public function getEstadoBudgetAttribute()
    {
        if ($this->porcentaje_usado > 100) {
            return 'Excedido';
        } elseif ($this->porcentaje_usado > 80) {
            return 'Alerta';
        }
        return 'Normal';
    }
}
