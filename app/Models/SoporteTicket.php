<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SoporteTicket extends Model
{
    use HasFactory;

    protected $table = 'soporte_tickets';

    protected $fillable = [
        'user_id',
        'subject',
        'status',
        'priority',
        'last_user_message_at',
        'last_admin_message_at',
        'responded_at',
        'closed_at',
    ];

    protected $casts = [
        'last_user_message_at' => 'datetime',
        'last_admin_message_at' => 'datetime',
        'responded_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mensajes(): HasMany
    {
        return $this->hasMany(SoporteMensaje::class, 'soporte_ticket_id');
    }

    public function ultimoMensaje(): HasOne
    {
        return $this->hasOne(SoporteMensaje::class, 'soporte_ticket_id')->latestOfMany();
    }
}
