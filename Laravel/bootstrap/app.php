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
        // Global Middleware
        $middleware->append([
            \Illuminate\Http\Middleware\TrustProxies::class,
            \Illuminate\Http\Middleware\HandleCors::class,
            \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\CheckMembershipStatus::class
        ]);

        // Route Middleware Aliases
        $middleware->alias([
            'guest.only' => \App\Http\Middleware\GuestMiddleware::class,
            'admin.only' => \App\Http\Middleware\AdminMiddleware::class,
            'user.only' => \App\Http\Middleware\UserMiddleware::class,
            'limit.detection' => \App\Http\Middleware\LimitDetection::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        ]);

        // Route Middleware Groups
        $middleware->group('web', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();