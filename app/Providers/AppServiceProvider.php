<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Compartir contador de notificaciones en todas las vistas
        View::composer('*', function ($view) {
            if (Auth::check()) {
                // Por ahora, un número de ejemplo. Luego puedes conectar con tu tabla de notificaciones
                $notificacionesNoLeidas = 3;
                $view->with('notificacionesNoLeidas', $notificacionesNoLeidas);
            }
        });
    }
}
