<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController; // Tambahkan ini

// Halaman Depan
Route::get('/', function () { return view('welcome'); })->name('home');

// Halaman Tracking Publik (Baru)
Route::get('/tracking', [PublicController::class, 'tracking'])->name('tracking');

// Auth Routes (Login/Logout)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Admin/Operator Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AdminApplicationController::class, 'dashboard'])->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/applications', [AdminApplicationController::class, 'index'])->name('application.index');
        Route::get('/application/create', [AdminApplicationController::class, 'create'])->name('application.create');
        Route::post('/application/store', [AdminApplicationController::class, 'store'])->name('application.store');
        Route::get('/application/{id}', [AdminApplicationController::class, 'show'])->name('application.show');
        Route::post('/application/{id}/process', [AdminApplicationController::class, 'process'])->name('application.process');
        Route::get('/application/{id}/print', [AdminApplicationController::class, 'printLetter'])->name('application.print');
    });
});
