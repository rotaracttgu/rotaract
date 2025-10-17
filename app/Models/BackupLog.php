<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BackupLog extends Model
{
    protected $table = 'backup_logs';
    
    public $timestamps = false;
    
    protected $fillable = [
        'backup_id',
        'tipo_log',
        'mensaje',
        'fecha_log'
    ];

    protected $casts = [
        'fecha_log' => 'datetime',
    ];

    public function backup(): BelongsTo
    {
        return $this->belongsTo(Backup::class);
    }
}