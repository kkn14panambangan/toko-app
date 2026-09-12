<?php

require __DIR__ . '/../vendor/autoload.php';

// Ensure /tmp/storage exists since Vercel is read-only
$storagePath = '/tmp/storage';

$directories = [
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/views',
    $storagePath . '/logs',
    $storagePath . '/bootstrap/cache'
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

$cacheVars = [
    'APP_CONFIG_CACHE' => '/tmp/storage/bootstrap/cache/config.php',
    'APP_EVENTS_CACHE' => '/tmp/storage/bootstrap/cache/events.php',
    'APP_PACKAGES_CACHE' => '/tmp/storage/bootstrap/cache/packages.php',
    'APP_ROUTES_CACHE' => '/tmp/storage/bootstrap/cache/routes.php',
    'APP_SERVICES_CACHE' => '/tmp/storage/bootstrap/cache/services.php',
    'VIEW_COMPILED_PATH' => '/tmp/storage/framework/views',
    // Paksa override kredensial DB dengan Connection Pooler IPv4 untuk Vercel
    'DB_HOST' => 'aws-0-ap-northeast-2.pooler.supabase.com',
    'DB_PORT' => '6543',
    'DB_USERNAME' => 'postgres.uarfbwwhfbfxabklgqzf',
    'DB_PASSWORD' => 'panambangan',
];
foreach ($cacheVars as $key => $value) {
    putenv("$key=$value");
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
}

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->useStoragePath($storagePath);

$app->handleRequest(Illuminate\Http\Request::capture());
