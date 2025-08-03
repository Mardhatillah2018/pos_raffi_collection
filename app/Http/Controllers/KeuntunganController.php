<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeuntunganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $user = Auth::user();
    $kodeCabang = $user->kode_cabang;

    // Ambil data penjualan & pengeluaran sesuai role
    if ($user->role === 'super_admin') {
        $penjualans = Penjualan::with(['detailPenjualans.detailProduk'])
            ->orderBy('tanggal_penjualan', 'desc')
            ->get()
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->tanggal_penjualan)->format('Y-m');
            });

        $pengeluarans = Pengeluaran::with('kategori')
            ->get()
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->tanggal)->format('Y-m');
            });
    } else {
        $penjualans = Penjualan::with(['detailPenjualans.detailProduk'])
            ->where('kode_cabang', $kodeCabang)
            ->orderBy('tanggal_penjualan', 'desc')
            ->get()
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->tanggal_penjualan)->format('Y-m');
            });

        $pengeluarans = Pengeluaran::with('kategori')
            ->where('kode_cabang', $kodeCabang)
            ->get()
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->tanggal)->format('Y-m');
            });
    }

    $rekap = [];

    foreach ($penjualans as $bulan => $listPenjualan) {
        $totalPenjualan = 0;
        $totalModal = 0;
        $totalQty = 0;

        foreach ($listPenjualan as $penjualan) {
            foreach ($penjualan->detailPenjualans as $detail) {
                $hargaModal = $detail->detailProduk->harga_modal ?? 0;
                $qty = $detail->qty;

                $totalQty += $qty;
                $totalPenjualan += $detail->subtotal;
                $totalModal += ($hargaModal * $qty);
            }
        }

        $labaKotor = $totalPenjualan - $totalModal;

        $pengeluaranBulanItu = $pengeluarans[$bulan] ?? collect();
        $totalPengeluaran = $pengeluaranBulanItu->filter(function ($p) {
            return !$p->kategori->is_modal_produk;
        })->sum('total_pengeluaran');

        $labaBersih = $labaKotor - $totalPengeluaran;

        $rekap[] = [
            'bulan' => \Carbon\Carbon::createFromFormat('Y-m', $bulan)->isoFormat('MMMM Y'),
            'raw_bulan' => $bulan,
            'total_produk' => $totalQty,
            'total_penjualan' => $totalPenjualan,
            'laba_kotor' => $labaKotor,
            'pengeluaran' => $totalPengeluaran,
            'laba_bersih' => $labaBersih,
        ];
    }

    return view('keuntungan.index', compact('rekap'));
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

    public function show($bulan, Request $request)
    {
        $user = Auth::user();
        $kodeCabang = $user->role == 'superadmin' && $request->has('cabang')
            ? $request->get('cabang')
            : $user->kode_cabang;

        // Penjualan
        $penjualans = Penjualan::with(['detailPenjualans.detailProduk'])
            ->where('kode_cabang', $kodeCabang)
            ->whereYear('tanggal_penjualan', substr($bulan, 0, 4))
            ->whereMonth('tanggal_penjualan', substr($bulan, 5, 2))
            ->get()
            ->groupBy('tanggal_penjualan');

        // Pengeluaran
        $pengeluarans = Pengeluaran::with('kategori')
            ->where('kode_cabang', $kodeCabang)
            ->whereYear('tanggal', substr($bulan, 0, 4))
            ->whereMonth('tanggal', substr($bulan, 5, 2))
            ->get()
            ->groupBy('tanggal');

        $rekapPerHari = [];

        foreach ($penjualans as $tanggal => $penjualanList) {
            $totalPenjualan = 0;
            $totalModal = 0;
            $totalQty = 0;

            foreach ($penjualanList as $penjualan) {
                foreach ($penjualan->detailPenjualans as $detail) {
                    $qty = $detail->qty;
                    $hargaModal = $detail->detailProduk->harga_modal ?? 0;

                    $totalQty += $qty;
                    $totalPenjualan += $detail->subtotal;
                    $totalModal += $hargaModal * $qty;
                }
            }

            $labaKotor = $totalPenjualan - $totalModal;

            $pengeluaranHariItu = $pengeluarans[$tanggal] ?? collect();
            $totalPengeluaran = $pengeluaranHariItu->filter(function ($p) {
                return !$p->kategori->is_modal_produk;
            })->sum('total_pengeluaran');

            $labaBersih = $labaKotor - $totalPengeluaran;

            $rekapPerHari[] = [
                'tanggal' => Carbon::parse($tanggal)->translatedFormat('d F Y'),
                'total_produk' => $totalQty,
                'total_penjualan' => $totalPenjualan,
                'laba_kotor' => $labaKotor,
                'pengeluaran' => $totalPengeluaran,
                'laba_bersih' => $labaBersih,
            ];
        }

        $namaBulan = Carbon::createFromFormat('Y-m', $bulan)->translatedFormat('F Y');

        return view('keuntungan.detail-perhari', compact('rekapPerHari', 'namaBulan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
