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

        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'check.user.status' => \App\Http\Middleware\CheckUserStatus::class,
            'signed.url' => \App\Http\Middleware\SignedUrl::class,
        ]);

    $middleware->web(append: [
            \App\Http\Middleware\CheckUserStatus::class,
    ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
