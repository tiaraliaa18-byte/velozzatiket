<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function showLogin()
    {
        // Jika user sudah terlanjur login, langsung lempar ke dashboard sesuai hak aksesnya
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('login');
    }

    /**
     * Memproses data login dari form
     */
    public function login(Request $request)
    {
        // 1. Validasi inputan form
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        // 2. Coba lakukan proses login (Auth::attempt)
        if (Auth::attempt($credentials)) {
            // Jika sukses, amankan session user
            $request->session()->regenerate();

            // Ambil data user yang berhasil login
            $user = Auth::user();

            // Alihkan halaman berdasarkan role user tersebut
            return $this->redirectBasedOnRole($user);
        }

        // 3. JIKA GAGAL: Kembalikan ke halaman login dan munculkan kotak merah pesan error
        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    /**
     * Fungsi pembantu untuk mengarahkan rute berdasarkan role di database
     */
    private function redirectBasedOnRole($user)
    {
        // Mengecek apakah rolenya bernilai 'passenger' atau 'penumpang'
        if ($user->role === 'passenger' || $user->role === 'penumpang') {
            return redirect()->intended('/dashboard');
        }

        // Mengecek apakah rolenya bernilai 'admin'
        if ($user->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        }

        // Jika lolos dari semua syarat di atas (role tidak dikenali), paksa ke dashboard standar
        return redirect()->intended('/dashboard');
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