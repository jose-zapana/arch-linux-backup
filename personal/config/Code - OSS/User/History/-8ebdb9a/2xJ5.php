<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function (\Illuminate\Routing\Router $router) {
            $router->middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
            $router->middleware('web')
                ->group(base_path('routes/web.php'));
            $router->middleware('web','auth')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        },

    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'you-webhook-endpoint/action-name' // <-- exclude this route
        ]);
    })->create();
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();


