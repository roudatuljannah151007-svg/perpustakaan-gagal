<?php

ini_set('display_errors', '1');
error_reporting(E_ALL);

header('Content-Type: text/plain; charset=utf-8');

try {
    define('LARAVEL_START', microtime(true));

    require __DIR__.'/../vendor/autoload.php';

    $app = require_once __DIR__.'/../bootstrap/app.php';

    $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
    $request = \Illuminate\Http\Request::capture();

    $response = $kernel->handle($request);

    echo "STATUS: " . $response->getStatusCode() . "\n";
    echo "LOCATION: " . ($response->headers->get('Location') ?? 'none') . "\n";
    echo "RESPONSE BODY:\n";
    echo $response->getContent();

} catch (\Throwable $e) {
    http_response_code(500);
    echo "\nERROR: " . get_class($e) . "\n";
    echo "MESSAGE: " . $e->getMessage() . "\n";
    echo "FILE: " . $e->getFile() . "\n";
    echo "LINE: " . $e->getLine() . "\n";
}
