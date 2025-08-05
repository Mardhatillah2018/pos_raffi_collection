<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\DetailProduk;
use App\Models\LogStok;
use App\Models\Pengeluaran;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $kodeCabang = $user->kode_cabang;

    // PENJUALAN
    $penjualanHariIni = Penjualan::whereDate('tanggal_penjualan', now())
        ->where('kode_cabang', $kodeCabang)
        ->sum('total_harga');

    $penjualanKemarin = Penjualan::whereDate('tanggal_penjualan', now()->subDay())
        ->where('kode_cabang', $kodeCabang)
        ->sum('total_harga');

    $persenPenjualan = $penjualanKemarin == 0
        ? null
        : (($penjualanHariIni - $penjualanKemarin) / $penjualanKemarin) * 100;

    // PENGELUARAN
    $pengeluaranHariIni = Pengeluaran::whereDate('tanggal', now())
        ->where('kode_cabang', $kodeCabang)
        ->sum('total_pengeluaran');

    $pengeluaranKemarin = Pengeluaran::whereDate('tanggal', now()->subDay())
        ->where('kode_cabang', $kodeCabang)
        ->sum('total_pengeluaran');

    $persenPengeluaran = $pengeluaranKemarin == 0
        ? null
        : (($pengeluaranHariIni - $pengeluaranKemarin) / $pengeluaranKemarin) * 100;

    // STOK
    $totalStok = Stok::where('kode_cabang', $kodeCabang)->sum('stok');

    $jumlahProdukUnik = Stok::where('kode_cabang', $kodeCabang)
        ->distinct('detail_produk_id')
        ->count('detail_produk_id');

    $produkStokKosong = Stok::where('kode_cabang', $kodeCabang)
        ->where('stok', 0)
        ->distinct('detail_produk_id')
        ->count('detail_produk_id');

    $jumlahProdukAktif = Stok::where('kode_cabang', $kodeCabang)
        ->where('stok', '>', 0)
        ->distinct('detail_produk_id')
        ->count('detail_produk_id');

    // PRODUK
    $totalProduk = DetailProduk::count();

    // PENJUALAN 7 HARI TERAKHIR
    $penjualan7Hari = Penjualan::select(
            DB::raw('DATE(tanggal_penjualan) as tanggal'),
            DB::raw('SUM(total_harga) as total')
        )
        ->where('kode_cabang', $kodeCabang)
        ->whereBetween('tanggal_penjualan', [now()->subDays(6)->startOfDay(), now()])
        ->groupBy('tanggal')
        ->orderBy('tanggal')
        ->get();

    // PENGELUARAN 7 HARI TERAKHIR
    $pengeluaran7Hari = Pengeluaran::select(
            DB::raw('DATE(tanggal) as tanggal'),
            DB::raw('SUM(total_pengeluaran) as total')
        )
        ->where('kode_cabang', $kodeCabang)
        ->whereBetween('tanggal', [now()->subDays(6)->startOfDay(), now()])
        ->groupBy('tanggal')
        ->orderBy('tanggal')
        ->get();

    // 6 PENJUALAN TERAKHIR
    $penjualanTerakhir = Penjualan::with('detailPenjualans')
        ->where('kode_cabang', $kodeCabang)
        ->latest('created_at')
        ->take(5)
        ->get()
        ->map(function ($penjualan) {
            return [
                'created_at' => $penjualan->created_at->format('d M Y H:i'),
                'no_faktur' => $penjualan->no_faktur,
                'qty_total' => $penjualan->detailPenjualans->sum('qty'),
                'total_harga' => $penjualan->total_harga
            ];
        });

    // logstok
    $logStoks = LogStok::with('detailProduk.produk', 'detailProduk.ukuran')
        ->where('kode_cabang', $kodeCabang)
        ->where('status', 'disetujui')
        ->orderByDesc('tanggal')
        ->limit(4)
        ->get();


    return view('dashboard', compact(
        'penjualanHariIni',
        'penjualanKemarin',
        'persenPenjualan',
        'pengeluaranHariIni',
        'pengeluaranKemarin',
        'persenPengeluaran',
        'totalStok',
        'jumlahProdukUnik',
        'produkStokKosong',
        'jumlahProdukAktif',
        'totalProduk',
        'penjualan7Hari',
        'pengeluaran7Hari',
        'penjualanTerakhir',
        'logStoks'
    ));
}

}
