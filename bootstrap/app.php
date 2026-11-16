<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Jika berjalan di Vercel, paksa arahkan storage path ke /tmp secara global via env
if (isset($_ENV['VERCEL']) || is_dir('/tmp')) {
    $tmpStorage = '/tmp/storage';
    if (!is_dir($tmpStorage)) {
        mkdir($tmpStorage, 0777, true);
        mkdir($tmpStorage . '/framework/views', 0777, true);
        mkdir($tmpStorage . '/framework/cache', 0777, true);
        mkdir($tmpStorage . '/framework/sessions', 0777, true);
        mkdir($tmpStorage . '/logs', 0777, true);
    }
    $_ENV['APP_STORAGE'] = $tmpStorage;
    putenv('APP_STORAGE=' . $tmpStorage);
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();