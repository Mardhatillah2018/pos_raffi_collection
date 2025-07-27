<?php

use App\Http\Controllers\CabangController;
use App\Http\Controllers\DetailProdukController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KategoriPengeluaranController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\StokController;
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
    Route::get('/pilih-cabang', [LoginController::class, 'showPilihCabangForm'])->name('pilih-cabang')->middleware('auth');

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
    Route::get('/produk/{id}/detail', [ProdukController::class, 'show'])->name('produk.detail');
    Route::resource('detail-produk', DetailProdukController::class)->names('detail-produk');
    Route::resource('produksi', ProduksiController::class)->names('produksi');
    Route::get('/produksi/{id}/detail', [ProduksiController::class, 'show'])->name('produksi.detail');
    Route::resource('pembelian', PembelianController::class)->names('pembelian');
    Route::get('/pembelian/{id}/detail', [PembelianController::class, 'show'])->name('pembelian.detail');
    Route::resource('stok', StokController::class)->names('stok');
    Route::resource('pengeluaran', PengeluaranController::class)->names(names: 'pengeluaran');
    Route::resource('kategori-pengeluaran', KategoriPengeluaranController::class)->names('kategori-pengeluaran');
    Route::resource('karyawan', KaryawanController::class)->names('karyawan');
});

