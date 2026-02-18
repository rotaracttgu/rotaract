<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Ejecutar todos los días a las 8:00 AM la notificación de vencimiento de contraseñas
Schedule::command('contrasenas:notificar-vencimiento')
    ->dailyAt('08:00')
    ->withoutOverlapping()
    ->runInBackground();
