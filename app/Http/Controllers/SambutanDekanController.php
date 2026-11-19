<?php

namespace App\Http\Controllers;

use App\Http\Requests\SambutanDekanRequest;
use App\Models\SambutanDekan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SambutanDekanController extends Controller
{
    public function index(): View
    {
        SambutanDekan::ensureVideoColumns();

        $sambutanDekan = SambutanDekan::firstOrCreate([], [
            'nama_dekan' => 'Ka Prodi Teknik Informatika',
            'jabatan_dekan' => 'Ka Prodi Teknik Informatika',
            'kutipan_singkat' => 'Selamat datang di Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi. Kami bertekad membentuk sarjana komputer yang unggul, berjiwa technopreneur, dan berkarakter Imtaq yang siap memimpin industri di kancah nasional maupun global.',
            'video_judul' => 'Video Profil Program Studi Teknik Informatika',
            'video_subjudul' => 'Sematan YouTube • 2–3 menit',
            'video_aktif' => true,
        ]);

        return view('pages.sambutan-dekan.index', compact('sambutanDekan'));
    }

    public function update(SambutanDekanRequest $request): RedirectResponse
    {
        SambutanDekan::ensureVideoColumns();

        $validated = $request->validated();
        $validated['video_aktif'] = $request->has('video_aktif');

        $sambutanDekan = SambutanDekan::firstOrCreate([]);

        if ($request->hasFile('foto_dekan')) {
            // Hapus foto lama jika ada
            if ($sambutanDekan->foto_dekan && Storage::disk('public')->exists($sambutanDekan->foto_dekan)) {
                Storage::disk('public')->delete($sambutanDekan->foto_dekan);
            }
            $validated['foto_dekan'] = $request->file('foto_dekan')->store('dekan', 'public');
        }

        $sambutanDekan->update($validated);

        return redirect()
            ->route('sambutan-rektor.index')
            ->with('success', 'Data Sambutan Ka Prodi & Video Profil Program Studi berhasil diperbarui.');
    }
}
