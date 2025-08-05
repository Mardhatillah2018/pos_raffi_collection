<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Gaji;
use App\Models\Karyawan;
use App\Models\Pengeluaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GajiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $gajis = Gaji::with(['karyawan', 'cabang'])
            ->where('kode_cabang', $user->kode_cabang)
            ->latest()
            ->get();

        return view('gaji.index', compact('gajis'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        $karyawans = Karyawan::when($user->role === 'admin', function ($query) use ($user) {
            $query->where('kode_cabang', $user->kode_cabang);
        })->get();

        return view('gaji.create', compact('karyawans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'periode' => 'required|date_format:Y-m',
            'jenis_gaji' => 'required|in:bulanan,mingguan',
            'gaji_pokok' => 'required|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,dibayar',
            'tanggal_dibayar' => $request->status === 'dibayar' ? 'required|date' : 'nullable|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $karyawan = Karyawan::findOrFail($request->karyawan_id);

        $gaji = Gaji::create([
            'karyawan_id' => $karyawan->id,
            'periode' => $request->periode . '-01',
            'jenis_gaji' => $request->jenis_gaji,
            'tanggal_dibayar' => $request->tanggal_dibayar,
            'gaji_pokok' => $request->gaji_pokok,
            'bonus' => $request->bonus ?? 0,
            'jumlah_dibayar' => $request->gaji_pokok + ($request->bonus ?? 0),
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'kode_cabang' => $karyawan->kode_cabang,
        ]);

        if ($gaji->status === 'dibayar') {
            Pengeluaran::create([
                'tanggal' => $gaji->tanggal_dibayar,
                'kode_cabang' => $gaji->kode_cabang,
                'kategori_id' => 7,
                'total_pengeluaran' => $gaji->jumlah_dibayar,
                'created_by' => Auth::id(),
                'keterangan' => 'Pembayaran gaji kepada ' . $karyawan->nama,
            ]);
        }

        return redirect()->route('gaji.index')->with('success', 'Gaji berhasil ditambahkan.');
    }

    public function bayar(Request $request, Gaji $gaji)
    {
        if (Auth::user()->role != 'super-admin') {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $request->validate([
            'tanggal_dibayar' => 'required|date',
        ]);

        $gaji->update([
            'status' => 'dibayar',
            'tanggal_dibayar' => $request->tanggal_dibayar,
        ]);

        // Simpan juga ke pengeluaran
        Pengeluaran::create([
            'tanggal' => $request->tanggal_dibayar,
            'kode_cabang' => $gaji->karyawan->kode_cabang,
            'created_by' => Auth::id(),
            'kategori_id' => 7,
            'total_pengeluaran' => $gaji->jumlah_dibayar,
            'keterangan' => 'Pembayaran gaji kepada ' . $gaji->karyawan->nama,
        ]);

        return back()->with('success', 'Gaji berhasil dibayar dan dicatat sebagai pengeluaran.');
    }

    public function cetakPDF(Request $request)
{
    $periode = $request->input('periode'); // format: 2025-08

    if (!$periode) {
        return redirect()->back()->with('error', 'Periode wajib diisi.');
    }

    $kodeCabang = Auth::user()->kode_cabang;
    $cabang = Cabang::where('kode_cabang', $kodeCabang)->first();

    $tahun = substr($periode, 0, 4);
    $bulan = substr($periode, 5, 2);

    $gajis = Gaji::with('karyawan')
        ->where('kode_cabang', $kodeCabang)
        ->whereYear('periode', $tahun)
        ->whereMonth('periode', $bulan)
        ->get();

    $bulanTahun = \Carbon\Carbon::parse($periode . '-01')->translatedFormat('F Y');

    $pdf = Pdf::loadView('gaji.laporan-gaji', [
        'gajis' => $gajis,
        'periode' => $bulanTahun,
        'kodeCabang' => $kodeCabang,
        'namaCabang' => $cabang->nama_cabang,
    ])->setPaper('A4', 'portrait');

    return $pdf->stream('laporan_gaji_' . $periode . '.pdf');
}


    /**
     * Display the specified resource.
     */
    public function show(Gaji $gaji)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gaji $gaji)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gaji $gaji)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gaji $gaji)
    {
        //
    }
}
