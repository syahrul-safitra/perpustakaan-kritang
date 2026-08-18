<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginAnggotaController extends Controller
{
    /**
     * Menampilkan form login anggota.
     */
    public function showLoginForm()
    {
        if (Auth::guard('anggota')->check()) {
            return redirect()->intended('/anggota/dashboard');
        }

        return view('Siswa.Auth.login');
    }

    /**
     * Memproses autentikasi anggota via nomor_induk.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nomor_induk' => ['required', 'string'],
            'password'    => ['required', 'string'],
        ], [
            'nomor_induk.required' => 'Nomor Induk (NISN/NIP) wajib diisi.',
            'password.required'    => 'Password wajib diisi.',
        ]);

        if (Auth::guard('anggota')->attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/anggota/dashboard')
                             ->with('success', 'Berhasil masuk ke portal anggota!');
        }

        return back()->withErrors([
            'nomor_induk' => 'Nomor Induk atau Password yang Anda masukkan salah.',
        ])->onlyInput('nomor_induk');
    }

    /**
     * Logout anggota.
     */
    public function logout(Request $request)
    {
        Auth::guard('anggota')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/anggota/login')->with('success', 'Anda telah keluar dari portal anggota.');
    }
}