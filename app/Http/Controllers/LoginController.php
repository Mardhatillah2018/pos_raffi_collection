<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        return view('login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'super_admin' && is_null($user->kode_cabang)) {
    return redirect()->route('pilih-cabang'); // ✅ route GET dengan middleware 'auth'
}


            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    // Simpan cabang untuk super_admin setelah login
    public function simpanCabang(Request $request)
{
    $request->validate([
        'kode_cabang' => 'required|exists:cabangs,kode_cabang',
    ]);

    // Simpan kode cabang ke session, bukan ke database
    session(['kode_cabang_superadmin' => $request->kode_cabang]);

    return redirect('/dashboard');
}


    // Logout
    public function logout(Request $request)
{
    Auth::logout();
    $request->session()->flush(); // HAPUS SEMUA DATA SESSION
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
}


}
