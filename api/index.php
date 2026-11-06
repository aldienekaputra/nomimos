<?php

// 1. Setup path penyimpanan sementara khusus runtime Vercel (/tmp)
$baseStorage = '/tmp/storage';

$directories = [
    $baseStorage . '/framework/views',
    $baseStorage . '/framework/cache/data',
    $baseStorage . '/framework/sessions',
    $baseStorage . '/logs',
    $baseStorage . '/bootstrap/cache',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// 2. Set Environment path runtime secara aman
putenv("VIEW_COMPILED_PATH={$baseStorage}/framework/views");
putenv("APP_CONFIG_CACHE={$baseStorage}/bootstrap/config.php");
putenv("APP_ROUTES_CACHE={$baseStorage}/bootstrap/routes.php");
putenv("APP_SERVICES_CACHE={$baseStorage}/bootstrap/services.php");
putenv("APP_PACKAGES_CACHE={$baseStorage}/bootstrap/packages.php");

$_ENV['VIEW_COMPILED_PATH'] = "{$baseStorage}/framework/views";
$_ENV['CACHE_STORE'] = 'array';
$_ENV['SESSION_DRIVER'] = 'cookie';

// 3. Masukkan handler error untuk menangkap exception tak terduga
try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    echo "<h1>Runtime Error</h1>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}