<?php

namespace App\Http\Controllers;

use App\DataTables\GalleryDataTable;
use App\Http\Requests\GalleryRequest;
use App\Models\Gallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryController extends Controller
{
    /**
     * Tampilkan daftar galeri via DataTables.
     */
    public function index(GalleryDataTable $dataTables)
    {
        return $dataTables->render('pages.gallery.index');
    }

    /**
     * Tampilkan form tambah foto.
     */
    public function create(): View
    {
        return view('pages.gallery.create');
    }

    /**
     * Simpan foto baru ke storage dan database.
     */
    public function store(GalleryRequest $request): RedirectResponse
    {
        $path = null;

        if ($request->hasFile('foto')) {
            // Simpan ke storage/app/public/gallery
            $path = $request->file('foto')->store('gallery', 'public');
        }

        Gallery::create([
            'judul' => $request->judul,
            'kategori' => $request->kategori ?? 'universitas',
            'deskripsi' => $request->deskripsi,
            'url' => $path,
        ]);

        alert()->success('Berhasil!', 'Foto galeri berhasil ditambahkan.');

        return redirect()->route('gallery.index')->with('success', 'Foto galeri berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit foto.
     */
    public function edit(Gallery $gallery): View
    {
        return view('pages.gallery.edit', compact('gallery'));
    }

    /**
     * Update data galeri.
     * Jika ada foto baru: hapus foto lama, simpan yang baru.
     * Jika tidak ada foto baru: tetap pakai foto lama.
     */
    public function update(GalleryRequest $request, Gallery $gallery): RedirectResponse
    {
        $data = [
            'judul' => $request->judul,
            'kategori' => $request->kategori ?? 'universitas',
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('foto')) {
            // Hapus foto lama dari storage jika ada
            if ($gallery->url && Storage::disk('public')->exists($gallery->url)) {
                Storage::disk('public')->delete($gallery->url);
            }
            // Simpan foto baru
            $data['url'] = $request->file('foto')->store('gallery', 'public');
        }

        $gallery->update($data);

        alert()->success('Berhasil!', 'Data galeri berhasil diperbarui.');

        return redirect()->route('gallery.index')->with('success', 'Data galeri berhasil diperbarui.');
    }

    /**
     * Hapus foto dari storage dan database.
     */
    public function destroy(Gallery $gallery): RedirectResponse
    {
        // Hapus file dari storage
        if ($gallery->url && Storage::disk('public')->exists($gallery->url)) {
            Storage::disk('public')->delete($gallery->url);
        }

        $gallery->delete();

        alert()->success('Berhasil!', 'Foto galeri berhasil dihapus.');

        return redirect()->route('gallery.index')->with('success', 'Foto galeri berhasil dihapus.');
    }
}
