<?php

// Set environment to production
$_ENV['APP_ENV'] = $_ENV['APP_ENV'] ?? 'production';
$_ENV['APP_DEBUG'] = $_ENV['APP_DEBUG'] ?? false;

// Redirect writable paths to Vercel /tmp directory
$_ENV['APP_STORAGE'] = '/tmp/storage';

if (!is_dir('/tmp/storage')) {
    mkdir('/tmp/storage', 0755, true);
    mkdir('/tmp/storage/framework', 0755, true);
    mkdir('/tmp/storage/framework/views', 0755, true);
    mkdir('/tmp/storage/framework/cache', 0755, true);
    mkdir('/tmp/storage/framework/sessions', 0755, true);
    mkdir('/tmp/storage/logs', 0755, true);
}

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

// Force Laravel storage path to /tmp/storage
$app->useStoragePath('/tmp/storage');

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);