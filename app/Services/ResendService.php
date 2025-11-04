<?php

namespace App\Services;

use Resend\Resend;

class ResendService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Resend(env('RESEND_API_KEY'));
    }

    public function send(string $to, string $subject, string $html): void
    {
        $this->client->emails->send([
            'from' => config('mail.from.address', 'no-reply@clubrotaractsur.com'),
            'to' => [$to],
            'subject' => $subject,
            'html' => $html,
        ]);
    }
}
