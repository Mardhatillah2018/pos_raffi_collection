<?php

namespace App\Http\Controllers;

use App\Models\LogStok;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogStokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function penguranganIndex()
    {
        $kodeCabang = Auth::user()->kode_cabang;

        $logStoks = LogStok::with('detailProduk.produk', 'detailProduk.ukuran')
            ->where('jenis', 'keluar')
            ->where('sumber', 'pengurangan')
            ->latest()
            ->get();

        return view('stok.pengurangan-stok', compact('logStoks'));
    }
    public function ajukanPengurangan(Request $request)
    {
        $request->validate([
            'detail_produk_id' => 'required|exists:detail_produks,id',
            'qty' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string',
        ]);

        LogStok::create([
            'tanggal' => now(),
            'detail_produk_id' => $request->detail_produk_id,
            'kode_cabang' => Auth::user()->kode_cabang,
            'qty' => $request->qty,
            'jenis' => 'keluar',
            'created_by' => Auth::user()->id,
            'status' => 'menunggu',
            'sumber' => 'pengurangan',
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('pengurangan.index')
            ->with('success', 'Permintaan pengurangan stok berhasil dikirim.');
    }

    public function ubahStatus(Request $request, $id)
    {
        $log = LogStok::findOrFail($id);
        $statusBaru = $request->input('status');

        if (!in_array($statusBaru, ['disetujui', 'ditolak'])) {
            return redirect()->back()->with('status_pengurangan', [
                'tipe' => 'error',
                'judul' => 'Status Tidak Valid!',
                'pesan' => 'Status yang dimasukkan tidak dikenali.',
            ]);
        }

        // Hanya bisa ubah status jika masih 'pending'
        if ($log->status != 'menunggu') {
            return redirect()->back()->with('status_pengurangan', [
                'tipe' => 'warning',
                'judul' => 'Gagal!',
                'pesan' => 'Status sudah diproses sebelumnya.',
            ]);
        }

        // Jika disetujui → kurangi stok
        if ($statusBaru === 'disetujui') {
            $stok = Stok::where('detail_produk_id', $log->detail_produk_id)
                        ->where('kode_cabang', $log->kode_cabang)
                        ->first();

            if ($stok) {
                $stok->stok -= $log->qty;
                $stok->save();
            }
        }

        // Simpan perubahan status
        $log->status = $statusBaru;
        $log->save();

        return redirect()->route('pengurangan.index')->with('status_pengurangan', [
            'tipe' => $statusBaru == 'disetujui' ? 'success' : 'error',
            'judul' => ucfirst($statusBaru) . '!',
            'pesan' => 'Pengurangan stok berhasil ' . $statusBaru . '.',
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
    public function show(LogStok $logStok)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LogStok $logStok)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LogStok $logStok)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LogStok $logStok)
    {
        //
    }
}
