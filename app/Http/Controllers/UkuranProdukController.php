<?php

namespace App\Http\Controllers;

use App\Models\UkuranProduk;
use Illuminate\Http\Request;

class UkuranProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ukuranProduks = UkuranProduk::all();
        return view('ukuran-produk.index', compact('ukuranProduks'));
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
            'kode_ukuran' => 'required|string|max:10|unique:ukuran_produks,kode_ukuran',
            'nama_ukuran' => 'required|string|max:50',
        ]);


        UkuranProduk::create([
            'kode_ukuran' => $request->kode_ukuran,
            'nama_ukuran' => $request->nama_ukuran,
        ]);

        return redirect()->route('ukuran-produk.index')
                        ->with('success', 'Ukuran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(UkuranProduk $ukuranProduk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UkuranProduk $ukuranProduk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UkuranProduk $ukuranProduk)
    {
        $request->validate([
        'kode_ukuran' => 'required|string|max:10|unique:ukuran_produks,kode_ukuran,' . $ukuranProduk->id,
        'nama_ukuran' => 'required|string|max:50',
        ]);

        $ukuranProduk->update([
            'kode_ukuran' => $request->kode_ukuran,
            'nama_ukuran' => $request->nama_ukuran,
        ]);

        return redirect()->route('ukuran-produk.index')
                        ->with('success', 'Ukuran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UkuranProduk $ukuranProduk)
    {
         $ukuranProduk->delete();

        return redirect()->route('ukuran-produk.index')
                        ->with('success', 'Ukuran berhasil dihapus.');
    }
}
