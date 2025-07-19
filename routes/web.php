<?php

use App\Http\Controllers\CabangController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UkuranProdukController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    // Halaman pilih cabang
    Route::get('/pilih-cabang', function () {
        return view('pilih-cabang');
    })->name('pilih-cabang');

    Route::post('/pilih-cabang', [LoginController::class, 'simpanCabang'])->name('simpan-cabang');

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Manajemen data
    Route::resource('users', UserController::class)->names('user');
    Route::resource('cabang', CabangController::class)->names('cabang');
    Route::post('check-kode-cabang', [CabangController::class, 'checkKodeCabang'])->name('cabang.checkKode');
    Route::resource('ukuran-produk', UkuranProdukController::class)->names('ukuran-produk');
    Route::resource('produk', ProdukController::class)->names('produk');
    Route::resource('karyawan', KaryawanController::class)->names('karyawan');
});

