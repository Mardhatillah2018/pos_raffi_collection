<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
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

        if ($user->role === 'super_admin') {
            User::where('id', $user->id)->update(['kode_cabang' => null]);
            $request->session()->forget('kode_cabang_superadmin');

            return redirect()->route('pilih-cabang');
        }

        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->withInput();
}


    public function showPilihCabangForm()
    {
        $user = User::find(Auth::id());
        if ($user->role === 'super_admin') {
            $user->kode_cabang = null;
            $user->save();
        }

        return view('pilih-cabang');
    }

    public function simpanCabang(Request $request)
    {
        $request->validate([
            'kode_cabang' => 'required|exists:cabangs,kode_cabang',
        ]);

        // Simpan session
        session(['kode_cabang_superadmin' => $request->kode_cabang]);

        $user = User::find(Auth::id());
        $user->kode_cabang = $request->kode_cabang;
        $user->save();

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        if (Auth::check() && Auth::user()->role === 'super_admin') {
            $user = User::find(Auth::id());
            $user->kode_cabang = null;
            $user->save();
        }

        Auth::logout();
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
