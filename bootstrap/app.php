<?php

use App\Http\Middleware\AdminAuthenticator;
use App\Http\Middleware\UserAuthenticator;
use App\Http\Middleware\ManagerAuthenticator;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'user' => UserAuthenticator::class,
            'manager' => ManagerAuthenticator::class,
            'admin' => AdminAuthenticator::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
