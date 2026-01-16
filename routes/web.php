<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MasyarakatController;

/*
|--------------------------------------------------------------------------
| Web Routes - SIKASOS
|--------------------------------------------------------------------------
*/

// 1. HALAMAN PUBLIK
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/tracking', [PublicController::class, 'tracking'])->name('tracking');

// 2. AUTENTIKASI
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// 3. AREA MASYARAKAT (Harus Login sebagai Masyarakat)
Route::middleware(['auth', 'role:masyarakat'])->prefix('masyarakat')->name('masyarakat.')->group(function () {
    Route::get('/dashboard', [MasyarakatController::class, 'dashboard'])->name('dashboard');
    
    // Pengajuan Bantuan
    Route::get('/applications', [MasyarakatController::class, 'myApplications'])->name('applications.index');
    Route::get('/applications/create', [MasyarakatController::class, 'createApplication'])->name('applications.create');
    Route::post('/applications', [MasyarakatController::class, 'storeApplication'])->name('applications.store');
    Route::get('/applications/{id}', [MasyarakatController::class, 'showApplication'])->name('applications.show');
    
    // Profil
    Route::get('/profile', [MasyarakatController::class, 'profile'])->name('profile');
    Route::put('/profile', [MasyarakatController::class, 'updateProfile'])->name('profile.update');
});

// 4. AREA ADMIN (Harus Login sebagai Admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminApplicationController::class, 'dashboard'])->name('dashboard');
    
    // Kelola Permohonan
    Route::get('/applications', [AdminApplicationController::class, 'index'])->name('application.index');
    Route::get('/applications/{id}', [AdminApplicationController::class, 'show'])->name('application.show');
    Route::post('/applications/{id}/process', [AdminApplicationController::class, 'process'])->name('application.process');
    Route::post('/applications/{id}/verify', [AdminApplicationController::class, 'verify'])->name('application.verify');
    Route::post('/applications/{id}/approve', [AdminApplicationController::class, 'approve'])->name('application.approve');
    Route::post('/applications/{id}/reject', [AdminApplicationController::class, 'reject'])->name('application.reject');
    Route::get('/applications/{id}/print', [AdminApplicationController::class, 'printLetter'])->name('application.print');
    
    // Export Laporan
    Route::get('/export', function() {
        return view('admin.reports.export');
    })->name('export.page');
    Route::get('/export/pdf', [AdminApplicationController::class, 'exportPdf'])->name('export.pdf');
    Route::get('/export/excel', [AdminApplicationController::class, 'exportExcel'])->name('export.excel');
    
    // Master Data - Jenis Layanan
    Route::resource('services', ServiceTypeController::class);
    
    // Master Data - User Management
    Route::resource('users', UserController::class);
});

// Redirect /dashboard ke dashboard yang sesuai dengan role
Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('masyarakat.dashboard');
    }
})->middleware('auth')->name('dashboard');
