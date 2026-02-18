<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordExpirationWarningMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $usuario,
        public int  $diasRestantes
    ) {}

    public function envelope(): Envelope
    {
        $asunto = $this->diasRestantes === 0
            ? '¡Tu contraseña ha vencido! - Renuévala ahora'
            : "⚠️ Tu contraseña vence en {$this->diasRestantes} día(s) - Rotaract";

        return new Envelope(subject: $asunto);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.password-expiration-warning');
    }

    public function attachments(): array
    {
        return [];
    }
}
