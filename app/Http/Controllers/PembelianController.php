<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\DetailPembelian;
use App\Models\DetailProduk;
use App\Models\LogStok;
use App\Models\Pembelian;
use App\Models\Pengeluaran;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembelians = Pembelian::with([
            'detailPembelian.detailProduk.produk',
            'detailPembelian.detailProduk.ukuran',
            'user'
        ])->orderBy('tanggal_pembelian', 'desc')->get();

        $cabangs = Cabang::all();

        $detailProduks = DetailProduk::with(['produk', 'ukuran'])->get();

        return view('pembelian.index', compact('pembelians', 'cabangs', 'detailProduks'));
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
            'tanggal_pembelian' => 'required|date',
            'total_biaya' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'detail_produk_id.*' => 'required|integer|exists:detail_produks,id',
            'qty.*' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $pembelian = Pembelian::create([
                'kode_cabang' => Auth::user()->kode_cabang,
                'tanggal_pembelian' => $request->tanggal_pembelian,
                'total_biaya' => $request->total_biaya,
                'keterangan' => $request->keterangan,
                'created_by' => Auth::id(),
            ]);

            foreach ($request->detail_produk_id as $i => $detailId) {
                $qty = $request->qty[$i];

                // Simpan ke detail pembelians
                DetailPembelian::create([
                    'pembelian_id' => $pembelian->id,
                    'detail_produk_id' => $detailId,
                    'qty' => $qty,
                ]);

                // Tambah/update ke tabel stoks
                $stok = Stok::where('detail_produk_id', $detailId)
                    ->where('kode_cabang', Auth::user()->kode_cabang)
                    ->first();

                if ($stok) {
                    $stok->stok += $qty;
                    $stok->save();
                } else {
                    Stok::create([
                        'detail_produk_id' => $detailId,
                        'kode_cabang' => Auth::user()->kode_cabang,
                        'stok' => $qty,
                    ]);
                }
                // Simpan ke log_stoks (stok masuk karena produksi)
                LogStok::create([
                    'detail_produk_id' => $detailId,
                    'kode_cabang' => Auth::user()->kode_cabang,
                    'tanggal' => $request->tanggal_pembelian,
                    'qty' => $qty,
                    'jenis' => 'masuk',
                    'created_by' => Auth::id(),
                    'status' => 'disetujui',
                    'sumber' => 'pembelian',
                    'keterangan' => 'Pembelian Barang Jadi tanggal ' . $request->tanggal_pembelian,
                ]);
            }

            // Simpan juga ke tabel pengeluarans (kategori biaya pembelian)
            Pengeluaran::create([
                'tanggal' => $request->tanggal_pembelian,
                'kode_cabang' => Auth::user()->kode_cabang,
                'created_by' => Auth::id(),
                'kategori_id' => 3,
                'total_pengeluaran' => $request->total_biaya,
                'keterangan' => 'Biaya Pembelian tanggal ' . $request->tanggal_pembelian,
            ]);

            DB::commit();
            return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollback();
            return back()->withErrors('Gagal menyimpan data pembelian: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pembelian = Pembelian::with(['detailPembelian.detailProduk.produk', 'detailPembelian.detailProduk.ukuran', 'user', 'cabang'])->findOrFail($id);

        return view('pembelian.detail-pembelian', compact('pembelian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembelian $pembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         // validasi input
        $request->validate([
            'tanggal_pembelian' => 'required|date',
            'total_biaya' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'detail_produk_id' => 'required|array|min:1',
            'detail_produk_id.*' => 'required|integer|exists:detail_produks,id',
            'qty' => 'required|array|min:1',
            'qty.*' => 'required|integer|min:1',
        ]);

        // ambil data pembelian yg akan diupdate
        $pembelian = Pembelian::findOrFail($id);

        // update data pembelian
        $pembelian->update([
            'tanggal_pembelian' => $request->tanggal_pembelian,
            'total_biaya' => $request->total_biaya,
            'keterangan' => $request->keterangan,
        ]);

        // hapus detail pembelian lama
        $pembelian->detailPembelian()->delete();

        // tambah detail pembelian baru
        foreach ($request->detail_produk_id as $index => $detail_produk_id) {
            DetailPembelian::create([
                'pembelian_id' => $pembelian->id,
                'detail_produk_id' => $detail_produk_id,
                'qty' => $request->qty[$index],
            ]);
        }

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembelian $pembelian)
    {
        $pembelian->delete();

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil dihapus.');
    }
}
