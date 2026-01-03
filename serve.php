<?php

/**
 * Custom Laravel Development Server
 * Bypasses Laravel's serve command which has issues on Windows
 *
 * Usage: php serve.php [host] [port]
 * Example: php serve.php 127.0.0.1 8000
 */
$host = isset($argv[1]) ? $argv[1] : '127.0.0.1';
$port = isset($argv[2]) ? $argv[2] : '8000';

$publicPath = __DIR__.'/public';
$routerPath = __DIR__.'/public/index.php';

if (! file_exists($publicPath)) {
    exit("Error: Public directory not found!\n");
}

if (! file_exists($routerPath)) {
    exit("Error: index.php not found in public directory!\n");
}

echo "═══════════════════════════════════════════════════════════\n";
echo "  Laravel Development Server\n";
echo "═══════════════════════════════════════════════════════════\n";
echo "  Server: http://{$host}:{$port}\n";
echo "  Press Ctrl+C to stop the server\n";
echo "═══════════════════════════════════════════════════════════\n\n";

// Change to public directory
chdir($publicPath);

// Start PHP built-in server
passthru("php -S {$host}:{$port} -t {$publicPath} {$routerPath}");
