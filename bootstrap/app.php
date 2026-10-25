<?php

use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'excel/import/*',
            'payment/*',
            '/shared/*'
        ]);
        $middleware->alias(
            [
                'is_admin' => \App\Http\Middleware\IsAdmin::class,
                'is_support' => \App\Http\Middleware\IsSupport::class,
                'is_teacher' => \App\Http\Middleware\IsTeacher::class,
                'Excel' => Maatwebsite\Excel\Facades\Excel::class,
            ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
