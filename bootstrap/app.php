<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Http\Middleware\EnsureOnboardingComplete;
use App\Http\Middleware\EnsureUserHasAccessLevel;
use App\Http\Middleware\CheckFeature;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Daftarkan middleware alias
        $middleware->alias([
            'onboarding.complete' => EnsureOnboardingComplete::class,
            'access' => EnsureUserHasAccessLevel::class,
            'feature' => CheckFeature::class,
        ]);

        // Webhook Midtrans dikecualikan dari CSRF -- request-nya dari server
        // Midtrans, bukan dari browser user, jadi nggak bisa bawa CSRF token
        $middleware->validateCsrfTokens(except: [
            'midtrans/notification',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();