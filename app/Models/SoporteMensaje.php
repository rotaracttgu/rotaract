<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SoporteMensaje extends Model
{
    use HasFactory;

    protected $table = 'soporte_mensajes';

    protected $fillable = [
        'soporte_ticket_id',
        'sender_id',
        'message',
        'is_admin',
        'read_at',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(SoporteTicket::class, 'soporte_ticket_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
