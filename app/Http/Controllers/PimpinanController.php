<?php

namespace App\Http\Controllers;

use App\Models\Pimpinan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PimpinanController extends Controller
{
    public function create(): View
    {
        return view('pages.pimpinan.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'tempat_tanggal_lahir' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'max:255'],
            'pendidikan' => ['nullable', 'string'],
            'pengalaman_organisasi' => ['nullable', 'string'],
            'pengalaman_kerja' => ['nullable', 'string'],
            'riwayat_jabatan' => ['nullable', 'string'],
            'baris' => ['required', 'integer', 'min:1', 'max:10'],
            'urutan' => ['required', 'integer', 'min:1', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('pimpinan', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        Pimpinan::create($validated);

        return redirect()
            ->route('about.index')
            ->with('success', 'Data Profil Pimpinan berhasil ditambahkan.');
    }

    public function edit(Pimpinan $pimpinan): View
    {
        return view('pages.pimpinan.edit', compact('pimpinan'));
    }

    public function update(Request $request, Pimpinan $pimpinan): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'tempat_tanggal_lahir' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'max:255'],
            'pendidikan' => ['nullable', 'string'],
            'pengalaman_organisasi' => ['nullable', 'string'],
            'pengalaman_kerja' => ['nullable', 'string'],
            'riwayat_jabatan' => ['nullable', 'string'],
            'baris' => ['required', 'integer', 'min:1', 'max:10'],
            'urutan' => ['required', 'integer', 'min:1', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('foto')) {
            if ($pimpinan->foto && ! str_starts_with($pimpinan->foto, 'dekan/') && Storage::disk('public')->exists($pimpinan->foto)) {
                Storage::disk('public')->delete($pimpinan->foto);
            }
            $validated['foto'] = $request->file('foto')->store('pimpinan', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        if ($pimpinan->nama !== $validated['nama']) {
            $baseSlug = Str::slug($validated['nama']) ?: 'pimpinan';
            $slug = $baseSlug;
            $counter = 1;
            while (Pimpinan::where('slug', $slug)->where('id', '!=', $pimpinan->id)->exists()) {
                $slug = $baseSlug.'-'.$counter++;
            }
            $validated['slug'] = $slug;
        }

        $pimpinan->update($validated);

        return redirect()
            ->route('about.index')
            ->with('success', 'Data Profil Pimpinan berhasil diperbarui.');
    }

    public function destroy(Pimpinan $pimpinan): RedirectResponse
    {
        if ($pimpinan->foto && ! str_starts_with($pimpinan->foto, 'dekan/') && Storage::disk('public')->exists($pimpinan->foto)) {
            Storage::disk('public')->delete($pimpinan->foto);
        }

        $pimpinan->delete();

        return redirect()
            ->route('about.index')
            ->with('success', 'Data Profil Pimpinan berhasil dihapus.');
    }
}

