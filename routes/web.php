<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminApplicationController;
use App\Http\Controllers\AuthController;

// Halaman Depan Publik
Route::get('/', function () {
    return view('welcome');
})->name('home');

// --- AREA TAMU (GUEST) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// --- AREA ADMIN (AUTH) ---
Route::middleware(['auth'])->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [AdminApplicationController::class, 'dashboard'])->name('dashboard');

    // Grouping Route Admin
    Route::prefix('admin')->name('admin.')->group(function () {
        // List Permohonan (DataTables)
        Route::get('/applications', [AdminApplicationController::class, 'index'])->name('application.index');

        // Detail Permohonan
        Route::get('/application/{id}', [AdminApplicationController::class, 'show'])->name('application.show');

        // Proses Status (Verifikasi/Tolak/Approve)
        Route::post('/application/{id}/process', [AdminApplicationController::class, 'process'])->name('application.process');

        // Cetak Surat
        Route::get('/application/{id}/print', [AdminApplicationController::class, 'printLetter'])->name('application.print');
    });
});
