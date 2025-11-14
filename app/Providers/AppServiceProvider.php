<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notificacion;

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
                // Contar notificaciones no leídas del usuario actual
                $notificacionesNoLeidas = Notificacion::where('usuario_id', Auth::id())
                    ->where('leida', false)
                    ->count();
                $view->with('notificacionesNoLeidas', $notificacionesNoLeidas);
            }
        });
    }
}
