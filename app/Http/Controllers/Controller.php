<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Fungsi Awal: Menampilkan halaman login
    public function showLogin()
    {
        // Besok kita akan buat file tampilan login.blade.php di folder resources/views
        return view('auth.login'); 
    }

    // Fungsi Utama: Memproses validasi login
    public function login(Request $request)
    {
        // Validasi inputan dari user (Email wajib diisi & sesuai format, password wajib diisi)
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Proses pengecekan ke database (Auth::attempt otomatis mencocokkan email & password)
        if (Auth::attempt($credentials)) {
            // Jika cocok, buat ulang session baru agar aman
            $request->session()->regenerate();

            // Cek Role Pengguna untuk diarahkan (Redirect) ke halaman yang sesuai
            $user = Auth::user();
            
            if ($user->role === 'admin') {
                // Jika dia Admin, arahkan ke dashboard admin
                return redirect()->intended('/admin/dashboard');
            }

            // Jika dia Penumpang biasa, arahkan ke halaman utama pencarian tiket
            return redirect()->intended('/dashboard');
        }

        // Jika email atau password salah, kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Fungsi Akhir: Logout dari aplikasi
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}