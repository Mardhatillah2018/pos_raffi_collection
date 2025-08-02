<?php

namespace App\Http\Controllers;

use App\Models\DetailProduk;
use App\Models\LogStok;
use App\Models\Produk;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produkStok = \App\Models\Stok::with('detailProduk.produk')
            ->selectRaw('detail_produk_id, SUM(stok) as total_stok')
            ->groupBy('detail_produk_id')
            ->get()
            ->groupBy(fn($item) => $item->detailProduk->produk->id)
            ->map(function ($group) {
                $produk = $group->first()->detailProduk->produk;
                return (object)[
                    'produk_id' => $produk->id,
                    'nama_produk' => $produk->nama_produk,
                    'total_stok' => $group->sum('total_stok'),
                ];
            });

        return view('stok.index', ['produkStok' => $produkStok]);
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
        $produk = Produk::findOrFail($id);
        $detailProduks = DetailProduk::with(['produk', 'ukuran'])
            ->where('produk_id', $id)
            ->get();

        $detailProdukIds = $detailProduks->pluck('id');
        $stokList = Stok::whereIn('detail_produk_id', $detailProdukIds)->get();

        return view('stok.detail-stok', compact('produk', 'detailProduks', 'stokList'));
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
