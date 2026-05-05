<?php

// Paksa PHP mencetak semua error sekecil apa pun (biarkan ini sementara)
ini_set('display_errors', '1');
error_reporting(E_ALL);

try {
    require __DIR__ . '/../vendor/autoload.php';

    // Pindahkan direktori cache ke /tmp sebelum memuat bootstrap/app.php
    $storagePath = $_ENV['APP_STORAGE'] ?? '/tmp/storage';
    
    // Pastikan environment variables untuk cache di-set
    putenv("APP_CONFIG_CACHE={$storagePath}/framework/cache/config.php");
    putenv("APP_EVENTS_CACHE={$storagePath}/framework/cache/events.php");
    putenv("APP_PACKAGES_CACHE={$storagePath}/framework/cache/packages.php");
    putenv("APP_ROUTES_CACHE={$storagePath}/framework/cache/routes.php");
    putenv("APP_SERVICES_CACHE={$storagePath}/framework/cache/services.php");
    putenv("VIEW_COMPILED_PATH={$storagePath}/framework/views");

    // Buat sub-folder yang dibutuhkan
    $directories = [
        $storagePath . '/app/public',
        $storagePath . '/framework/cache/data',
        $storagePath . '/framework/views',
        $storagePath . '/framework/sessions',
        $storagePath . '/logs',
    ];

    foreach ($directories as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $app->useStoragePath($storagePath);

    $app->handleRequest(Illuminate\Http\Request::capture());

} catch (\Throwable $e) {
    echo "<div style='font-family: monospace; background: #ffebee; padding: 20px; border: 1px solid #c62828; color: #b71c1c;'>";
    echo "<h2>🚨 Error Masih Ada:</h2>";
    echo "<b>Pesan:</b> " . $e->getMessage() . "<br><br>";
    echo "<b>File:</b> " . $e->getFile() . "<br>";
    echo "<b>Baris:</b> " . $e->getLine() . "<br><br>";
    echo "</div>";
}