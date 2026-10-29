<?php

namespace App\Http\Controllers;

use App\Http\Requests\StrukturOrganisasiRequest;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class StrukturOrganisasiController extends Controller
{
    public function index(): View
    {
        $struktur = StrukturOrganisasi::first();

        return view('pages.struktur-organisasi.index', compact('struktur'));
    }

    public function store(StrukturOrganisasiRequest $request): RedirectResponse
    {
        $struktur = StrukturOrganisasi::first() ?? new StrukturOrganisasi;

        if ($request->hasFile('url_struktur')) {
            // Delete old file if exists
            if ($struktur->url_struktur) {
                Storage::disk('public')->delete(str_replace('storage/', '', $struktur->url_struktur));
            }

            // Upload new file
            $path = $request->file('url_struktur')->store('struktur-organisasi', 'public');
            $struktur->url_struktur = 'storage/'.$path;
            $struktur->url_struktur_organisasi = 'storage/'.$path;
            $struktur->save();
        }

        alert()->success('Berhasil!', 'Struktur organisasi berhasil diperbarui.');

        return redirect()->route('struktur-organisasi.index');
    }

    public function destroy(StrukturOrganisasi $strukturOrganisasi): RedirectResponse
    {
        if ($strukturOrganisasi->url_struktur) {
            Storage::disk('public')->delete(str_replace('storage/', '', $strukturOrganisasi->url_struktur));
        }
        $strukturOrganisasi->delete();

        alert()->success('Berhasil!', 'Struktur organisasi berhasil dihapus.');

        return redirect()->route('struktur-organisasi.index');
    }
}
