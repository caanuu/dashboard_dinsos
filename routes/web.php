<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. HALAMAN PUBLIK
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/tracking', [PublicController::class, 'tracking'])->name('tracking');
Route::get('/lapor', [PublicController::class, 'lapor'])->name('lapor.index');
Route::post('/lapor', [PublicController::class, 'storeLapor'])->name('lapor.store');

// TAMBAHAN: PERMOHONAN ONLINE
Route::get('/ajukan', [PublicController::class, 'createApplication'])->name('public.application.create');
Route::post('/ajukan', [PublicController::class, 'storeApplication'])->name('public.application.store');

// 2. OTENTIKASI
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// 3. AREA ADMIN (DASHBOARD)
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AdminApplicationController::class, 'dashboard'])->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        // Module Permohonan
        Route::get('/applications', [AdminApplicationController::class, 'index'])->name('application.index');
        Route::get('/application/create', [AdminApplicationController::class, 'create'])->name('application.create');
        Route::post('/application/store', [AdminApplicationController::class, 'store'])->name('application.store');
        Route::get('/application/{id}', [AdminApplicationController::class, 'show'])->name('application.show');
        Route::post('/application/{id}/process', [AdminApplicationController::class, 'process'])->name('application.process');
        Route::get('/application/{id}/print', [AdminApplicationController::class, 'printLetter'])->name('application.print');

        // Module Distribusi
        Route::post('/distribution/store', [DistributionController::class, 'store'])->name('distribution.store');
        Route::put('/distribution/{id}', [DistributionController::class, 'update'])->name('distribution.update');

        // Module Master Data (Hanya Admin)
        Route::middleware('role:admin')->group(function () {
            // CRUD Jenis Layanan (Sudah ada fungsi create/store di Controller)
            Route::resource('services', ServiceTypeController::class)->except(['show']);
            Route::resource('users', UserController::class)->except(['show']);
        });
    });
});
