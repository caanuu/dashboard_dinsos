<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\UserController;
<<<<<<< HEAD
use App\Http\Controllers\WargaController;
=======
use App\Http\Controllers\MasyarakatController;
>>>>>>> f1cc7d539ac5d4c060d6b0c9d84d7f1eade675ea

/*
|--------------------------------------------------------------------------
| Web Routes - SIKASOS
|--------------------------------------------------------------------------
*/

// 1. HALAMAN PUBLIK
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/tracking', [PublicController::class, 'tracking'])->name('tracking');

<<<<<<< HEAD
// Permohonan Publik (Tanpa Login)
Route::get('/ajukan', [PublicController::class, 'createApplication'])->name('public.application.create');
Route::post('/ajukan', [PublicController::class, 'storeApplication'])->name('public.application.store');

// 2. OTENTIKASI
=======
// 2. AUTENTIKASI
>>>>>>> f1cc7d539ac5d4c060d6b0c9d84d7f1eade675ea
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
<<<<<<< HEAD
=======
    Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
>>>>>>> f1cc7d539ac5d4c060d6b0c9d84d7f1eade675ea
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

<<<<<<< HEAD
// 3. AREA WARGA (KHUSUS WARGA)
Route::middleware(['auth', 'role:warga'])->prefix('warga')->name('warga.')->group(function () {
    Route::get('/halaman', [WargaController::class, 'index'])->name('dashboard');
    Route::get('/ajukan', [WargaController::class, 'create'])->name('application.create');
    Route::post('/ajukan', [WargaController::class, 'store'])->name('application.store');
});

// --- RUTE PROFILE DIPINDAHKAN KE SINI (HANYA UNTUK WARGA) ---
// Gunakan middleware role:warga agar admin tidak bisa akses
Route::middleware(['auth', 'role:warga'])->group(function () {
    Route::get('/profile', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
});

// 4. AREA ADMIN / PETUGAS
Route::middleware(['auth', 'role:admin,operator,kadis'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminApplicationController::class, 'dashboard'])->name('dashboard');

    Route::name('admin.')->group(function () {
        Route::get('/applications', [AdminApplicationController::class, 'index'])->name('application.index');
        Route::get('/application/create', [AdminApplicationController::class, 'create'])->name('application.create');
        Route::post('/application/store', [AdminApplicationController::class, 'store'])->name('application.store');
        Route::get('/application/{id}', [AdminApplicationController::class, 'show'])->name('application.show');
        Route::post('/application/{id}/process', [AdminApplicationController::class, 'process'])->name('application.process');
        Route::get('/application/{id}/print', [AdminApplicationController::class, 'printLetter'])->name('application.print');

        Route::post('/distribution/store', [DistributionController::class, 'store'])->name('distribution.store');
        Route::put('/distribution/{id}', [DistributionController::class, 'update'])->name('distribution.update');

        Route::middleware('role:admin')->group(function () {
            Route::resource('services', ServiceTypeController::class)->except(['show']);
            Route::resource('users', UserController::class)->except(['show']);
        });
    });
=======
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
>>>>>>> f1cc7d539ac5d4c060d6b0c9d84d7f1eade675ea
});

// Redirect /dashboard ke dashboard yang sesuai dengan role
Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('masyarakat.dashboard');
    }
})->middleware('auth')->name('dashboard');
