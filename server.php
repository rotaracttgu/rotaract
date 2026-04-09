<?php

declare(strict_types=1);

$publicPath = __DIR__ . '/public';
$uriPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$requestedPath = realpath($publicPath . $uriPath);

// Serve static files with security headers in local PHP built-in server.
if ($requestedPath !== false && is_file($requestedPath) && str_starts_with($requestedPath, realpath($publicPath))) {
    if (! headers_sent()) {
        header('X-Content-Type-Options: nosniff');
    }

    $extension = strtolower(pathinfo($requestedPath, PATHINFO_EXTENSION));
    $mimeMap = [
        'css' => 'text/css; charset=UTF-8',
        'js' => 'application/javascript; charset=UTF-8',
        'json' => 'application/json; charset=UTF-8',
        'svg' => 'image/svg+xml',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'webp' => 'image/webp',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'eot' => 'application/vnd.ms-fontobject',
        'ico' => 'image/x-icon',
        'txt' => 'text/plain; charset=UTF-8',
        'html' => 'text/html; charset=UTF-8',
    ];

    $mimeType = $mimeMap[$extension] ?? mime_content_type($requestedPath) ?: 'application/octet-stream';
    header('Content-Type: ' . $mimeType);
    header('Content-Length: ' . (string) filesize($requestedPath));
    readfile($requestedPath);
    exit;
}

require $publicPath . '/index.php';
