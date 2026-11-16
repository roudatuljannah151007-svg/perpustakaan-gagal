<?php

// Paksa buat folder /tmp/storage terlebih dahulu sebelum apapun dieksekusi
$tmpStorage = '/tmp/storage';
if (!is_dir($tmpStorage)) {
    mkdir($tmpStorage, 0777, true);
    mkdir($tmpStorage . '/framework/views', 0777, true);
    mkdir($tmpStorage . '/framework/cache', 0777, true);
    mkdir($tmpStorage . '/framework/sessions', 0777, true);
    mkdir($tmpStorage . '/logs', 0777, true);
}

// Override path storage lewat environment PHP secara langsung
$_ENV['APP_STORAGE'] = $tmpStorage;
putenv('APP_STORAGE=' . $tmpStorage);

// HACK: Paksa bind path storage Laravel agar mengarah ke /tmp sebelum kernel jalan
$__storage_path = function ($path = '') use ($tmpStorage) {
    return $tmpStorage . ($path ? DIRECTORY_SEPARATOR . $path : '');
};

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

// Pastikan instance app mengarahkan path storage ke /tmp
if (method_exists($app, 'useStoragePath')) {
    $app->useStoragePath($tmpStorage);
}

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
);

$response->send();

$kernel->terminate($request, $response);