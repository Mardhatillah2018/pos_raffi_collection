<?php

namespace App\Http\Controllers;

use App\Models\KategoriPengeluaran;
use Illuminate\Http\Request;

class KategoriPengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoriPengeluarans = KategoriPengeluaran::all();
        return view('kategori-pengeluaran.index', compact('kategoriPengeluarans'));
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
            'nama_kategori' => 'required|string|max:255',
        ]);

        KategoriPengeluaran::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('kategori-pengeluaran.index')
                         ->with('success', 'Kategori pengeluaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriPengeluaran $kategoriPengeluaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategoriPengeluaran = KategoriPengeluaran::findOrFail($id);
        $kategoriPengeluaran->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('kategori-pengeluaran.index')
                         ->with('success', 'Kategori pengeluaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kategoriPengeluaran = KategoriPengeluaran::findOrFail($id);
        $kategoriPengeluaran->delete();

        return redirect()->route('kategori-pengeluaran.index')
                         ->with('success', 'Kategori pengeluaran berhasil dihapus.');
    }
}
