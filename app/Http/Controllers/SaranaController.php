<?php

namespace App\Http\Controllers;

use App\DataTables\SaranaDataTable;
use App\Http\Requests\SaranaRequest;
use App\Models\Sarana;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SaranaController extends Controller
{
    /**
     * Tampilkan daftar sarana via DataTables.
     */
    public function index(SaranaDataTable $dataTables)
    {
        return $dataTables->render('pages.sarana.index');
    }

    /**
     * Tampilkan form tambah sarana.
     */
    public function create(): View
    {
        return view('pages.sarana.create');
    }

    /**
     * Simpan data sarana baru (mendukung multi-upload foto ruangan hingga 20 MB per file).
     */
    public function store(SaranaRequest $request): RedirectResponse
    {
        Sarana::ensureColumns();

        $data = [
            'icon' => $request->icon,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'kepala_lab' => $request->kepala_lab,
            'lokasi' => $request->lokasi,
            'kapasitas' => $request->kapasitas,
            'daftar_perangkat' => $request->daftar_perangkat,
            'mata_kuliah_praktikum' => $request->mata_kuliah_praktikum,
            'jadwal_pemakaian' => $request->jadwal_pemakaian,
            'urutan' => $request->urutan ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ];

        $uploadedPaths = [];
        if ($request->hasFile('foto')) {
            $files = $request->file('foto');
            $files = is_array($files) ? $files : [$files];
            foreach ($files as $file) {
                if ($file && $file->isValid()) {
                    $uploadedPaths[] = $file->store('sarana', 'public');
                }
            }
        }

        if (!empty($uploadedPaths)) {
            $data['foto'] = $uploadedPaths[0];
            $data['foto_galeri'] = $uploadedPaths;
        }

        Sarana::create($data);

        alert()->success('Berhasil!', 'Sarana & Laboratorium berhasil ditambahkan.');

        return redirect()->route('sarana.index');
    }

    /**
     * Tampilkan form edit sarana.
     */
    public function edit(Sarana $sarana): View
    {
        Sarana::ensureColumns();

        return view('pages.sarana.edit', compact('sarana'));
    }

    /**
     * Update data sarana (mendukung tambah multi-foto & hapus foto tertentu).
     */
    public function update(SaranaRequest $request, Sarana $sarana): RedirectResponse
    {
        Sarana::ensureColumns();

        $data = [
            'icon' => $request->icon,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'kepala_lab' => $request->kepala_lab,
            'lokasi' => $request->lokasi,
            'kapasitas' => $request->kapasitas,
            'daftar_perangkat' => $request->daftar_perangkat,
            'mata_kuliah_praktikum' => $request->mata_kuliah_praktikum,
            'jadwal_pemakaian' => $request->jadwal_pemakaian,
            'urutan' => $request->urutan ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ];

        $currentPaths = $sarana->all_foto_paths;

        // Hapus foto yang dicentang admin
        $toDelete = $request->input('hapus_foto', []);
        if (is_array($toDelete) && !empty($toDelete)) {
            foreach ($toDelete as $delPath) {
                if (in_array($delPath, $currentPaths, true)) {
                    if (Storage::disk('public')->exists($delPath)) {
                        Storage::disk('public')->delete($delPath);
                    }
                    $currentPaths = array_values(array_filter($currentPaths, fn ($p) => $p !== $delPath));
                }
            }
        }

        // Tambah foto-foto baru
        if ($request->hasFile('foto')) {
            $files = $request->file('foto');
            $files = is_array($files) ? $files : [$files];
            foreach ($files as $file) {
                if ($file && $file->isValid()) {
                    $currentPaths[] = $file->store('sarana', 'public');
                }
            }
        }

        $data['foto'] = $currentPaths[0] ?? null;
        $data['foto_galeri'] = !empty($currentPaths) ? $currentPaths : null;

        $sarana->update($data);

        alert()->success('Berhasil!', 'Sarana & Laboratorium berhasil diperbarui.');

        return redirect()->route('sarana.index');
    }

    /**
     * Hapus data sarana beserta seluruh fotonya.
     */
    public function destroy(Sarana $sarana): RedirectResponse
    {
        foreach ($sarana->all_foto_paths as $path) {
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $sarana->delete();

        alert()->success('Berhasil!', 'Sarana & Laboratorium berhasil dihapus.');

        return redirect()->route('sarana.index');
    }
}
