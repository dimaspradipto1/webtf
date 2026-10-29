<?php

namespace App\Http\Controllers;

use App\DataTables\SocialMediaDataTable;
use App\Http\Requests\SocialMediaRequest;
use App\Http\Requests\SocialMediaSettingRequest;
use App\Models\SocialMedia;
use App\Models\SocialMediaSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SocialMediaController extends Controller
{
    /**
     * Tampilkan data media sosial dan setting header seksi.
     */
    public function index(SocialMediaDataTable $dataTable, Request $request)
    {
        $setting = SocialMediaSetting::firstOrCreate(
            ['id' => 1],
            [
                'judul_seksi' => 'IKUTI FAKULTAS SAINS DAN TEKNOLOGI DI MEDIA SOSIAL',
                'subjudul_seksi' => '"Dapatkan update terbaru, berita inspiratif, dan berbagai informasi menarik lainnya langsung dari platform media sosial kami. Jangan lewatkan momen penting dari Fakultas Sains dan Teknologi, klik ikon di bawah untuk terhubung sekarang juga!"',
            ]
        );

        $kategori = $request->query('kategori');
        $countAll = SocialMedia::count();
        $countUniversitas = SocialMedia::where(function ($q) {
            $q->where('kategori', 'universitas')->orWhereNull('kategori');
        })->count();
        $countHumas = SocialMedia::where('kategori', 'humas')->count();

        return $dataTable->render('pages.social-media.index', compact(
            'setting',
            'kategori',
            'countAll',
            'countUniversitas',
            'countHumas'
        ));
    }

    /**
     * Update pengaturan Judul & Subjudul Header Seksi Media Sosial.
     */
    public function updateSetting(SocialMediaSettingRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $setting = SocialMediaSetting::firstOrCreate(['id' => 1]);
        $setting->update($validated);

        alert()->success('Berhasil!', 'Pengaturan Seksi Media Sosial berhasil diperbarui.');

        return redirect()->route('social-media.index', ['kategori' => 'universitas']);
    }

    /**
     * Tampilkan form tambah media sosial baru.
     */
    public function create(Request $request): View
    {
        $nextUrutan = (SocialMedia::max('urutan') ?? 0) + 1;
        $kategori = $request->query('kategori', 'universitas');

        return view('pages.social-media.create', compact('nextUrutan', 'kategori'));
    }

    /**
     * Simpan media sosial baru dengan upload PNG logo.
     */
    public function store(SocialMediaRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $url = trim($validated['url']);
        if (! str_starts_with($url, 'http://') && ! str_starts_with($url, 'https://') && ! str_starts_with($url, '/') && ! str_starts_with($url, '#')) {
            $url = 'https://'.$url;
        }

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('social-media', 'public');
        }

        $thumbnailVideoPath = null;
        if ($request->hasFile('thumbnail_video')) {
            $thumbnailVideoPath = $request->file('thumbnail_video')->store('social-media/videos', 'public');
        }

        SocialMedia::create([
            'nama' => $validated['nama'],
            'kategori' => $validated['kategori'],
            'handle' => $validated['handle'] ?? null,
            'logo' => $logoPath,
            'icon' => null,
            'url' => $url,
            'video_url' => $validated['video_url'] ?? null,
            'thumbnail_video' => $thumbnailVideoPath,
            'video_judul' => $validated['video_judul'] ?? null,
            'urutan' => $validated['urutan'] ?? ((SocialMedia::max('urutan') ?? 0) + 1),
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        alert()->success('Berhasil!', 'Link Media Sosial baru berhasil ditambahkan.');

        return redirect()->route('social-media.index', ['kategori' => $validated['kategori']]);
    }

    /**
     * Tampilkan form edit media sosial.
     */
    public function edit(SocialMedia $socialMedia): View
    {
        return view('pages.social-media.edit', compact('socialMedia'));
    }

    /**
     * Update media sosial yang ada (termasuk upload logo baru jika ada).
     */
    public function update(SocialMediaRequest $request, SocialMedia $socialMedia): RedirectResponse
    {
        $validated = $request->validated();

        $url = trim($validated['url']);
        if (! str_starts_with($url, 'http://') && ! str_starts_with($url, 'https://') && ! str_starts_with($url, '/') && ! str_starts_with($url, '#')) {
            $url = 'https://'.$url;
        }

        $data = [
            'nama' => $validated['nama'],
            'kategori' => $validated['kategori'],
            'handle' => $validated['handle'] ?? null,
            'url' => $url,
            'video_url' => $validated['video_url'] ?? null,
            'video_judul' => $validated['video_judul'] ?? null,
            'urutan' => $validated['urutan'] ?? $socialMedia->urutan,
            'is_active' => $request->has('is_active') ? true : false,
        ];

        // If video_url changed, reset direct_video_url so model saves fresh stream
        if (($validated['video_url'] ?? null) !== $socialMedia->video_url) {
            $data['direct_video_url'] = null;
        }

        if ($request->hasFile('logo')) {
            // Hapus file logo lama jika ada
            if ($socialMedia->logo && Storage::disk('public')->exists($socialMedia->logo)) {
                Storage::disk('public')->delete($socialMedia->logo);
            }
            $data['logo'] = $request->file('logo')->store('social-media', 'public');
        }

        if ($request->hasFile('thumbnail_video')) {
            // Hapus file thumbnail video lama jika ada
            if ($socialMedia->thumbnail_video && Storage::disk('public')->exists($socialMedia->thumbnail_video)) {
                Storage::disk('public')->delete($socialMedia->thumbnail_video);
            }
            $data['thumbnail_video'] = $request->file('thumbnail_video')->store('social-media/videos', 'public');
        }

        $socialMedia->update($data);

        alert()->success('Berhasil!', 'Data Media Sosial & Video berhasil diperbarui.');

        return redirect()->route('social-media.index', ['kategori' => $validated['kategori']]);
    }

    /**
     * Hapus media sosial beserta file logo jika ada.
     */
    public function destroy(SocialMedia $socialMedia): RedirectResponse
    {
        $kat = $socialMedia->kategori ?? 'universitas';

        if ($socialMedia->logo && Storage::disk('public')->exists($socialMedia->logo)) {
            Storage::disk('public')->delete($socialMedia->logo);
        }

        if ($socialMedia->thumbnail_video && Storage::disk('public')->exists($socialMedia->thumbnail_video)) {
            Storage::disk('public')->delete($socialMedia->thumbnail_video);
        }

        $socialMedia->delete();

        alert()->success('Berhasil!', 'Link Media Sosial berhasil dihapus.');

        return redirect()->route('social-media.index', ['kategori' => $kat]);
    }
}
