<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $user = Auth::user();
    $cabangs = Cabang::all();

    $karyawans = Karyawan::with('cabang')
        ->where('kode_cabang', $user->kode_cabang)
        ->get();

    return view('karyawan.index', compact('karyawans', 'cabangs'));
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
            'nama' => 'required|string|max:100',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
            'kode_cabang' => 'required|exists:cabangs,kode_cabang',
        ]);

        Karyawan::create($request->all());

        return redirect()->back()->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
            'kode_cabang' => 'required|exists:cabangs,kode_cabang',
        ]);

        $karyawan->update($request->all());

        return redirect()->back()->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();

        return redirect()->back()->with('success', 'Data karyawan berhasil dihapus.');
    }
}
