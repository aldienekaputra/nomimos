<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

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

// Override path storage & log ke /tmp
putenv("VIEW_COMPILED_PATH={$baseStorage}/framework/views");
putenv("APP_CONFIG_CACHE={$baseStorage}/bootstrap/config.php");
putenv("APP_ROUTES_CACHE={$baseStorage}/bootstrap/routes.php");
putenv("APP_SERVICES_CACHE={$baseStorage}/bootstrap/services.php");
putenv("APP_PACKAGES_CACHE={$baseStorage}/bootstrap/packages.php");
putenv("LOG_CHANNEL=stderr");

$_ENV['VIEW_COMPILED_PATH'] = "{$baseStorage}/framework/views";
$_ENV['CACHE_STORE'] = 'array';
$_ENV['SESSION_DRIVER'] = 'cookie';
$_ENV['LOG_CHANNEL'] = 'stderr';

// Override Host Supabase ke Pooler IPv4 & Username dengan Project Ref (hmgnmdpohjlceuimebgh)
$supabaseHost = 'aws-0-ap-southeast-1.pooler.supabase.com';
$supabasePort = '6543';
$supabaseUser = 'postgres.hmgnmdpohjlceuimebgh';

putenv("DB_HOST={$supabaseHost}");
putenv("DB_PORT={$supabasePort}");
putenv("DB_USERNAME={$supabaseUser}");

$_ENV['DB_HOST'] = $supabaseHost;
$_ENV['DB_PORT'] = $supabasePort;
$_ENV['DB_USERNAME'] = $supabaseUser;

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    echo "<div style='padding:20px; font-family:sans-serif; background:#fff0f0; border:2px solid red;'>";
    echo "<h2 style='color:red;'>Laravel Runtime Exception:</h2>";
    echo "<p><b>Message:</b> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><b>File:</b> " . htmlspecialchars($e->getFile()) . " (Line " . $e->getLine() . ")</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    echo "</div>";
    exit;
}