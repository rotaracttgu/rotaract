<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Backup extends Model
{
    protected $table = 'backups';
    
    protected $fillable = [
        'nombre_archivo',
        'tipo',
        'ruta_archivo',
        'tamaño',
        'estado',
        'descripcion',
        'error_mensaje',
        'user_id',
        'fecha_ejecucion'
    ];

    protected $casts = [
        'fecha_ejecucion' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(BackupLog::class);
    }
}