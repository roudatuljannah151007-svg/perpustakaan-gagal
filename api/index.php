<?php

// 1. Buat folder sementara di /tmp untuk Vercel
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

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 2. Load Composer Autoloader
require __DIR__.'/../vendor/autoload.php';

// 3. Boot aplikasi Laravel (cukup satu kali menggunakan require_once)
$app = require_once __DIR__.'/../bootstrap/app.php';

// 4. Buat Http Kernel dan handle request dengan benar
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
);

$response->send();

$kernel->terminate($request, $response);