<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Menampilkan halaman form login
    public function showLogin()
    {
        return view('login'); 
    }

    // 2. Memproses data saat tombol "Login" diklik
    public function login(Request $request)
    {
        // Validasi input email dan password
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Proses pencocokan ke database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // PENGKONDISIAN UTAMA BERDASARKAN ROLE SEEDER Anda:
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

            // Kita pastikan jika rolenya 'passenger' (sesuai isi UserSeeder), langsung lempar ke dashboard
            if ($user->role === 'passenger') {
                return redirect()->intended('/dashboard');
            }
            
            // Jaga-jaga jika di database Anda tertulis 'penumpang'
            if ($user->role === 'penumpang') {
                return redirect()->intended('/dashboard');
            }
        }

        // Jika gagal cocok, balikkan ke login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // 3. Keluar dari aplikasi
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}