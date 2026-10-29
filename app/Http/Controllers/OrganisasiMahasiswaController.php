<?php

namespace App\Http\Controllers;

use App\DataTables\OrganisasiMahasiswaDataTable;
use App\Http\Requests\OrganisasiMahasiswaRequest;
use App\Models\OrganisasiMahasiswa;
use App\Models\OrganisasiMahasiswaSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OrganisasiMahasiswaController extends Controller
{
    public function index(OrganisasiMahasiswaDataTable $dataTable)
    {
        $setting = OrganisasiMahasiswaSetting::firstOrCreate(
            ['id' => 1],
            [
                'badge_teks' => 'LEMBAGA KEMAHASISWAAN · UIS',
                'judul' => 'Kiprah & Kepemimpinan Mahasiswa UIS',
                'judul_highlight' => 'Kepemimpinan',
                'deskripsi' => 'Eksplorasi ragam organisasi kemahasiswaan, himpunan program studi, dan unit kegiatan minat bakat di Teknik Informatika Batam. Ruang kolaborasi untuk mengasah karakter, kepemimpinan, dan inovasi civitas kampus.',
                'tombol_teks' => 'Jelajahi Semua Organisasi',
                'tombol_url' => null,
                'hint_teks' => 'Scroll mouse atau geser kartu untuk menggulir ormawa',
            ]
        );

        return $dataTable->render('pages.organisasi-mahasiswa.index', compact('setting'));
    }

    public function updateSetting(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'badge_teks' => ['nullable', 'string', 'max:255'],
            'judul' => ['required', 'string', 'max:255'],
            'judul_highlight' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'tombol_teks' => ['nullable', 'string', 'max:255'],
            'tombol_url' => ['nullable', 'string', 'max:255'],
            'hint_teks' => ['nullable', 'string', 'max:255'],
        ], [
            'judul.required' => 'Judul seksi wajib diisi.',
        ]);

        $setting = OrganisasiMahasiswaSetting::firstOrCreate(['id' => 1]);
        $setting->update($validated);

        if (function_exists('alert')) {
            alert()->success('Berhasil!', 'Pengaturan seksi Organisasi Mahasiswa berhasil disimpan.');
        }

        return redirect()->route('organisasi-mahasiswa.index')->with('success', 'Pengaturan seksi Organisasi Mahasiswa berhasil disimpan.');
    }

    public function create(): View
    {
        return view('pages.organisasi-mahasiswa.create');
    }

    public function store(OrganisasiMahasiswaRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active');

        // Generate unique slug
        $base = ! empty($data['singkatan']) ? $data['singkatan'] : $data['nama_organisasi'];
        $slug = Str::slug($base);
        $originalSlug = $slug;
        $count = 1;
        while (OrganisasiMahasiswa::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }
        $data['slug'] = $slug;

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('organisasi/logo', 'public');
        }

        if ($request->hasFile('foto_kegiatan')) {
            $data['foto_kegiatan'] = $request->file('foto_kegiatan')->store('organisasi/kegiatan', 'public');
        }

        OrganisasiMahasiswa::create($data);

        return redirect()
            ->route('organisasi-mahasiswa.index')
            ->with('success', 'Data organisasi mahasiswa berhasil ditambahkan.');
    }

    public function edit(OrganisasiMahasiswa $organisasiMahasiswa): View
    {
        return view('pages.organisasi-mahasiswa.edit', compact('organisasiMahasiswa'));
    }

    public function update(OrganisasiMahasiswaRequest $request, OrganisasiMahasiswa $organisasiMahasiswa): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('logo')) {
            if ($organisasiMahasiswa->logo && Storage::disk('public')->exists($organisasiMahasiswa->logo)) {
                Storage::disk('public')->delete($organisasiMahasiswa->logo);
            }
            $data['logo'] = $request->file('logo')->store('organisasi/logo', 'public');
        }

        if ($request->hasFile('foto_kegiatan')) {
            if ($organisasiMahasiswa->foto_kegiatan && Storage::disk('public')->exists($organisasiMahasiswa->foto_kegiatan)) {
                Storage::disk('public')->delete($organisasiMahasiswa->foto_kegiatan);
            }
            $data['foto_kegiatan'] = $request->file('foto_kegiatan')->store('organisasi/kegiatan', 'public');
        }

        $organisasiMahasiswa->update($data);

        return redirect()
            ->route('organisasi-mahasiswa.index')
            ->with('success', 'Data organisasi mahasiswa berhasil diperbarui.');
    }

    public function destroy(OrganisasiMahasiswa $organisasiMahasiswa): RedirectResponse
    {
        if ($organisasiMahasiswa->logo && Storage::disk('public')->exists($organisasiMahasiswa->logo)) {
            Storage::disk('public')->delete($organisasiMahasiswa->logo);
        }

        if ($organisasiMahasiswa->foto_kegiatan && Storage::disk('public')->exists($organisasiMahasiswa->foto_kegiatan)) {
            Storage::disk('public')->delete($organisasiMahasiswa->foto_kegiatan);
        }

        $organisasiMahasiswa->delete();

        return redirect()
            ->route('organisasi-mahasiswa.index')
            ->with('success', 'Data organisasi mahasiswa berhasil dihapus.');
    }
}
