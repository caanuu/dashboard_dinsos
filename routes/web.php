<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminApplicationController;
use App\Http\Controllers\AuthController;

// Halaman Depan (Landing Page)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Group Guest (Hanya bisa diakses jika BELUM login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Group Auth (Harus Login)
Route::middleware(['auth'])->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard dengan Controller (supaya bisa kirim data statistik)
    Route::get('/dashboard', [AdminApplicationController::class, 'dashboard'])->name('dashboard');

    // Manajemen Permohonan
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/applications', [AdminApplicationController::class, 'index'])->name('application.index');
        Route::get('/application/{id}', [AdminApplicationController::class, 'show'])->name('application.show');
        Route::post('/application/{id}/process', [AdminApplicationController::class, 'process'])->name('application.process');
        Route::get('/application/{id}/print', [AdminApplicationController::class, 'printLetter'])->name('application.print');
    });
});
