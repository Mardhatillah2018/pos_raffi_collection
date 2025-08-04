<?php

namespace App\Http\Controllers;

use App\Models\DetailProduk;
use App\Models\LogStok;
use App\Models\Produk;
use App\Models\Stok;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kodeCabang = Auth::user()->kode_cabang;

        $produkStok = Stok::with('detailProduk.produk')
            ->where('kode_cabang', $kodeCabang) // filter cabang
            ->selectRaw('detail_produk_id, SUM(stok) as total_stok')
            ->groupBy('detail_produk_id')
            ->get()
            ->groupBy(fn($item) => $item->detailProduk->produk->id)
            ->map(function ($group) {
                $produk = $group->first()->detailProduk->produk;
                return (object)[
                    'produk_id' => $produk->id,
                    'nama_produk' => $produk->nama_produk,
                    'total_stok' => $group->sum('total_stok'),
                ];
            });

        return view('stok.index', ['produkStok' => $produkStok]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    // StokController.php
    public function show($id)
    {
        $kodeCabang = Auth::user()->kode_cabang;

        $produk = Produk::findOrFail($id);

        $detailProduks = DetailProduk::with(['produk', 'ukuran'])
            ->where('produk_id', $id)
            ->get();

        $detailProdukIds = $detailProduks->pluck('id');

        $stokList = Stok::whereIn('detail_produk_id', $detailProdukIds)
            ->where('kode_cabang', $kodeCabang) // filter cabang
            ->get();

        return view('stok.detail-stok', compact('produk', 'detailProduks', 'stokList'));
    }

    public function cetakPDF()
{
    $user = Auth::user();
    $kodeCabang = $user->kode_cabang;

    $stokList = Stok::with('detailProduk.produk', 'detailProduk.ukuran')
        ->where('kode_cabang', $kodeCabang)
        ->get()
        ->groupBy('detail_produk_id')
        ->map(function ($group) {
            $first = $group->first();

            return (object)[
                'nama_produk' => $first->detailProduk->produk->nama_produk ?? '-',
                'ukuran' => $first->detailProduk->ukuran->kode_ukuran ?? '-',
                'total_stok' => $group->sum('stok'),
            ];
        })
        ->values();

    $namaCabang = $user->cabang->nama_cabang ?? $kodeCabang;

    $pdf = PDF::loadView('stok.laporan-stok', [
        'produkStok' => $stokList,
        'namaCabang' => $namaCabang
    ]);

    return $pdf->stream('laporan-stok.pdf');
}

public function cetakMutasiPDF(Request $request)
{
    $user = Auth::user();
    $kodeCabang = $user->kode_cabang;
    $bulan = $request->input('bulan') ?? now()->format('m');
    $tahun = $request->input('tahun') ?? now()->format('Y');

    $logStoks = LogStok::with('detailProduk.produk', 'detailProduk.ukuran')
        ->where('kode_cabang', $kodeCabang)
        ->whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun)
        ->where('status', 'disetujui') // 🔧 Tambahkan filter status disetujui
        ->get()
        ->groupBy('detail_produk_id')
        ->map(function ($logs) use ($kodeCabang) {
            $first = $logs->first();
            $masuk = $logs->where('jenis', 'masuk')->sum('jumlah');
            $keluar = $logs->where('jenis', 'keluar')->sum('jumlah');

            // Ambil sisa dari tabel stok
            $stok = Stok::where('detail_produk_id', $first->detail_produk_id)
                        ->where('kode_cabang', $kodeCabang)
                        ->sum('stok');

            return (object)[
                'nama_produk' => $first->detailProduk->produk->nama_produk ?? '-',
                'ukuran' => $first->detailProduk->ukuran->kode_ukuran ?? '-',
                'masuk' => $masuk,
                'keluar' => $keluar,
                'sisa' => $stok
            ];
        })->values();

    $pdf = PDF::loadView('stok.laporan-mutasi', [
        'dataMutasi' => $logStoks,
        'namaCabang' => $user->cabang->nama_cabang ?? $kodeCabang,
        'bulan' => $bulan,
        'tahun' => $tahun,
        'tanggalCetak' => now()
    ]);

    return $pdf->stream('mutasi-stok-' . $bulan . '-' . $tahun . '.pdf');
}




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stok $stok)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stok $stok)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stok $stok)
    {
        //
    }
}
