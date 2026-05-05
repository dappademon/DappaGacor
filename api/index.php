<?php

/**
 * Laravel on Vercel Entry Point
 * Dibuat khusus untuk menangani routing serverless.
 */

// 1. Arahkan autoload ke folder vendor yang benar
require __DIR__ . '/../vendor/autoload.php';

// 2. Inisialisasi aplikasi Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

/**
 * 3. Paksa Laravel menggunakan folder /tmp untuk storage.
 * Ini krusial karena Vercel bersifat read-only.
 */
$app->useStoragePath('/tmp');

// 4. Jalankan kernel untuk menangani request
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);