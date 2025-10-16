<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Registrar middleware de Spatie
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);

        // Registrar middleware personalizado
        $middleware->alias([
            'ensure.role' => \App\Http\Middleware\EnsureUserHasRole::class,
            'check.first.login' => \App\Http\Middleware\CheckFirstLogin::class, // ⭐ NUEVO
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();