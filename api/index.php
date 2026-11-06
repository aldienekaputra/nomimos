<?php

// Turn on full error display for debugging on Vercel
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 1. Inisialisasi folder temporer untuk penyimpanan Laravel di sistem read-only Vercel
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
        @mkdir($dir, 0755, true);
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

// 3. Tangkap dan tampilkan jika ada Fatal Error pada PHP / Database
try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    echo '<div style="padding: 20px; font-family: sans-serif; background: #fff0f0; border: 1px solid #ffcdd2; color: #b71c1c;">';
    echo '<h2>Laravel Runtime Error</h2>';
    echo '<p><b>Message:</b> ' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '<p><b>File:</b> ' . htmlspecialchars($e->getFile()) . ' on line ' . $e->getLine() . '</p>';
    echo '<h3>Trace:</h3>';
    echo '<pre style="background: #fff; padding: 10px; border: 1px solid #ddd; overflow: auto;">' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
    echo '</div>';
    exit;
}