<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ============================================================================
// NOTIFICACIÓN DE VENCIMIENTO DE CONTRASEÑAS
// ============================================================================
// Ejecutar cada hora para enviar notificaciones de contraseñas próximas a vencer
Schedule::command('contrasenas:notificar-vencimiento')
    ->hourly()
    ->withoutOverlapping()
    ->runInBackground();
