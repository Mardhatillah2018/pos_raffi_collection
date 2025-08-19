<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\LogStok;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            ->where('kode_cabang', $kodeCabang) // filter berdasarkan cabang
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('stok.pengurangan-stok', compact('logStoks'));
    }

    public function ajukanPengurangan(Request $request)
    {
        // Validasi input
        $request->validate([
            'detail_produk_id' => 'required|exists:detail_produks,id',
            'qty' => 'required|numeric|min:1',
            'alasan' => 'required|in:rusak,transfer',
            'cabang_tujuan' => 'required_if:alasan,transfer|exists:cabangs,kode_cabang',
        ]);

        // Ambil alasan dan normalisasi
        $alasan = strtolower(trim($request->alasan));

        // Tentukan keterangan berdasarkan alasan
        if ($alasan === 'rusak') {
            $keterangan = 'Barang rusak';
        } elseif ($alasan === 'transfer') {
            $cabangTujuan = Cabang::where('kode_cabang', $request->cabang_tujuan)->first();
            $keterangan = 'Transfer barang ke cabang '
                        . ($cabangTujuan->nama_cabang ?? '')
                        . ' [' . ($cabangTujuan->kode_cabang ?? '') . ']';
        } else {
            $keterangan = 'Alasan tidak diketahui';
        }

        // Buat log stok pengurangan
        LogStok::create([
            'tanggal' => now(),
            'detail_produk_id' => $request->detail_produk_id,
            'kode_cabang' => Auth::user()->kode_cabang, // cabang asal
            'qty' => $request->qty,
            'jenis' => 'keluar',
            'created_by' => Auth::id(),
            'status' => 'menunggu',
            'sumber' => 'pengurangan',
            'keterangan' => $keterangan,
        ]);

        return redirect()->route('pengurangan.index')
            ->with('success', 'Permintaan pengurangan stok berhasil dikirim.');
    }

    public function ubahStatus(Request $request, $id)
    {
        // Ambil data log stok sekaligus relasi detail produk, produk dan ukuran
        $log = LogStok::with('detailProduk.produk', 'detailProduk.ukuran')->findOrFail($id);
        $statusBaru = $request->input('status');

        if (!in_array($statusBaru, ['disetujui', 'ditolak'])) {
            return redirect()->back()->with('status_pengurangan', [
                'tipe' => 'error',
                'judul' => 'Status Tidak Valid!',
                'pesan' => 'Status yang dimasukkan tidak dikenali.',
            ]);
        }

        // Hanya bisa ubah status jika masih 'menunggu'
        if ($log->status != 'menunggu') {
            return redirect()->back()->with('status_pengurangan', [
                'tipe' => 'warning',
                'judul' => 'Gagal!',
                'pesan' => 'Status sudah diproses sebelumnya.',
            ]);
        }

        if ($statusBaru === 'disetujui') {
            if ($log->jenis === 'keluar') {

            if (str_contains($log->keterangan, 'Barang rusak')) {
                $stok = Stok::where('detail_produk_id', $log->detail_produk_id)
                            ->where('kode_cabang', $log->kode_cabang)
                            ->first();

                    if ($stok) {
                        $stok->stok -= $log->qty;
                        $stok->save();

                        // catat kerugian ke tabel pengeluaran
                        $namaProduk = $log->detailProduk->produk->nama_produk ?? 'Produk tidak diketahui';
                        $ukuran = $log->detailProduk->ukuran->nama_ukuran ?? 'Ukuran tidak diketahui';
                        $hargaModalSatuan = $log->detailProduk->harga_modal ?? 0;
                        $totalKerugian = $log->qty * $hargaModalSatuan;

                        $keteranganPengeluaran = "Kerugian stok rusak: {$log->qty} pcs {$namaProduk} Ukuran: {$ukuran}";

                        DB::table('pengeluarans')->insert([
                            'tanggal' => now()->toDateString(),
                            'kode_cabang' => $log->kode_cabang,
                            'created_by' => Auth::id(),
                            'kategori_id' => 10, // kategori Kerugian Stok
                            'total_pengeluaran' => $totalKerugian,
                            'keterangan' => $keteranganPengeluaran,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                } elseif (str_contains($log->keterangan, 'Transfer barang ke cabang')) {
                    // === Transfer: kurangi stok asal + tambah stok tujuan ===
                    $stokAsal = Stok::where('detail_produk_id', $log->detail_produk_id)
                                    ->where('kode_cabang', $log->kode_cabang)
                                    ->first();
                    if ($stokAsal) {
                        $stokAsal->stok -= $log->qty;
                        $stokAsal->save();
                    }

                    if (preg_match('/\[(.*?)\]/', $log->keterangan, $match)) {
                        $cabangTujuan = $match[1]; // contoh hasil: CB002
                    } else {
                        $cabangTujuan = null;
}

                    if ($cabangTujuan) {
                        $stokTujuan = Stok::firstOrCreate(
                            ['detail_produk_id' => $log->detail_produk_id, 'kode_cabang' => $cabangTujuan],
                            ['stok' => 0]
                        );

                        $stokTujuan->stok += $log->qty;
                        $stokTujuan->save();

                        // Buat log masuk di cabang tujuan
                        LogStok::create([
                            'tanggal' => now(),
                            'detail_produk_id' => $log->detail_produk_id,
                            'kode_cabang' => $cabangTujuan,
                            'qty' => $log->qty,
                            'jenis' => 'masuk',
                            'created_by' => Auth::id(),
                            'status' => 'disetujui',
                            'sumber' => 'penambahan',
                            'keterangan' => "Transfer barang masuk dari cabang {$log->kode_cabang}",
                        ]);
                    }
                }
            }
        }


        // Update status log stok
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
