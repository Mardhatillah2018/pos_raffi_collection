<?php

namespace App\Http\Controllers;

use App\Models\DetailProduk;
use Illuminate\Http\Request;

class DetailProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'produk_id' => 'required|exists:produks,id',
            'ukuran_id' => 'required|exists:ukuran_produks,id',
            'harga_modal' => 'required|numeric',
            'harga_jual' => 'required|numeric',
        ]);

        DetailProduk::create($request->all());

        return back()->with('success', 'Detail produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailProduk $detailProduk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailProduk $detailProduk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetailProduk $detailProduk)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'ukuran_id' => 'required|exists:ukuran_produks,id',
            'harga_modal' => 'required|numeric',
            'harga_jual' => 'required|numeric',
        ]);

        $detailProduk->update($request->all());

        return back()->with('success', 'Detail produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailProduk $detailProduk)
    {
        $detailProduk->delete();

        return back()->with('success', 'Detail produk berhasil dihapus.');
    }
}
