<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BeasiswaController extends Controller
{
    public function index(): View
    {
        $beasiswas = Beasiswa::orderBy('urutan')->get();

        if ($beasiswas->isEmpty()) {
            $defaults = [
                [
                    'icon' => 'bi-star-fill',
                    'judul' => 'LPDP',
                    'link' => 'https://lpdp.kemenkeu.go.id/',
                    'deskripsi' => 'Program Beasiswa Lembaga Pengelola Dana Pendidikan (Kemenkeu)',
                    'urutan' => 1,
                    'aktif' => true,
                ],
                [
                    'icon' => 'bi-mortarboard-fill',
                    'judul' => 'KIP',
                    'link' => 'https://kip-kuliah.kemdikbud.go.id/',
                    'deskripsi' => 'Program Beasiswa Kartu Indonesia Pintar (KIP) Kuliah Merdeka',
                    'urutan' => 2,
                    'aktif' => true,
                ],
                [
                    'icon' => 'bi-bank',
                    'judul' => 'BPDDI',
                    'link' => 'https://beasiswa.kemdikbud.go.id/',
                    'deskripsi' => 'Program Beasiswa Pendidikan Dosen dan Sivitas Akademika',
                    'urutan' => 3,
                    'aktif' => true,
                ],
                [
                    'icon' => 'bi-geo-alt-fill',
                    'judul' => 'ADIK',
                    'link' => 'https://adik.kemdikbud.go.id/',
                    'deskripsi' => 'Beasiswa Afirmasi Pendidikan Tinggi untuk Daerah 3T',
                    'urutan' => 4,
                    'aktif' => true,
                ],
                [
                    'icon' => 'bi-airplane-fill',
                    'judul' => 'GARUDA',
                    'link' => 'https://beasiswagaruda.kemdikbud.go.id/',
                    'deskripsi' => 'Beasiswa Garuda ACE / Prestasi Talenta Global',
                    'urutan' => 5,
                    'aktif' => true,
                ],
                [
                    'icon' => 'bi-flag-fill',
                    'judul' => 'INDONESIA MAJU',
                    'link' => 'https://beasiswa.kemdikbud.go.id/program/bim/',
                    'deskripsi' => 'Beasiswa Indonesia Maju (BIM) Program Persiapan & Gelar',
                    'urutan' => 6,
                    'aktif' => true,
                ],
            ];

            foreach ($defaults as $d) {
                Beasiswa::create($d);
            }

            $beasiswas = Beasiswa::orderBy('urutan')->get();
        }

        return view('pages.beasiswa.index', compact('beasiswas'));
    }

    public function updateAll(Request $request): RedirectResponse
    {
        $request->validate([
            'beasiswas' => ['required', 'array', 'min:1'],
            'beasiswas.*.judul' => ['required', 'string', 'max:255'],
            'beasiswas.*.icon' => ['nullable', 'string', 'max:100'],
            'beasiswas.*.link' => ['nullable', 'string', 'max:500'],
        ], [
            'beasiswas.*.judul.required' => 'Nama Menu Beasiswa tidak boleh kosong.',
        ]);

        $submittedIds = [];
        $beasiswasInput = $request->input('beasiswas', []);

        foreach ($beasiswasInput as $index => $data) {
            $id = ! empty($data['id']) ? $data['id'] : null;
            $linkValue = ! empty(trim($data['link'] ?? '')) ? trim($data['link']) : null;
            if ($linkValue && ! str_starts_with($linkValue, 'http://') && ! str_starts_with($linkValue, 'https://') && ! str_starts_with($linkValue, '/') && ! str_starts_with($linkValue, '#')) {
                $linkValue = 'https://'.$linkValue;
            }

            $payload = [
                'icon' => ! empty($data['icon']) ? $data['icon'] : 'bi-award-fill',
                'judul' => $data['judul'],
                'link' => $linkValue,
                'deskripsi' => ! empty($data['deskripsi']) ? $data['deskripsi'] : $data['judul'],
                'urutan' => $index + 1,
                'aktif' => isset($data['aktif']) && $data['aktif'] == '1',
            ];

            if ($id && ($existing = Beasiswa::find($id))) {
                $existing->update($payload);
                $submittedIds[] = $existing->id;
            } else {
                $new = Beasiswa::create($payload);
                $submittedIds[] = $new->id;
            }
        }

        if (! empty($submittedIds)) {
            Beasiswa::whereNotIn('id', $submittedIds)->delete();
        }

        if (function_exists('alert')) {
            alert()->success('Berhasil!', 'Pengaturan Link Menu Beasiswa berhasil disimpan.');
        }

        return redirect()->route('beasiswa.index')->with('success', 'Pengaturan Link Menu Beasiswa berhasil disimpan dan disinkronkan ke navbar.');
    }
}

