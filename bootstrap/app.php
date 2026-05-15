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
        // هذا السطر يحل مشكلة 419 Page Expired للأبد على Render
        $middleware->trustProxies(at: '*');
        
        // تعريف الـ Aliases للـ Middlewares ليتوافق مع لارافيل 11 ومسارات الـ web.php
        $middleware->alias([
            'admin' => \App\Http\Middleware\IsAdmin::class,
            'role'  => \App\Http\Middleware\Role::class, // تم إضافة هذا السطر لحل مشكلة Target class [role] does not exist
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
