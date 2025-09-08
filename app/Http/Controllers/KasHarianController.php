<?php

namespace App\Http\Controllers;

use App\Models\KasHarian;
use App\Models\Pengeluaran;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $kodeCabang = $user->kode_cabang;
        $today = date('Y-m-d');

        // hitung total penjualan hari ini
        $totalPenjualan = Penjualan::whereDate('tanggal_penjualan', $today)
            ->where('kode_cabang', $kodeCabang)
            ->sum('total_harga');

        // hitung total pengeluaran hari ini (hanya approved)
        $totalPengeluaran = Pengeluaran::whereDate('tanggal', $today)
            ->where('kode_cabang', $kodeCabang)
            ->where('status', 'approved')
            ->whereHas('user', function ($q) {
                $q->where('role', 'admin_cabang');
            })
            ->sum('total_pengeluaran');

        // ambil saldo akhir dari hari sebelumnya
        $previousKas = KasHarian::where('kode_cabang', $kodeCabang)
            ->whereDate('tanggal', '<', $today)
            ->orderBy('tanggal', 'desc')
            ->first();

        $saldoAwal = $previousKas ? $previousKas->saldo_akhir : 0;

        $kasHarians = KasHarian::where('kode_cabang', $kodeCabang)
                        ->orderBy('tanggal', 'desc')
                        ->get();

        return view('kas-harian.index', compact('kasHarians', 'totalPenjualan', 'totalPengeluaran', 'saldoAwal'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal'          => 'required|date',
            'saldo_awal'       => 'required|numeric|min:0',
            'total_penjualan'  => 'required|numeric|min:0',
            'total_pengeluaran'=> 'required|numeric|min:0',
            'setor'            => 'required|numeric|min:0',
            'keterangan'       => 'nullable|string',
        ]);

        // hitung saldo akhir (pakai pengeluaran juga)
        $saldoAkhir = $request->saldo_awal
                    + $request->total_penjualan
                    - $request->total_pengeluaran
                    - $request->setor;

        KasHarian::create([
            'kode_cabang'       => Auth::user()->kode_cabang,
            'tanggal'           => $request->tanggal,
            'saldo_awal'        => $request->saldo_awal,
            'total_penjualan'   => $request->total_penjualan,
            'total_pengeluaran' => $request->total_pengeluaran, // <-- simpan
            'setor'             => $request->setor,
            'saldo_akhir'       => $saldoAkhir,
            'status'            => 'pending', // default
            'created_by'        => Auth::id(),
            'keterangan'        => $request->keterangan,
        ]);

        return redirect()->route('kas-harian.index')->with('success', 'Kas harian berhasil ditambahkan!');
    }

    // KasHarianController.php
    public function proses(Request $request, $id)
    {
        $kas = KasHarian::findOrFail($id);
        $kas->status = $request->status; // approved / rejected
        $kas->save();

        return redirect()->back()->with('success', 'Kas Harian berhasil diproses.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KasHarian $kasHarian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KasHarian $kasHarian)
    {
    //
    }
}
