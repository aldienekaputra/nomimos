<?php

// 1. Atur lokasi direktori penyimpanan temporary untuk Vercel Read-Only System
$appStorage = '/tmp/storage';

$dirs = [
    $appStorage . '/framework/views',
    $appStorage . '/framework/cache/data',
    $appStorage . '/framework/sessions',
    $appStorage . '/logs',
    $appStorage . '/bootstrap/cache',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// 2. Set Environment path runtime secara aman
putenv("VIEW_COMPILED_PATH={$appStorage}/framework/views");
putenv("APP_CONFIG_CACHE={$appStorage}/bootstrap/config.php");
putenv("APP_ROUTES_CACHE={$appStorage}/bootstrap/routes.php");
putenv("APP_SERVICES_CACHE={$appStorage}/bootstrap/services.php");
putenv("APP_PACKAGES_CACHE={$appStorage}/bootstrap/packages.php");

$_ENV['VIEW_COMPILED_PATH'] = "{$appStorage}/framework/views";
$_ENV['CACHE_STORE'] = 'array';
$_ENV['SESSION_DRIVER'] = 'cookie';

// 3. Panggil entrypoint bawaan Laravel
require __DIR__ . '/../public/index.php';