<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\KaryawanController;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsensiExport;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AbsensiController::class, 'adminIndex'])->name('dashboard');
        Route::get('/export-absensi', function (\Illuminate\Http\Request $request) {
            return Excel::download(new AbsensiExport($request), 'absensi.xlsx');
        })->name('absensi.export');
        Route::resource('karyawan', KaryawanController::class);
    });

    Route::middleware('role:karyawan')->group(function () {
        Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
        Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
    });
});

require __DIR__.'/auth.php';
