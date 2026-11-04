<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Checkrole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 1. Admin memiliki akses penuh ke seluruh rute admin
        if ($user->isAdmin()) {
            return $next($request);
        }

        // 2. Tentukan pola rute yang diizinkan berdasarkan multi-role
        $allowedPatterns = ['dashboard', 'user.my-profile', 'user.update-my-*', 'logout'];

        if ($user->hasExactRole('penulis')) {
            $allowedPatterns[] = 'news.*';
            $allowedPatterns[] = 'announcements.*';
            $allowedPatterns[] = 'agenda.*';
        }

        if ($user->hasExactRole('organisasi')) {
            $allowedPatterns[] = 'organisasi-mahasiswa.*';
        }

        $isAllowed = false;
        foreach ($allowedPatterns as $pattern) {
            if ($request->routeIs($pattern)) {
                $isAllowed = true;
                break;
            }
        }

        if (! $isAllowed) {
            if ($user->hasExactRole('organisasi') && ! $user->hasExactRole('penulis')) {
                return redirect()->route('organisasi-mahasiswa.index')->with('error', 'Akses dibatasi. Akun Anda hanya memiliki izin untuk mengelola Organisasi Mahasiswa.');
            }
            if ($user->hasExactRole('penulis')) {
                return redirect()->route('news.index')->with('error', 'Akses dibatasi. Akun Anda hanya memiliki izin untuk mengelola Berita & Pengumuman.');
            }

            return redirect()->route('dashboard')->with('error', 'Akses dibatasi untuk akun Anda.');
        }

        return $next($request);
    }
}
