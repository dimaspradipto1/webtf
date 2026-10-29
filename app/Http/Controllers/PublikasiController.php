<?php

namespace App\Http\Controllers;

use App\Models\Publikasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublikasiController extends Controller
{
    public function index(): View
    {
        $publikasis = Publikasi::orderBy('urutan')->get();

        if ($publikasis->isEmpty()) {
            $defaults = [
                [
                    'icon' => 'bi-file-earmark-medical',
                    'judul' => 'Penelitian Dosen',
                    'link' => 'https://lppm.uis.ac.id/',
                    'deskripsi' => 'Portal LPPM Teknik Informatika',
                    'urutan' => 1,
                    'aktif' => true,
                ],
                [
                    'icon' => 'bi-journal-richtext',
                    'judul' => 'Publikasi Ilmiah',
                    'link' => 'https://journal.uis.ac.id/',
                    'deskripsi' => 'Portal E-Journal OJS UIS',
                    'urutan' => 2,
                    'aktif' => true,
                ],
                [
                    'icon' => 'bi-heart-pulse',
                    'judul' => 'Pengabdian Masyarakat',
                    'link' => 'https://lppm.uis.ac.id/',
                    'deskripsi' => 'Portal Pengabdian Masyarakat LPPM UIS',
                    'urutan' => 3,
                    'aktif' => true,
                ],
                [
                    'icon' => 'bi-briefcase',
                    'judul' => 'Kerja Sama Riset',
                    'link' => 'https://lppm.uis.ac.id/',
                    'deskripsi' => 'Kerja Sama Riset & Kemitraan UIS',
                    'urutan' => 4,
                    'aktif' => true,
                ],
                [
                    'icon' => 'bi-archive-fill',
                    'judul' => 'Repository Karya Ilmiah',
                    'link' => 'https://repository.uis.ac.id/',
                    'deskripsi' => 'Repositori Dokumen & Karya Ilmiah UIS',
                    'urutan' => 5,
                    'aktif' => true,
                ],
                [
                    'icon' => 'bi-award-fill',
                    'judul' => 'SINTA Kemendikbud',
                    'link' => 'https://sinta.kemdikbud.go.id/',
                    'deskripsi' => 'Profil Publikasi Dosen SINTA Kemendikbud',
                    'urutan' => 6,
                    'aktif' => true,
                ],
            ];

            foreach ($defaults as $d) {
                Publikasi::create($d);
            }

            $publikasis = Publikasi::orderBy('urutan')->get();
        }

        return view('pages.publikasi.index', compact('publikasis'));
    }

    public function updateAll(Request $request): RedirectResponse
    {
        $request->validate([
            'publikasis' => ['required', 'array', 'min:1'],
            'publikasis.*.judul' => ['required', 'string', 'max:255'],
            'publikasis.*.icon' => ['nullable', 'string', 'max:100'],
            'publikasis.*.link' => ['nullable', 'string', 'max:500'],
        ], [
            'publikasis.*.judul.required' => 'Nama Menu Publikasi tidak boleh kosong.',
        ]);

        $submittedIds = [];
        $publikasisInput = $request->input('publikasis', []);

        foreach ($publikasisInput as $index => $data) {
            $id = ! empty($data['id']) ? $data['id'] : null;
            $linkValue = ! empty(trim($data['link'] ?? '')) ? trim($data['link']) : null;
            if ($linkValue && ! str_starts_with($linkValue, 'http://') && ! str_starts_with($linkValue, 'https://') && ! str_starts_with($linkValue, '/') && ! str_starts_with($linkValue, '#')) {
                $linkValue = 'https://'.$linkValue;
            }

            $payload = [
                'icon' => ! empty($data['icon']) ? $data['icon'] : 'bi-journal-richtext',
                'judul' => $data['judul'],
                'link' => $linkValue,
                'deskripsi' => ! empty($data['deskripsi']) ? $data['deskripsi'] : $data['judul'],
                'urutan' => $index + 1,
                'aktif' => isset($data['aktif']) && $data['aktif'] == '1',
            ];

            if ($id && ($existing = Publikasi::find($id))) {
                $existing->update($payload);
                $submittedIds[] = $existing->id;
            } else {
                $new = Publikasi::create($payload);
                $submittedIds[] = $new->id;
            }
        }

        if (! empty($submittedIds)) {
            Publikasi::whereNotIn('id', $submittedIds)->delete();
        }

        alert()->success('Berhasil!', 'Pengaturan Link Menu Publikasi berhasil disimpan.');

        return redirect()->route('publikasi.index');
    }
}
