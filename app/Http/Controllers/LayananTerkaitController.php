<?php

namespace App\Http\Controllers;

use App\DataTables\LayananTerkaitDataTable;
use App\Http\Requests\LayananTerkaitRequest;
use App\Http\Requests\LayananTerkaitSettingRequest;
use App\Models\LayananTerkait;
use App\Models\LayananTerkaitSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class LayananTerkaitController extends Controller
{
    /**
     * Tampilkan data layanan terkait dan setting header.
     */
    public function index(LayananTerkaitDataTable $dataTable)
    {
        $setting = LayananTerkaitSetting::firstOrCreate(
            ['id' => 1],
            [
                'judul_seksi' => 'LAYANAN TERKAIT',
                'subjudul_seksi' => 'Akses cepat ke berbagai sistem dan layanan digital Fakultas Ilmu Kesehatan Teknik Informatika untuk mendukung kegiatan akademik, administrasi, dan kemahasiswaan.',
            ]
        );

        return $dataTable->render('pages.layanan-terkait.index', compact('setting'));
    }

    /**
     * Update pengaturan Judul & Deskripsi Header Seksi Layanan Terkait.
     */
    public function updateSetting(LayananTerkaitSettingRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $setting = LayananTerkaitSetting::firstOrCreate(['id' => 1]);
        $setting->update($validated);

        alert()->success('Berhasil!', 'Pengaturan Judul & Deskripsi Seksi Layanan Terkait berhasil disimpan.');

        return redirect()->route('layanan-terkait.index');
    }

    /**
     * Tampilkan form tambah layanan terkait.
     */
    public function create(): View
    {
        $nextUrutan = (LayananTerkait::max('urutan') ?? 0) + 1;

        return view('pages.layanan-terkait.create', compact('nextUrutan'));
    }

    /**
     * Simpan data layanan terkait baru.
     */
    public function store(LayananTerkaitRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $url = trim($validated['url']);
        if (! str_starts_with($url, 'http://') && ! str_starts_with($url, 'https://') && ! str_starts_with($url, '/') && ! str_starts_with($url, '#')) {
            $url = 'https://'.$url;
        }

        $data = [
            'nama' => $validated['nama'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'url' => $url,
            'icon' => $validated['icon'] ?? 'bi-link-45deg',
            'urutan' => $validated['urutan'] ?? ((LayananTerkait::max('urutan') ?? 0) + 1),
            'is_active' => $request->has('is_active') ? true : false,
        ];

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('layanan-terkait', 'public');
        }

        LayananTerkait::create($data);

        alert()->success('Berhasil!', 'Layanan Terkait baru berhasil ditambahkan.');

        return redirect()->route('layanan-terkait.index');
    }

    /**
     * Tampilkan form edit data layanan terkait.
     */
    public function edit(LayananTerkait $layananTerkait): View
    {
        return view('pages.layanan-terkait.edit', compact('layananTerkait'));
    }

    /**
     * Update data layanan terkait.
     */
    public function update(LayananTerkaitRequest $request, LayananTerkait $layananTerkait): RedirectResponse
    {
        $validated = $request->validated();

        $url = trim($validated['url']);
        if (! str_starts_with($url, 'http://') && ! str_starts_with($url, 'https://') && ! str_starts_with($url, '/') && ! str_starts_with($url, '#')) {
            $url = 'https://'.$url;
        }

        $data = [
            'nama' => $validated['nama'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'url' => $url,
            'icon' => $validated['icon'] ?? ($layananTerkait->icon ?: 'bi-link-45deg'),
            'urutan' => $validated['urutan'] ?? $layananTerkait->urutan,
            'is_active' => $request->has('is_active') ? true : false,
        ];

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika disimpan di storage public
            if ($layananTerkait->logo && ! str_starts_with($layananTerkait->logo, 'assets/') && Storage::disk('public')->exists($layananTerkait->logo)) {
                Storage::disk('public')->delete($layananTerkait->logo);
            }
            $data['logo'] = $request->file('logo')->store('layanan-terkait', 'public');
        }

        // Hapus logo jika dicentang hapus
        if ($request->boolean('remove_logo') && ! $request->hasFile('logo')) {
            if ($layananTerkait->logo && ! str_starts_with($layananTerkait->logo, 'assets/') && Storage::disk('public')->exists($layananTerkait->logo)) {
                Storage::disk('public')->delete($layananTerkait->logo);
            }
            $data['logo'] = null;
        }

        $layananTerkait->update($data);

        alert()->success('Berhasil!', 'Data Layanan Terkait berhasil diperbarui.');

        return redirect()->route('layanan-terkait.index');
    }

    /**
     * Hapus data layanan terkait.
     */
    public function destroy(LayananTerkait $layananTerkait): RedirectResponse
    {
        if ($layananTerkait->logo && ! str_starts_with($layananTerkait->logo, 'assets/') && Storage::disk('public')->exists($layananTerkait->logo)) {
            Storage::disk('public')->delete($layananTerkait->logo);
        }

        $layananTerkait->delete();

        alert()->success('Berhasil!', 'Layanan Terkait berhasil dihapus.');

        return redirect()->route('layanan-terkait.index');
    }
}
