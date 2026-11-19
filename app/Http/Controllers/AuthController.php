<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Tampilkan form login.
     * Jika sudah login, redirect sesuai role.
     */
    public function login()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        return view('layouts.auth.login');
    }

    /**
     * Proses login menggunakan UserRequest (Form Request).
     * Validasi otomatis dijalankan sebelum method ini dipanggil.
     */
    public function loginproses(UserRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return $this->redirectByRole();
        }

        // Jika gagal login, kembali ke form dengan pesan error
        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Email atau password salah. Silakan coba lagi.',
            ]);
    }

    /**
     * Proses logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }

    /**
     * Redirect ke halaman yang sesuai berdasarkan role user.
     */
    private function redirectByRole()
    {
        $role = Auth::user()->roles;

        return match ($role) {
            'admin' => to_route('dashboard')->with('success', 'Selamat datang kembali, Admin!'),
            default => to_route('dashboard')->with('success', 'Selamat datang!'),
        };
    }

    /**
     * Tampilkan halaman Lupa Password.
     */
    public function showForgotPasswordForm()
    {
        return view('layouts.auth.forgot-password');
    }

    /**
     * Kirim tautan reset password ke email pengguna menggunakan Laravel Password Broker.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
        ]);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'Tautan reset password telah dikirim ke alamat email Anda. Silakan periksa kotak masuk atau folder spam.');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Alamat email tidak ditemukan atau gagal mengirim tautan reset password.']);
    }

    /**
     * Tampilkan halaman Reset Password.
     */
    public function showResetPasswordForm(Request $request, string $token)
    {
        return view('layouts.auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    /**
     * Proses pembaruan password baru.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Kata sandi Anda berhasil diperbarui. Silakan login dengan kata sandi baru.');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Token reset password tidak valid atau sudah kedaluwarsa.']);
    }
}
