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
            $user = Auth::user();
            return $this->redirectBasedOnRole($user);
        }

        return view('login');
    }

    /**
     * Memproses login
     */
    public function login(Request $request)
    {
        // 1. Validasi inputan form login
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Coba lakukan proses otentikasi login ke database
        if (Auth::attempt($credentials)) {
            // Jika sukses, amankan session user agar tidak terkena session fixation
            $request->session()->regenerate();

            // Ambil data user yang berhasil masuk
            $user = Auth::user();

            // Alihkan halaman berdasarkan role user tersebut
            return $this->redirectBasedOnRole($user);
        }

        // 3. JIKA GAGAL: Kembalikan ke halaman login dan munculkan pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Fungsi pengarah rute otomatis berdasarkan role di database
     */
    private function redirectBasedOnRole($user)
    {
        // Pastikan properti role ada di dalam object user sebelum diubah ke huruf kecil
        $role = isset($user->role) ? strtolower($user->role) : '';

        // 🌟 JIKA ADMIN: Lempar langsung ke halaman dashboard jadwal admin
        if ($role === 'admin') {
            return redirect()->intended('/admin/jadwal');
        }

        // 🌟 JIKA PENUMPANG: Arahkan ke rute halaman depan / dashboard penumpang miliknya
        if ($role === 'passenger' || $role === 'penumpang' || $role === 'user') {
            return redirect()->intended('/dashboard'); 
        }

        // Jika role di database ternyata kosong atau tidak dikenali, amankan ke halaman utama
        return redirect()->intended('/');
    }

    /**
     * Memproses fungsi keluar aplikasi (Logout)
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}