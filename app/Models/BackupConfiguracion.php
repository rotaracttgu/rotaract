<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackupConfiguracion extends Model
{
    protected $table = 'backup_configuraciones';
    
    protected $fillable = [
        'frecuencia',
        'hora_programada',
        'activo',
        'dias_semana',
        'dia_mes',
        'ultima_ejecucion',
        'proxima_ejecucion'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'ultima_ejecucion' => 'datetime',
        'proxima_ejecucion' => 'datetime',
    ];
}