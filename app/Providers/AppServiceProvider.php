<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // Eventos de Autenticación para Bitácora
        \Illuminate\Auth\Events\Login::class => [
            [\App\Listeners\LogAuthenticationEvents::class, 'handleLogin'],
        ],
        \Illuminate\Auth\Events\Failed::class => [
            [\App\Listeners\LogAuthenticationEvents::class, 'handleFailed'],
        ],
        \Illuminate\Auth\Events\Logout::class => [
            [\App\Listeners\LogAuthenticationEvents::class, 'handleLogout'],
        ],
        \Illuminate\Auth\Events\Registered::class => [
            SendEmailVerificationNotification::class,
            [\App\Listeners\LogAuthenticationEvents::class, 'handleRegistered'],
        ],
        \Illuminate\Auth\Events\PasswordReset::class => [
            [\App\Listeners\LogAuthenticationEvents::class, 'handlePasswordReset'],
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
