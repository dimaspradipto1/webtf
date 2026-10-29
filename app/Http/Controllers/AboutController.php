<?php

namespace App\Http\Controllers;

use App\DataTables\AboutDataTable;
use App\Http\Requests\AboutRequest;
use App\Models\About;
use App\Models\Pimpinan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        $pimpinans = Pimpinan::orderBy('baris')->orderBy('urutan')->orderBy('id')->get();

        return view('pages.about.index', compact('pimpinans'));
    }

    public function create(): View
    {
        return view('pages.about.create');
    }

    public function store(AboutRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('video_file')) {
            $data['video_file'] = $request->file('video_file')->store('about-videos', 'public');
        }

        if (! empty($data['video_url'])) {
            $raw = trim($data['video_url']);
            if (preg_match('/<iframe.*?src=["\']([^"\']+)["\']/i', $raw, $frameMatch)) {
                $raw = $frameMatch[1];
            }
            $data['video_url'] = $raw;
        }

        About::create($data);

        return redirect()
            ->route('about.index')
            ->with('success', 'Data Profil Tentang Kami berhasil ditambahkan.');
    }

    public function edit(About $about): View
    {
        return view('pages.about.edit', compact('about'));
    }

    public function update(AboutRequest $request, About $about): RedirectResponse
    {
        $data = $request->validated();

        // Hapus video file jika diminta
        if ($request->boolean('delete_video_file')) {
            if ($about->video_file && Storage::disk('public')->exists($about->video_file)) {
                Storage::disk('public')->delete($about->video_file);
            }
            $data['video_file'] = null;
        }

        if ($request->hasFile('video_file')) {
            if ($about->video_file && Storage::disk('public')->exists($about->video_file)) {
                Storage::disk('public')->delete($about->video_file);
            }
            $data['video_file'] = $request->file('video_file')->store('about-videos', 'public');
        }

        if (! empty($data['video_url'])) {
            $raw = trim($data['video_url']);
            if (preg_match('/<iframe.*?src=["\']([^"\']+)["\']/i', $raw, $frameMatch)) {
                $raw = $frameMatch[1];
            }
            $data['video_url'] = $raw;
        }

        $about->update($data);

        return redirect()
            ->route('about.index')
            ->with('success', 'Data Profil Tentang Kami berhasil diperbarui.');
    }

    public function destroy(About $about): RedirectResponse
    {
        if ($about->video_file && Storage::disk('public')->exists($about->video_file)) {
            Storage::disk('public')->delete($about->video_file);
        }

        $about->delete();

        return redirect()
            ->route('about.index')
            ->with('success', 'Data Profil Tentang Kami berhasil dihapus.');
    }
}
