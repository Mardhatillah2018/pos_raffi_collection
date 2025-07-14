<?php

use App\Http\Controllers\CabangController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UkuranProdukController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
});

// Route::get('/login', function () {
//     return view('login');
// });

Route::resource('users', UserController::class);
Route::resource('cabang', CabangController::class);
Route::post('check-kode-cabang', [CabangController::class, 'checkKodeCabang'])->name('cabang.checkKode');
Route::resource('ukuran-produk', UkuranProdukController::class);
Route::resource('produk', ProdukController::class);
