<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\DetailProduk;
use App\Models\DetailProduksi;
use App\Models\Pengeluaran;
use App\Models\Produksi;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produksis = Produksi::with([
            'detailProduksis.detailProduk.produk',
            'detailProduksis.detailProduk.ukuran',
            'user'
        ])->orderBy('tanggal_produksi', 'desc')->get();

        $cabangs = Cabang::all();

        $detailProduks = DetailProduk::with(['produk', 'ukuran'])->get();

        return view('produksi.index', compact('produksis', 'cabangs', 'detailProduks'));
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
        'tanggal_produksi' => 'required|date',
        'total_biaya' => 'required|numeric',
        'keterangan' => 'nullable|string',
        'detail_produk_id.*' => 'required|integer|exists:detail_produks,id',
        'qty.*' => 'required|integer|min:1',
    ]);

    DB::beginTransaction();

    try {
        $produksi = Produksi::create([
            'kode_cabang' => Auth::user()->kode_cabang,
            'tanggal_produksi' => $request->tanggal_produksi,
            'total_biaya' => $request->total_biaya,
            'keterangan' => $request->keterangan,
            'created_by' => Auth::id(),
        ]);

        foreach ($request->detail_produk_id as $i => $detailId) {
            $qty = $request->qty[$i];

            // Simpan ke detail produksis
            DetailProduksi::create([
                'produksi_id' => $produksi->id,
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
        }

        // Simpan juga ke tabel pengeluarans (kategori biaya produksi)
        Pengeluaran::create([
            'tanggal' => $request->tanggal_produksi,
            'kode_cabang' => Auth::user()->kode_cabang,
            'created_by' => Auth::id(),
            'kategori_id' => 5,
            'total_pengeluaran' => $request->total_biaya,
            'keterangan' => 'Biaya Produksi tanggal ' . $request->tanggal_produksi,
        ]);

        DB::commit();
        return redirect()->route('produksi.index')->with('success', 'Data produksi berhasil ditambahkan.');
    } catch (\Throwable $e) {
        DB::rollback();
        return back()->withErrors('Gagal menyimpan data produksi: ' . $e->getMessage());
    }
}


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $produksi = Produksi::with(['detailProduksis.detailProduk.produk', 'detailProduksis.detailProduk.ukuran', 'user', 'cabang'])->findOrFail($id);

    return view('detail-produksi.index', compact('produksi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produksi $produksi)
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
            'tanggal_produksi' => 'required|date',
            'total_biaya' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'detail_produk_id' => 'required|array|min:1',
            'detail_produk_id.*' => 'required|integer|exists:detail_produks,id',
            'qty' => 'required|array|min:1',
            'qty.*' => 'required|integer|min:1',
        ]);

        // ambil data produksi yg akan diupdate
        $produksi = Produksi::findOrFail($id);

        // update data produksi
        $produksi->update([
            'tanggal_produksi' => $request->tanggal_produksi,
            'total_biaya' => $request->total_biaya,
            'keterangan' => $request->keterangan,
        ]);

        // hapus detail produksi lama
        $produksi->detailProduksis()->delete();

        // tambah detail produksi baru
        foreach ($request->detail_produk_id as $index => $detail_produk_id) {
            DetailProduksi::create([
                'produksi_id' => $produksi->id,
                'detail_produk_id' => $detail_produk_id,
                'qty' => $request->qty[$index],
            ]);
        }

        return redirect()->route('produksi.index')->with('success', 'Data produksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produksi $produksi)
    {
         $produksi->delete();

        return redirect()->route('produksi.index')->with('success', 'Data produksi berhasil dihapus.');
    }
}
