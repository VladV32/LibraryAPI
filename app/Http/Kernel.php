<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        //
    ];

    protected $middlewareGroups = [
        'web' => [
            //
        ],

        'api' => [
            \Illuminate\Session\Middleware\StartSession::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Laravel\Passport\Http\Middleware\CreateFreshApiToken::class,
        ],
    ];

    protected $routeMiddleware = [
        'auth:api' => \Laravel\Passport\Http\Middleware\CheckCredentials::class,
    ];
}
