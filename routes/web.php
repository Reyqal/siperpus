<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AnggotaController;
use Illuminate\Support\Facades\Route;

// ─────────────────────────────────────────────────────────────────────────────
// Public Routes
// ─────────────────────────────────────────────────────────────────────────────

Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login',     [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',    [LoginController::class, 'login'])->name('login.post');
    Route::get('/register',  [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

Route::post('/logout', [LoginController::class, 'logout'])
     ->name('logout')
     ->middleware('auth');

// ─────────────────────────────────────────────────────────────────────────────
// Authenticated Routes
// ─────────────────────────────────────────────────────────────────────────────

Route::middleware('auth')->group(function () {

    // ─────────────────────────────────────────────────────────────────────
    // Anggota Routes
    // ─────────────────────────────────────────────────────────────────────
    Route::middleware('isAnggota')->group(function () {
        Route::get('/peminjaman/history', [PeminjamanController::class, 'history'])
             ->name('peminjaman.history');
        Route::get('/peminjaman/create', [PeminjamanController::class, 'anggotaCreate'])
             ->name('peminjaman.create');
        Route::post('/peminjaman', [PeminjamanController::class, 'anggotaStore'])
             ->name('peminjaman.store');
    });

    // ─────────────────────────────────────────────────────────────────────
    // Admin Routes
    // ─────────────────────────────────────────────────────────────────────
    Route::middleware('isAdmin')->prefix('admin')->name('admin.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Anggota ← sudah di dalam group admin
        Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
        Route::get('/anggota/{user}', [AnggotaController::class, 'show'])->name('anggota.show');

        // CRUD Buku
        Route::resource('buku', BukuController::class);

        // CRUD Peminjaman
        Route::resource('peminjaman', PeminjamanController::class)
             ->except(['create', 'store']);

        // Aksi Peminjaman
        Route::patch('/peminjaman/{peminjaman}/approve', [PeminjamanController::class, 'approve'])
             ->name('peminjaman.approve');
        Route::patch('/peminjaman/{peminjaman}/tolak', [PeminjamanController::class, 'tolak'])
             ->name('peminjaman.tolak');
        Route::patch('/peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])
             ->name('peminjaman.kembalikan');
    });
});