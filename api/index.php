<?php

ini_set('display_errors', '1');
error_reporting(E_ALL);

header('Content-Type: text/plain; charset=utf-8');

try {
    define('LARAVEL_START', microtime(true));

    require __DIR__.'/../vendor/autoload.php';
    echo "AUTOLOAD OK\n";

    $app = require_once __DIR__.'/../bootstrap/app.php';
    echo "BOOTSTRAP OK\n";

    $app->handleRequest(\Illuminate\Http\Request::capture());

} catch (\Throwable $e) {
    http_response_code(500);
    echo "\nERROR: " . get_class($e) . "\n";
    echo "MESSAGE: " . $e->getMessage() . "\n";
    echo "FILE: " . $e->getFile() . "\n";
    echo "LINE: " . $e->getLine() . "\n";
}
