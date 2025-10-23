<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Opción Registered es FUNDAMENTAL para configura PUBLIC PATH en el servidor
return Application::configure(basePath: dirname(__DIR__))

    // ->registered(function ($app) {
    //     $path = realpath(base_path('/../www'));
    //     $app->usePublicPath(realpath(base_path('/../www')));
    // })

    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->web(append:[
            App\Http\Middleware\LocalMiddleware::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
