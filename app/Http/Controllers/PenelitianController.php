<?php

namespace App\Http\Controllers;

use App\Models\Penelitian;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PenelitianController extends Controller
{
    public function index(Request $request): View
    {
        Penelitian::ensureTable();

        $activeJenis = $request->query('jenis', 'all');
        $activeTahun = $request->query('tahun');
        $search = trim((string) $request->query('search', ''));

        $query = Penelitian::query();

        if (in_array($activeJenis, ['penelitian', 'pengabdian'], true)) {
            $query->where('jenis', $activeJenis);
        } else {
            $activeJenis = 'all';
        }

        if (!empty($activeTahun)) {
            $query->where('tahun', (int) $activeTahun);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('ketua', 'like', "%{$search}%")
                    ->orWhere('anggota', 'like', "%{$search}%")
                    ->orWhere('sumber_dana', 'like', "%{$search}%")
                    ->orWhere('bidang_riset', 'like', "%{$search}%");
            });
        }

        $items = $query->orderByDesc('tahun')->orderByDesc('id')->paginate(15)->withQueryString();

        $stats = [
            'all' => Penelitian::count(),
            'penelitian' => Penelitian::where('jenis', 'penelitian')->count(),
            'pengabdian' => Penelitian::where('jenis', 'pengabdian')->count(),
        ];

        $years = Penelitian::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');

        return view('pages.penelitian.index', compact('items', 'stats', 'years', 'activeJenis', 'activeTahun', 'search'));
    }

    public function store(Request $request): RedirectResponse
    {
        Penelitian::ensureTable();

        $validated = $request->validate([
            'jenis' => ['required', 'in:penelitian,pengabdian'],
            'judul' => ['required', 'string', 'max:500'],
            'ketua' => ['required', 'string', 'max:255'],
            'anggota' => ['nullable', 'string', 'max:1000'],
            'sumber_dana' => ['nullable', 'string', 'max:255'],
            'tahun' => ['required', 'integer', 'min:2000', 'max:2100'],
            'bidang_riset' => ['nullable', 'string', 'max:255'],
            'link_publikasi' => ['nullable', 'url', 'max:500'],
        ], [
            'jenis.required' => 'Jenis kegiatan wajib dipilih.',
            'judul.required' => 'Judul penelitian/pengabdian wajib diisi.',
            'ketua.required' => 'Nama ketua pelaksana wajib diisi.',
            'tahun.required' => 'Tahun pelaksanaan wajib diisi.',
            'link_publikasi.url' => 'Tautan publikasi harus berupa URL yang valid.',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Penelitian::create($validated);

        return redirect()
            ->route('penelitian.index', ['jenis' => $request->input('jenis', 'all')])
            ->with('success', 'Data penelitian/pengabdian berhasil ditambahkan.');
    }

    public function update(Request $request, Penelitian $penelitian): RedirectResponse
    {
        $validated = $request->validate([
            'jenis' => ['required', 'in:penelitian,pengabdian'],
            'judul' => ['required', 'string', 'max:500'],
            'ketua' => ['required', 'string', 'max:255'],
            'anggota' => ['nullable', 'string', 'max:1000'],
            'sumber_dana' => ['nullable', 'string', 'max:255'],
            'tahun' => ['required', 'integer', 'min:2000', 'max:2100'],
            'bidang_riset' => ['nullable', 'string', 'max:255'],
            'link_publikasi' => ['nullable', 'url', 'max:500'],
        ], [
            'jenis.required' => 'Jenis kegiatan wajib dipilih.',
            'judul.required' => 'Judul penelitian/pengabdian wajib diisi.',
            'ketua.required' => 'Nama ketua pelaksana wajib diisi.',
            'tahun.required' => 'Tahun pelaksanaan wajib diisi.',
            'link_publikasi.url' => 'Tautan publikasi harus berupa URL yang valid.',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $penelitian->update($validated);

        return redirect()
            ->route('penelitian.index', ['jenis' => $validated['jenis']])
            ->with('success', 'Data penelitian/pengabdian berhasil diperbarui.');
    }

    public function destroy(Penelitian $penelitian): RedirectResponse
    {
        $penelitian->delete();

        return redirect()
            ->route('penelitian.index')
            ->with('success', 'Data penelitian/pengabdian berhasil dihapus.');
    }
}
