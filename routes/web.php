<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\DashboardController::class, 'index'])->name('home');
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Dedicated Dashboards
    Route::get('/dashboard/pegawai', [App\Http\Controllers\DashboardController::class, 'pegawai'])->name('dashboard.pegawai')->middleware('role:Pegawai');
    Route::get('/dashboard/opd', [App\Http\Controllers\DashboardController::class, 'opd'])->name('dashboard.opd')->middleware('role:Admin OPD');
    Route::get('/dashboard/bkd', [App\Http\Controllers\DashboardController::class, 'bkd'])->name('dashboard.bkd')->middleware('role:Admin BKD|BKN');
    Route::get('/dashboard/admin', [App\Http\Controllers\DashboardController::class, 'admin'])->name('dashboard.admin')->middleware('role:Super Admin');

    // Pegawai
    Route::get('/dokumen', [App\Http\Controllers\DokumenController::class, 'index'])->name('dokumen.index');
    Route::post('/dokumen', [App\Http\Controllers\DokumenController::class, 'store'])->name('dokumen.store');

    Route::post('/dokumen/submit', [App\Http\Controllers\DokumenController::class, 'submit'])->name('dokumen.submit');

    // Admin OPD
    Route::group(['middleware' => ['role:Admin OPD|Super Admin|Admin BKD']], function () {
        Route::get('verifikasi', [App\Http\Controllers\VerifikasiController::class, 'index'])->name('verifikasi.index');
        Route::get('verifikasi/{id}', [App\Http\Controllers\VerifikasiController::class, 'show'])->name('verifikasi.show');
        Route::post('verifikasi/{id}/approve', [App\Http\Controllers\VerifikasiController::class, 'approve'])->name('verifikasi.approve');
        Route::post('verifikasi/{id}/reject', [App\Http\Controllers\VerifikasiController::class, 'reject'])->name('verifikasi.reject');
    });

    // Admin BKD
    Route::group(['prefix' => 'validasi', 'as' => 'validasi.', 'middleware' => ['role:Admin BKD|Super Admin']], function () {
        Route::get('/', [App\Http\Controllers\ValidasiController::class, 'index'])->name('index');
        Route::post('/{id}/approve', [App\Http\Controllers\ValidasiController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [App\Http\Controllers\ValidasiController::class, 'reject'])->name('reject');
    });
});
