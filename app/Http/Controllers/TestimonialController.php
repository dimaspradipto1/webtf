<?php

namespace App\Http\Controllers;

use App\DataTables\TestimonialDataTable;
use App\Http\Requests\TestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    /**
     * Tampilkan daftar ulasan via DataTables.
     */
    public function index(TestimonialDataTable $dataTables)
    {
        return $dataTables->render('pages.testimonial.index');
    }

    /**
     * Tampilkan form tambah ulasan dari admin.
     */
    public function create(): View
    {
        $existingCategories = Testimonial::whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori')
            ->toArray();

        return view('pages.testimonial.create', compact('existingCategories'));
    }

    /**
     * Simpan ulasan baru.
     */
    public function store(TestimonialRequest $request): RedirectResponse
    {
        Testimonial::create([
            'nama' => $request->nama,
            'pekerjaan' => $request->pekerjaan,
            'kategori' => $request->kategori,
            'bintang' => $request->bintang,
            'pesan' => $request->pesan,
            'aktif' => $request->has('aktif') ? true : false,
        ]);

        alert()->success('Berhasil!', 'Testimoni berhasil ditambahkan.');

        return redirect()->route('testimonial.index');
    }

    /**
     * Tampilkan form edit ulasan.
     */
    public function edit(Testimonial $testimonial): View
    {
        $existingCategories = Testimonial::whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori')
            ->toArray();

        return view('pages.testimonial.edit', compact('testimonial', 'existingCategories'));
    }

    /**
     * Update data ulasan.
     */
    public function update(TestimonialRequest $request, Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update([
            'nama' => $request->nama,
            'pekerjaan' => $request->pekerjaan,
            'kategori' => $request->kategori,
            'bintang' => $request->bintang,
            'pesan' => $request->pesan,
            'aktif' => $request->has('aktif') ? true : false,
        ]);

        alert()->success('Berhasil!', 'Testimoni berhasil diperbarui.');

        return redirect()->route('testimonial.index');
    }

    /**
     * Hapus data ulasan.
     */
    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();

        alert()->success('Berhasil!', 'Testimoni berhasil dihapus.');

        return redirect()->route('testimonial.index');
    }
}
