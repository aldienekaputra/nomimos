<?php

// 1. Tampilkan semua error PHP jika terjadi kesalahan fatal
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Buat struktur folder /tmp lengkap untuk Vercel Serverless
$baseStorage = '/tmp/storage';

$dirs = [
    $baseStorage . '/framework/views',
    $baseStorage . '/framework/cache/data',
    $baseStorage . '/framework/sessions',
    $baseStorage . '/logs',
    $baseStorage . '/bootstrap/cache',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// 3. Force override environment variable path penyimpanan Laravel ke /tmp
putenv("VIEW_COMPILED_PATH={$baseStorage}/framework/views");
putenv("APP_CONFIG_CACHE={$baseStorage}/bootstrap/config.php");
putenv("APP_ROUTES_CACHE={$baseStorage}/bootstrap/routes.php");
putenv("APP_SERVICES_CACHE={$baseStorage}/bootstrap/services.php");
putenv("APP_PACKAGES_CACHE={$baseStorage}/bootstrap/packages.php");

$_ENV['VIEW_COMPILED_PATH'] = "{$baseStorage}/framework/views";
$_ENV['APP_CONFIG_CACHE'] = "{$baseStorage}/bootstrap/config.php";
$_ENV['APP_ROUTES_CACHE'] = "{$baseStorage}/bootstrap/routes.php";
$_ENV['APP_SERVICES_CACHE'] = "{$baseStorage}/bootstrap/services.php";
$_ENV['APP_PACKAGES_CACHE'] = "{$baseStorage}/bootstrap/packages.php";

$_ENV['CACHE_STORE'] = 'array';
$_ENV['SESSION_DRIVER'] = 'cookie';

// 4. Require index utama Laravel
require __DIR__ . '/../public/index.php';