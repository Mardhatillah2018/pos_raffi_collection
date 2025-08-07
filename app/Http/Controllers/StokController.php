<?php

namespace App\Http\Controllers;

use App\Models\DetailProduk;
use App\Models\LogStok;
use App\Models\Produk;
use App\Models\Stok;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
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

        $detailProduks = DetailProduk::with([
            'produk',
            'ukuran',
            'stokCabang' => function ($query) use ($kodeCabang) {
                $query->where('kode_cabang', $kodeCabang);
            }
        ])->get();

        $grouped = $detailProduks->groupBy(fn($item) => $item->produk->id);

        $produkStok = $grouped->map(function ($items) {
            $produk = $items->first()->produk;

            $totalStok = $items->sum(function ($item) {
                return optional($item->stokCabang)->stok ?? 0;
            });

            $adaUkuranKosong = $items->contains(function ($item) {
                return (optional($item->stokCabang)->stok ?? 0) == 0;
            });

            return (object)[
                'produk_id' => $produk->id,
                'nama_produk' => $produk->nama_produk,
                'total_stok' => $totalStok,
                'ada_ukuran_kosong' => $adaUkuranKosong,
            ];
        });

        return view('stok.index', [
            'produkStok' => $produkStok
        ]);
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
            'namaCabang' => $namaCabang,
            'tanggalCetak' => now()
        ]);

        return $pdf->stream('laporan-stok.pdf');
    }

    public function cetakMutasiPDF(Request $request)
    {
        $user = Auth::user();
        $kodeCabang = $user->kode_cabang;

        // Ambil dan validasi periode
        $periode = $request->input('periode');
        if (!$periode || !preg_match('/^\d{4}-\d{2}$/', $periode)) {
            abort(400, 'Format periode tidak valid');
        }

        [$tahun, $bulan] = explode('-', $periode);

        $tanggalAwalBulan = Carbon::create($tahun, $bulan, 1)->startOfDay();
        $tanggalAkhirBulan = Carbon::create($tahun, $bulan, 1)->endOfMonth()->endOfDay();

        $logStoks = LogStok::with('detailProduk.produk', 'detailProduk.ukuran')
            ->where('kode_cabang', $kodeCabang)
            ->where('status', 'disetujui')
            ->whereDate('tanggal', '<=', $tanggalAkhirBulan)
            ->get()
            ->groupBy('detail_produk_id')
            ->map(function ($logs) use ($tanggalAwalBulan, $tanggalAkhirBulan) {
                $first = $logs->first();

                $stokAwal = $logs->where('tanggal', '<', $tanggalAwalBulan)
                    ->reduce(function ($total, $log) {
                        return $total + ($log->jenis === 'masuk' ? $log->qty : -$log->qty);
                    }, 0);

                $masuk = $logs->whereBetween('tanggal', [$tanggalAwalBulan, $tanggalAkhirBulan])
                    ->where('jenis', 'masuk')->sum('qty');

                $keluar = $logs->whereBetween('tanggal', [$tanggalAwalBulan, $tanggalAkhirBulan])
                    ->where('jenis', 'keluar')->sum('qty');

                $stokAkhir = $stokAwal + $masuk - $keluar;

                return (object)[
                    'nama_produk' => $first->detailProduk->produk->nama_produk ?? '-',
                    'ukuran' => $first->detailProduk->ukuran->kode_ukuran ?? '-',
                    'stok_awal' => $stokAwal,
                    'masuk' => $masuk,
                    'keluar' => $keluar,
                    'stok_akhir' => $stokAkhir,
                ];
            })->values();

        $pdf = PDF::loadView('stok.laporan-mutasi', [
            'dataMutasi' => $logStoks,
            'namaCabang' => $user->cabang->nama_cabang ?? $kodeCabang,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'tanggalCetak' => now()
        ]);

        return $pdf->stream("mutasi-stok-$bulan-$tahun.pdf");
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
