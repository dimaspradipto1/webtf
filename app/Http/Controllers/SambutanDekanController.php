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
        $sambutanDekan = SambutanDekan::firstOrCreate([], [
            'nama_dekan' => 'Assoc. Prof. Dr. Ir. Larisang, S.T., M.T., IPU., ASEAN Eng.',
            'jabatan_dekan' => 'Rektor Teknik Informatika (UIS) Batam',
            'kutipan_singkat' => 'Selamat datang di Teknik Informatika (UIS) Batam — Kampusnya Profesional Muda. Kami bertekad membentuk generasi intelektual yang unggul, berjiwa entrepreneur, dan berkarakter Imtaq yang siap memimpin industri di kancah nasional maupun global.',
        ]);

        return view('pages.sambutan-dekan.index', compact('sambutanDekan'));
    }

    public function update(SambutanDekanRequest $request): RedirectResponse
    {
        $validated = $request->validated();

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
            ->with('success', 'Data Sambutan Rektor & Foto berhasil diperbarui.');
    }
}
