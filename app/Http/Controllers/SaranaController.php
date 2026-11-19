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
     * Simpan data sarana baru.
     */
    public function store(SaranaRequest $request): RedirectResponse
    {
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

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('sarana', 'public');
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
        return view('pages.sarana.edit', compact('sarana'));
    }

    /**
     * Update data sarana.
     */
    public function update(SaranaRequest $request, Sarana $sarana): RedirectResponse
    {
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

        if ($request->hasFile('foto')) {
            if ($sarana->foto && Storage::disk('public')->exists($sarana->foto)) {
                Storage::disk('public')->delete($sarana->foto);
            }
            $data['foto'] = $request->file('foto')->store('sarana', 'public');
        }

        $sarana->update($data);

        alert()->success('Berhasil!', 'Sarana & Laboratorium berhasil diperbarui.');

        return redirect()->route('sarana.index');
    }

    /**
     * Hapus data sarana.
     */
    public function destroy(Sarana $sarana): RedirectResponse
    {
        if ($sarana->foto && Storage::disk('public')->exists($sarana->foto)) {
            Storage::disk('public')->delete($sarana->foto);
        }

        $sarana->delete();

        alert()->success('Berhasil!', 'Sarana & Laboratorium berhasil dihapus.');

        return redirect()->route('sarana.index');
    }
}
