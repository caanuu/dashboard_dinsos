<?php

// routes/web.php

use App\Http\Controllers\AdminApplicationController;

Route::middleware(['auth'])->group(function () {
    // Dashboard Utama
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Manajemen Permohonan
    Route::get('/admin/applications', [AdminApplicationController::class, 'index'])->name('admin.application.index');
    Route::get('/admin/application/{id}', [AdminApplicationController::class, 'show'])->name('admin.application.show');
    Route::post('/admin/application/{id}/process', [AdminApplicationController::class, 'process'])->name('admin.application.process');
    Route::get('/admin/application/{id}/print', [AdminApplicationController::class, 'printLetter'])->name('admin.application.print');
});
