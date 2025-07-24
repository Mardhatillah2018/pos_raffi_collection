<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        $cabangs = Cabang::all();
        return view('user.index', compact('users', 'cabangs'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:super_admin,admin_cabang',
            'kode_cabang' => 'nullable|string'
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'kode_cabang' => $request->kode_cabang,
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil didaftarkan');
    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:super_admin,admin_cabang',
            'kode_cabang' => 'nullable|string'
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'kode_cabang' => $request->kode_cabang,
        ]);

        return redirect()->route('user.index')->with('success', 'Data user berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')
                        ->with('success', 'User berhasil dihapus.');
    }

}
