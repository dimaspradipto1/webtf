<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopbarRequest;
use App\Models\Topbar;
use App\Providers\AppServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TopbarController extends Controller
{
    /**
     * Tampilkan halaman form edit pengaturan topbar langsung (singleton, tanpa tabel index).
     */
    public function index(): View
    {
        $topbar = $this->getOrCreateTopbar();

        return view('pages.topbar.index', compact('topbar'));
    }

    /**
     * Redirect route create langsung ke halaman pengaturan topbar.
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('topbar.index');
    }

    /**
     * Simpan pengaturan topbar (mendukung POST langsung tanpa ID).
     */
    public function store(TopbarRequest $request): RedirectResponse
    {
        return $this->update($request);
    }

    /**
     * Redirect route edit langsung ke halaman pengaturan topbar.
     */
    public function edit(?Topbar $topbar = null): RedirectResponse
    {
        return redirect()->route('topbar.index');
    }

    /**
     * Simpan pembaruan pengaturan topbar.
     */
    public function update(TopbarRequest $request, ?Topbar $topbar = null): RedirectResponse
    {
        $topbar = ($topbar instanceof Topbar && $topbar->exists)
            ? $topbar
            : $this->getOrCreateTopbar();

        $data = $request->validated();
        $data['badge_text'] = ! empty($data['badge_text']) ? $data['badge_text'] : 'TEKNIK INFORMATIKA';
        $data['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;

        // Filter valid social media rows
        $socialMedia = [];
        if ($request->has('social_media') && is_array($request->social_media)) {
            foreach ($request->social_media as $item) {
                if (! empty($item['url'])) {
                    $socialMedia[] = [
                        'platform' => $item['platform'] ?? 'Link',
                        'icon' => ! empty($item['icon']) ? $item['icon'] : 'bi-globe',
                        'url' => $item['url'],
                    ];
                }
            }
        }
        $data['social_media'] = $socialMedia;

        if ($data['is_active']) {
            Topbar::where('id', '!=', $topbar->id)->update(['is_active' => false]);
        }

        $topbar->update($data);

        AppServiceProvider::recordContentUpdate();

        if (function_exists('alert')) {
            alert()->success('Berhasil Disimpan!', 'Pengaturan Topbar & Marquee berhasil diperbarui.');
        }

        return redirect()
            ->route('topbar.index')
            ->with('success', 'Pengaturan Topbar & Marquee berhasil diperbarui.');
    }

    /**
     * Ambil atau buat record Topbar utama (singleton).
     */
    private function getOrCreateTopbar(): Topbar
    {
        $topbar = Topbar::where('is_active', true)->latest('id')->first()
            ?? Topbar::latest('id')->first();

        if (! $topbar) {
            $topbar = Topbar::create([
                'badge_text' => 'TEKNIK INFORMATIKA',
                'marquee_text' => 'Fakultas Sains & Teknologi Universitas Ibnu Sina Fakultasnya Teknokrat Unggul — Program Studi S1 Teknik Informatika (UIS)',
                'badge_icon' => 'bi-laptop',
                'alamat' => 'Kampus Utama Universitas Ibnu Sina, Jl. Teuku Umar, Lubuk Baja, Kota Batam',
                'jam_operasional' => 'Senin – Sabtu: 08.00 – 17.00 WIB',
                'telepon' => '6281234567890',
                'email' => 'fst@uis.ac.id',
                'social_media' => [
                    ['platform' => 'Facebook', 'icon' => 'bi-facebook', 'url' => 'https://facebook.com'],
                    ['platform' => 'Instagram', 'icon' => 'bi-instagram', 'url' => 'https://instagram.com'],
                    ['platform' => 'YouTube', 'icon' => 'bi-youtube', 'url' => 'https://youtube.com'],
                ],
                'is_active' => true,
            ]);
        }

        return $topbar;
    }
}
