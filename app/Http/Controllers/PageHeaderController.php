<?php

namespace App\Http\Controllers;

use App\Models\Akademik;
use App\Models\PageHeader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageHeaderController extends Controller
{
    /**
     * Halaman kelola semua header & breadcrumb frontend
     */
    public function index(Request $request): View
    {
        $headers = [];
        foreach (PageHeader::$masterDefaults as $key => $meta) {
            $headers[$key] = PageHeader::get($key);
        }

        $categories = [
            'Akademik' => ['kalender', 'kurikulum', 'pedoman', 'sistem'],
            'Profil' => ['sejarah', 'sambutan-kaprodi', 'pimpinan', 'struktur-organisasi', 'visi-misi', 'fasilitas'],
            'Civitas' => ['dosen'],
            'Portal Layanan' => ['tracer-study', 'testimoni', 'edokumen', 'sop', 'dokumen-akreditasi-tf', 'sertifikat-akreditasi', 'laminfokom', 'ban-pt', 'beasiswa', 'prestasi', 'organisasi'],
            'PMB' => ['pendaftaran-pmb', 'informasi-pmb', 'pengumuman-pmb'],
            'Informasi & Galeri' => ['berita', 'galeri', 'faq', 'kontak', 'layanan'],
        ];

        $activeTab = $request->query('tab', 'Akademik');

        return view('pages.page-header.index', compact('headers', 'categories', 'activeTab'));
    }

    /**
     * Update header & breadcrumb untuk satu halaman tertentu
     */
    public function update(Request $request, string $pageKey): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'subjudul' => ['nullable', 'string', 'max:1000'],
            'badge_text' => ['nullable', 'string', 'max:255'],
            'breadcrumb_label' => ['nullable', 'string', 'max:255'],
        ], [
            'judul.required' => 'Judul Utama Halaman wajib diisi.',
            'judul.max' => 'Judul Utama Halaman maksimal 255 karakter.',
            'subjudul.max' => 'Subjudul / Ringkasan Header maksimal 1000 karakter.',
        ]);

        $header = PageHeader::get($pageKey);
        $header->update([
            'judul' => $validated['judul'],
            'subjudul' => $validated['subjudul'] ?? null,
            'badge_text' => $validated['badge_text'] ?? ($header->badge_text ?: PageHeader::$defaultBadge),
            'breadcrumb_label' => $validated['breadcrumb_label'] ?? ($header->breadcrumb_label ?: $validated['judul']),
        ]);

        // Sinkronisasi otomatis ke tabel akademiks jika tipe tersebut tersedia
        $akademik = Akademik::where('tipe', $pageKey)->first();
        if ($akademik) {
            $akademik->update([
                'judul' => $validated['judul'],
                'subjudul' => $validated['subjudul'] ?? null,
            ]);
        }

        alert()->success('Berhasil!', "Pengaturan Header Halaman {$validated['judul']} berhasil disimpan.");

        return redirect()->back();
    }
}
