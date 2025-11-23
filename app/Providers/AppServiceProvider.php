<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Notificacion;
use App\Models\User;
use App\Models\Proyecto;
use App\Observers\UserObserver;
use App\Observers\ProyectoObserver;

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
        // Registrar observers
        User::observe(UserObserver::class);
        Proyecto::observe(ProyectoObserver::class);
        
        // Super Admin tiene acceso a todo - IMPORTANTE: debe estar ANTES de otros gates
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('Super Admin')) {
                return true;
            }
        });

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
