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
            'nama_dekan' => 'Ka Prodi Teknik Informatika',
            'jabatan_dekan' => 'Ka Prodi Teknik Informatika',
            'kutipan_singkat' => 'Selamat datang di Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi. Kami bertekad membentuk sarjana komputer yang unggul, berjiwa technopreneur, dan berkarakter Imtaq yang siap memimpin industri di kancah nasional maupun global.',
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
            ->with('success', 'Data Sambutan Ka Prodi Teknik Informatika & Foto berhasil diperbarui.');
    }
}
