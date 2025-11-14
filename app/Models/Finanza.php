<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Finanza extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'periodo',
        'total_ingresos',
        'total_egresos',
        'balance',
        'saldo_anterior',
        'saldo_actual',
        'observaciones',
        'estado'
    ];

    protected $casts = [
        'periodo' => 'date',
        'total_ingresos' => 'decimal:2',
        'total_egresos' => 'decimal:2',
        'balance' => 'decimal:2',
        'saldo_anterior' => 'decimal:2',
        'saldo_actual' => 'decimal:2'
    ];

    // Métodos
    public function calcularBalance()
    {
        $this->balance = $this->total_ingresos - $this->total_egresos;
        $this->saldo_actual = $this->saldo_anterior + $this->balance;
        return $this;
    }

    public function actualizarTotales()
    {
        $fechaInicio = $this->periodo->startOfMonth();
        $fechaFin = $this->periodo->endOfMonth();

        $this->total_ingresos = Ingreso::totalPorPeriodo($fechaInicio, $fechaFin);
        $this->total_egresos = Egreso::totalPorPeriodo($fechaInicio, $fechaFin);
        
        return $this->calcularBalance();
    }

    public static function obtenerOCrearPeriodo($fecha)
    {
        $periodo = now()->parse($fecha)->startOfMonth();
        
        return self::firstOrCreate(
            ['periodo' => $periodo],
            [
                'total_ingresos' => 0,
                'total_egresos' => 0,
                'balance' => 0,
                'saldo_anterior' => 0,
                'saldo_actual' => 0
            ]
        );
    }
}