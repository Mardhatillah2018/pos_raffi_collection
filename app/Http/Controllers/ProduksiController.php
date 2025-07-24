<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\DetailProduk;
use App\Models\DetailProduksi;
use App\Models\Produksi;
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
        $produksis = Produksi::with(['detailProduksis', 'user'])->orderBy('tanggal_produksi', 'desc')->get();
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
            // 'kode_cabang' => 'required|string|max:10',
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
                DetailProduksi::create([
                    'produksi_id' => $produksi->id,
                    'detail_produk_id' => $detailId,
                    'qty' => $request->qty[$i],
                ]);
            }

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
    public function show(Produksi $produksi)
    {
        //
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
    public function update(Request $request, Produksi $produksi)
    {
        $request->validate([
            'kode_cabang' => 'required|string|max:10',
            'tanggal_produksi' => 'required|date',
            'total_biaya' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $produksi->update([
            'kode_cabang' => $request->kode_cabang,
            'tanggal_produksi' => $request->tanggal_produksi,
            'total_biaya' => $request->total_biaya,
            'keterangan' => $request->keterangan,
        ]);

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
