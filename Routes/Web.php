<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermohonanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- GRUP AKSES PEMOHON ---
Route::get('/', [PermohonanController::class, 'index'])->name('pemohon.dashboard');
Route::post('/permohonan', [PermohonanController::class, 'store'])->name('permohonan.simpan');

// --- GRUP AKSES ADMIN ---
Route::prefix('admin')->group(function () {
    Route::get('/', [PermohonanController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/verifikasi/{id}', [PermohonanController::class, 'verifikasi'])->name('admin.verifikasi');
});

// --- GRUP AKSES PETUGAS LAPANGAN ---
Route::prefix('petugas')->group(function () {
    Route::get('/', [PermohonanController::class, 'petugasDashboard'])->name('petugas.dashboard');
    Route::post('/survey/{id}', [PermohonanController::class, 'simpanSurvey'])->name('petugas.survey.simpan');
});

// --- GRUP AKSES KEPALA DINAS (KADIN) ---
Route::prefix('kadin')->group(function () {
    // Menampilkan daftar permohonan yang sudah di-survey & menunggu persetujuan
    Route::get('/', [PermohonanController::class, 'kadinDashboard'])->name('kadin.dashboard');
    
    // Proses ACC/Approval akhir permohonan
    Route::post('/approve/{id}', [PermohonanController::class, 'approvePermohonan'])->name('kadin.approve');
});
