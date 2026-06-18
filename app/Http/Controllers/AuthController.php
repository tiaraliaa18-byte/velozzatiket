<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Tambahkan ini agar Laravel mengenali model User

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return view('login');
    }

    /**
     * Memproses login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 1. Cari user di database berdasarkan email yang diinput
        $user = User::where('email', $request->email)->first();

        // 2. Cek apakah usernya ada dan password teks biasa cocok 100%
        if ($user && $user->password === $request->password) {
            
            // 3. Jika cocok, paksa login masuk ke sistem Laravel
            Auth::login($user);
            $request->session()->regenerate();

            return redirect('/dashboard');
        }

        // Jika salah, balikkan ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}