<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ─── PUBLIC ROUTES ───────────────────────────────────────────────
Route::get('/', fn() => redirect('/login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── AUTHENTICATED ROUTES ────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // Dashboard (semua role bisa akses)
    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('dashboard');

    // ─ ARSIP (Read & Create: Admin + Staff) ───────────────────────
    Route::middleware(['role:admin,staff'])->prefix('arsip')->group(function () {
        Route::get('/', [ArsipController::class, 'index'])->name('arsip.index');
        Route::get('/create', [ArsipController::class, 'create'])->name('arsip.create');
        Route::post('/', [ArsipController::class, 'store'])->name('arsip.store');
        Route::get('/{arsip}', [ArsipController::class, 'show'])->name('arsip.show');
        Route::get('/{arsip}/download', [ArsipController::class, 'download'])->name('arsip.download');
    });

    // ─ ARSIP (Edit & Delete: Admin Only) ──────────────────────────
    Route::middleware(['role:admin'])->prefix('arsip')->group(function () {
        Route::get('/{arsip}/edit', [ArsipController::class, 'edit'])->name('arsip.edit');
        Route::put('/{arsip}', [ArsipController::class, 'update'])->name('arsip.update');
        Route::delete('/{arsip}', [ArsipController::class, 'destroy'])->name('arsip.destroy');
    });

    // ─ AJAX: Cari / Simpan Penduduk (dipakai di form Tambah Arsip) ─
    Route::get('/api/penduduk/cari', [PendudukController::class, 'cariByNik'])
         ->name('api.penduduk.cari');
    Route::post('/api/penduduk', [PendudukController::class, 'simpanBaru'])
         ->name('api.penduduk.simpan');

    // ─ KATEGORI (admin only) ──────────────────────────────────────
    Route::middleware(['role:admin'])->prefix('kategori')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
        Route::get('/create', [KategoriController::class, 'create'])->name('kategori.create');
        Route::post('/', [KategoriController::class, 'store'])->name('kategori.store');
        Route::get('/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
        Route::put('/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    });

    // ─ USER MANAGEMENT (admin only) ───────────────────────────────
    Route::middleware(['role:admin'])->prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // ─ KADES & ADMIN (View Only / Report) ─────────────────────────
    Route::middleware(['role:kades,admin'])->group(function () {
        Route::get('/laporan', [ArsipController::class, 'laporan'])->name('laporan.index');
    });
});