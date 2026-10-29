<?php

namespace App\Http\Controllers;

use App\DataTables\KurikulumDataTable;
use App\Http\Requests\KurikulumRequest;
use App\Models\Kurikulum;
use App\Models\Layanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class KurikulumController extends Controller
{
    public function index(KurikulumDataTable $dataTable)
    {
        $prodis = Layanan::where('aktif', true)->orderBy('urutan')->get();

        return $dataTable->render('pages.kurikulum.index', compact('prodis'));
    }

    public function create(): View
    {
        $prodis = Layanan::where('aktif', true)->orderBy('urutan')->get();

        return view('pages.kurikulum.create', compact('prodis'));
    }

    public function store(KurikulumRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active');

        if ($request->filled('layanan_id')) {
            $prodi = Layanan::find($request->layanan_id);
            $data['prodi_nama'] = $prodi?->judul;
        } elseif (empty($kurikulum->layanan_id)) {
            $prodi = Layanan::where('aktif', true)->orderBy('urutan')->first();
            $data['layanan_id'] = $prodi?->id;
            $data['prodi_nama'] = $prodi?->judul;
        } else {
            $prodi = Layanan::where('aktif', true)->orderBy('urutan')->first();
            $data['layanan_id'] = $prodi?->id;
            $data['prodi_nama'] = $prodi?->judul;
        }

        if ($request->hasFile('file_rps')) {
            $data['file_rps'] = $request->file('file_rps')->store('kurikulum/rps', 'public');
        }

        Kurikulum::create($data);

        return redirect()
            ->route('kurikulum.index')
            ->with('success', 'Matakuliah kurikulum berhasil ditambahkan.');
    }

    public function edit(Kurikulum $kurikulum): View
    {
        $prodis = Layanan::where('aktif', true)->orderBy('urutan')->get();

        return view('pages.kurikulum.edit', compact('kurikulum', 'prodis'));
    }

    public function update(KurikulumRequest $request, Kurikulum $kurikulum): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active');

        if ($request->filled('layanan_id')) {
            $prodi = Layanan::find($request->layanan_id);
            $data['prodi_nama'] = $prodi?->judul;
        } elseif (empty($kurikulum->layanan_id)) {
            $prodi = Layanan::where('aktif', true)->orderBy('urutan')->first();
            $data['layanan_id'] = $prodi?->id;
            $data['prodi_nama'] = $prodi?->judul;
        }

        if ($request->hasFile('file_rps')) {
            if ($kurikulum->file_rps && Storage::disk('public')->exists($kurikulum->file_rps)) {
                Storage::disk('public')->delete($kurikulum->file_rps);
            }
            $data['file_rps'] = $request->file('file_rps')->store('kurikulum/rps', 'public');
        }

        $kurikulum->update($data);

        return redirect()
            ->route('kurikulum.index')
            ->with('success', 'Matakuliah kurikulum berhasil diperbarui.');
    }

    public function destroy(Kurikulum $kurikulum): RedirectResponse
    {
        if ($kurikulum->file_rps && Storage::disk('public')->exists($kurikulum->file_rps)) {
            Storage::disk('public')->delete($kurikulum->file_rps);
        }

        $kurikulum->delete();

        return redirect()
            ->route('kurikulum.index')
            ->with('success', 'Matakuliah kurikulum berhasil dihapus.');
    }
}
