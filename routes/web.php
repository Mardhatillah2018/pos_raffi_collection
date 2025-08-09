<?php

use App\Http\Controllers\CabangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailProdukController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KategoriPengeluaranController;
use App\Http\Controllers\KeuntunganController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogStokController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PenjualanController;
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

    // PILIH CABANG (hanya super_admin)
    Route::middleware('role:super_admin')->group(function () {
        Route::get('/pilih-cabang', function () {
            return view('pilih-cabang');
        })->name('pilih-cabang');
        Route::post('/pilih-cabang', [LoginController::class, 'simpanCabang'])->name('simpan-cabang');
        Route::get('/pilih-cabang', [LoginController::class, 'showPilihCabangForm'])->name('pilih-cabang');
    });

    // DASHBOARD (boleh super_admin dan admin_cabang)
    Route::middleware('role:super_admin,admin_cabang')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // SUPER ADMIN SAJA
    Route::middleware('role:super_admin')->group(function () {
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

        Route::get('/stok/cetak', [StokController::class, 'cetakPDF'])->name('stok.cetak');
        Route::get('/stok/cetak/mutasi', [StokController::class, 'cetakMutasiPDF'])->name('stok.cetak.mutasi');

        Route::post('/pengurangan/{id}/ubah-status', [LogStokController::class, 'ubahStatus'])->name('pengurangan.ubah-status');

        Route::resource('kategori-pengeluaran', KategoriPengeluaranController::class)->names('kategori-pengeluaran');
        Route::get('/laporan-pengeluaran/cetak', [PengeluaranController::class, 'cetakPDF'])->name('pengeluaran.cetak');
        Route::get('pengeluaran/{pengeluaran}/edit', [PengeluaranController::class, 'edit'])->name('pengeluaran.edit');
        Route::put('pengeluaran/{pengeluaran}', [PengeluaranController::class, 'update'])->name('pengeluaran.update');
        Route::delete('pengeluaran/{pengeluaran}', [PengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');

        Route::get('/laba-rugi/cetak', [LaporanController::class, 'cetakLabaRugi'])->name('laba-rugi.cetak');
        Route::get('/laba-rugi', [LaporanController::class, 'indexLabaRugi'])->name('laba-rugi.index');
        Route::get('/laba-rugi/{id}', [LaporanController::class, 'showLabaRugi'])->name('laba-rugi.show');

        Route::get('/mutasi-stok/cetak', [LaporanController::class, 'cetakMutasiStok'])->name('mutasi-stok.cetak');
        Route::get('/mutasi-stok', [LaporanController::class, 'indexMutasiStok'])->name('mutasi-stok.index');
        Route::get('/mutasi-stok/show/{bulan}/{tahun}', [LaporanController::class, 'showMutasiStok'])->name('mutasi-stok.show');


        // Route::get('/buku-besar/cetak', [LaporanController::class, 'cetakBukuBesar'])->name('buku-besar.cetak');
        // Route::get('/buku-besar', [LaporanController::class, 'indexBukuBesar'])->name('buku-besar.index');

        // Route::get('/keuntungan/cetak', [KeuntunganController::class, 'cetakPDF'])->name('keuntungan.cetak');
        // Route::resource('keuntungan', KeuntunganController::class)->names('keuntungan');

        Route::resource('karyawan', KaryawanController::class)->names('karyawan');
        Route::get('/gaji/cetak', [GajiController::class, 'cetakPDF'])->name('gaji.cetak');
        Route::resource('gaji', GajiController::class)->names('gaji');
        Route::patch('/gaji/bayar/{gaji}', [GajiController::class, 'bayar'])->name('gaji.bayar');
        Route::get('/gaji/bayar/{gaji}', function () {
            abort(403, 'Metode tidak diizinkan.');
        });
    });

    // SUPER ADMIN DAN ADMIN CABANG
    Route::middleware('role:super_admin,admin_cabang')->group(function () {
        Route::resource('stok', StokController::class)->names('stok');
        Route::get('/pengurangan-stok', [LogStokController::class, 'penguranganIndex'])->name('pengurangan.index');

        // Route::resource('penjualan', PenjualanController::class)->names('penjualan');
        Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
        Route::get('/penjualan/{id}/detail', [PenjualanController::class, 'show'])->name('penjualan.detail');
        Route::get('/penjualan/{id}/cetak-faktur', [PenjualanController::class, 'cetakFaktur'])->name('penjualan.cetakFaktur');
        Route::get('/penjualan/cetak-laporan', [PenjualanController::class, 'cetakPDF'])->name('penjualan.cetakLaporan');

        Route::get('pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
        Route::get('pengeluaran/create', [PengeluaranController::class, 'create'])->name('pengeluaran.create');
        Route::post('pengeluaran', [PengeluaranController::class, 'store'])->name('pengeluaran.store');
    });

    // ADMIN CABANG SAJA
    Route::middleware('role:admin_cabang')->group(function () {
        Route::post('/pengurangan-stok/ajukan', [LogStokController::class, 'ajukanPengurangan'])->name('pengurangan.ajukan');

        Route::get('/penjualan/create', [PenjualanController::class, 'create'])->name('penjualan.create');
        Route::post('/penjualan/review', [PenjualanController::class, 'review'])->name('penjualan.review');
        Route::post('/penjualan/konfirmasi', [PenjualanController::class, 'store'])->name('penjualan.konfirmasi');
    });

});

