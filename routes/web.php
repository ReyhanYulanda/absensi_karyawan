<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\KaryawanController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AbsensiController::class, 'adminIndex'])->name('dashboard');
        Route::resource('karyawan', KaryawanController::class);
    });

    Route::middleware('role:karyawan')->group(function () {
        Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
        Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
    });
});

require __DIR__.'/auth.php';
