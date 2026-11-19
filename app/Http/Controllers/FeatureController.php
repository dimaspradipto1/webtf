<?php

namespace App\Http\Controllers;

use App\DataTables\FeatureDataTable;
use App\Http\Requests\FeatureRequest;
use App\Models\Feature;
use App\Providers\AppServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FeatureController extends Controller
{
    /**
     * Tampilkan daftar keunggulan via DataTables.
     */
    public function index(FeatureDataTable $dataTables)
    {
        return $dataTables->render('pages.feature.index');
    }

    /**
     * Tampilkan form tambah keunggulan.
     */
    public function create(): View
    {
        return view('pages.feature.create');
    }

    /**
     * Simpan data keunggulan baru.
     */
    public function store(FeatureRequest $request): RedirectResponse
    {
        Feature::create([
            'icon' => $request->icon,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'urutan' => $request->urutan ?? 0,
        ]);

        AppServiceProvider::recordContentUpdate();
        alert()->success('Berhasil!', 'Keunggulan berhasil ditambahkan.');

        return redirect()->route('feature.index');
    }

    /**
     * Tampilkan form edit keunggulan.
     */
    public function edit(Feature $feature): View
    {
        return view('pages.feature.edit', compact('feature'));
    }

    /**
     * Update data keunggulan.
     */
    public function update(FeatureRequest $request, Feature $feature): RedirectResponse
    {
        $feature->update([
            'icon' => $request->icon,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'urutan' => $request->urutan ?? 0,
        ]);

        AppServiceProvider::recordContentUpdate();
        alert()->success('Berhasil!', 'Keunggulan berhasil diperbarui.');

        return redirect()->route('feature.index');
    }

    /**
     * Hapus data keunggulan.
     */
    public function destroy(Feature $feature): RedirectResponse
    {
        $feature->delete();

        AppServiceProvider::recordContentUpdate();
        alert()->success('Berhasil!', 'Keunggulan berhasil dihapus.');

        return redirect()->route('feature.index');
    }
}
