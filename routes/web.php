<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenghasilanController;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\PPNController;
use App\Http\Controllers\PkbController;
use App\Http\Controllers\PphController;
use App\Http\Controllers\CalculationController;

Route::get('/', function () {
    return view('home');
});

// Rute PPh
Route::get('/pph', [PphController::class, 'showForm'])->name('kalkulator.pph');
Route::post('/pph/hitung', [PphController::class, 'hitung'])->name('pph.hitung');

// Rute PPN
Route::get('/ppn', [PpnController::class, 'showForm'])->name('kalkulator.ppn');
Route::post('/ppn', [PPNController::class, 'hitung'])->name('ppn.hitung');

// Rute PKB (INI YANG DIPERBAIKI)
Route::get('/pkb', [PkbController::class, 'showForm'])->name('kalkulator.pkb');
Route::post('/pkb', [PkbController::class, 'hitung'])->name('pkb.hitung');


// Rute lain yang sudah ada
Route::get('/dashboard', [PenghasilanController::class, 'index'])->name('dashboard');
Route::post('/simpan', [PenghasilanController::class, 'store']);
Route::get('/export-pdf', [PenghasilanController::class, 'exportPDF'])->name('penghasilan.exportPDF');

//Eksport PDF real no fake
Route::get('/pkb/export-pdf/{id?}', [PkbController::class, 'exportPdf'])->name('pkb.exportPDF');
Route::get('/pph/export-pdf/{id?}', [PphController::class, 'exportPdf'])->name('pph.exportPDF');
Route::get('/ppn/export-pdf/{id?}', [PpnController::class, 'exportPdf'])->name('ppn.exportPDF');

// Rute untuk riwayat perhitungan
Route::get('/riwayat', [CalculationController::class, 'index'])->name('calculation.history');