<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // 1. Buat token
        $token = Str::random(60);

        // 2. Simpan ke database (tabel password_reset_tokens)
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        // 3. Kirim Email (Gunakan Mail::send seperti saat kirim e-tiket)
        $resetLink = url('/reset-password/' . $token . '?email=' . urlencode($request->email));
        
        Mail::raw("Klik link berikut untuk reset password Anda: " . $resetLink, function ($message) use ($request) {
            $message->to($request->email)->subject('Reset Password Velozza');
        });

        return back()->with('status', 'Kami telah mengirimkan link reset password ke email Anda.');
    }

    public function showLinkRequestForm()
    {
        return view('auth.forgot-password'); // Pastikan Anda membuat file ini di resources/views/auth/forgot-password.blade.php
    }

    // Menampilkan halaman form untuk input password baru
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    // Memproses perubahan password ke database
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        // Cek apakah token valid di tabel password_reset_tokens
        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$tokenData) {
            return back()->withErrors(['email' => 'Token tidak valid atau sudah kedaluwarsa.']);
        }

        // Update password user
        DB::table('users')->where('email', $request->email)->update([
            'password' => bcrypt($request->password)
        ]);

        // Hapus token setelah digunakan
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('/login')->with('status', 'Password berhasil diubah!');
    }
}
