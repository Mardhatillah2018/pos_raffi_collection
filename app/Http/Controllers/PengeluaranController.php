<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\KategoriPengeluaran;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kodeCabang = Auth::user()->kode_cabang;

        $pengeluarans = Pengeluaran::with('kategori')
            ->where('kode_cabang', $kodeCabang)
            ->latest()
            ->get();

        $kategori_pengeluarans = KategoriPengeluaran::all();

        return view('pengeluaran.index', compact('pengeluarans', 'kategori_pengeluarans'));
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
    $request->validate([
        'kategori_pengeluaran_id' => 'required|exists:kategori_pengeluarans,id',
        'tanggal' => 'required|date',
        'total_pengeluaran' => 'required|numeric',
        'keterangan' => 'nullable|string',
    ]);

    $user = Auth::user();

    Pengeluaran::create([
        'kategori_id' => $request->kategori_pengeluaran_id,
        'tanggal' => $request->tanggal,
        'total_pengeluaran' => $request->total_pengeluaran,
        'keterangan' => $request->keterangan,
        'kode_cabang' => $user->kode_cabang,
        'created_by' => $user->id,
    ]);

    return redirect()->back()->with('success', 'Pengeluaran berhasil ditambahkan.');
}



    /**
     * Display the specified resource.
     */
    public function show(Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_pengeluarans,id',
            'tanggal' => 'required|date',
            'total_pengeluaran' => 'required|numeric',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $pengeluaran->update([
            'kategori_id' => $request->kategori_id,
            'tanggal' => $request->tanggal,
            'total_pengeluaran' => $request->total_pengeluaran,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Pengeluaran berhasil diperbarui.');
    }

public function cetakPDF(Request $request)
{
    $kodeCabang = Auth::user()->kode_cabang;

    $tanggalMulai = $request->tanggal_mulai;
    $tanggalSampai = $request->tanggal_sampai;

    $pengeluarans = Pengeluaran::with('kategori')
        ->where('kode_cabang', $kodeCabang)
        ->whereBetween('tanggal', [$tanggalMulai, $tanggalSampai])
        ->orderBy('tanggal', 'asc')
        ->get();

    // Ambil nama_cabang dari tabel cabangs
    $cabang = Cabang::where('kode_cabang', $kodeCabang)->first();
    $namaCabang = $cabang ? $cabang->nama_cabang : 'Semua Cabang';

    $pdf = PDF::loadView('pengeluaran.laporan-pengeluaran', [
        'pengeluarans' => $pengeluarans,
        'namaCabang' => $namaCabang,
        'tanggalCetak' => now()->format('d-m-Y'),
        'periode' => [
            'mulai' => $tanggalMulai,
            'sampai' => $tanggalSampai,
        ]
    ])->setPaper('A4', 'portrait');

    return $pdf->stream('laporan-pengeluaran.pdf');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->delete();

        return redirect()->route('pengeluaran.index')
                         ->with('success', 'Pengeluaran berhasil dihapus.');
    }
}
