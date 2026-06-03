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
    ->withMiddleware(function (Middleware $middleware) {
        // Tambahkan baris ini untuk mengatasi error HTTPS di Railway
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'isAdmin'   => \App\Http\Middleware\IsAdmin::class,
            'isAnggota' => \App\Http\Middleware\IsAnggota::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();