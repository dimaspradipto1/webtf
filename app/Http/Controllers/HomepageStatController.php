<?php

namespace App\Http\Controllers;

use App\Models\HomepageStat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomepageStatController extends Controller
{
    public function index(): View
    {
        HomepageStat::ensureTable();

        $stats = HomepageStat::orderBy('urutan')->orderBy('id')->get();

        return view('pages.homepage-stat.index', compact('stats'));
    }

    public function store(Request $request): RedirectResponse
    {
        HomepageStat::ensureTable();

        $validated = $request->validate([
            'nilai' => ['required', 'string', 'max:60'],
            'label' => ['required', 'string', 'max:120'],
            'ikon' => ['nullable', 'string', 'max:80'],
            'urutan' => ['nullable', 'integer', 'min:0', 'max:999'],
        ], [
            'nilai.required' => 'Angka / nilai statistik wajib diisi.',
            'label.required' => 'Label statistik wajib diisi.',
        ]);

        $validated['urutan'] = $validated['urutan'] ?? ((HomepageStat::max('urutan') ?? 0) + 1);
        $validated['is_active'] = $request->has('is_active');

        HomepageStat::create($validated);

        return redirect()
            ->route('homepage-stat.index')
            ->with('success', 'Item angka statistik beranda berhasil ditambahkan.');
    }

    public function bulkUpdate(Request $request): RedirectResponse
    {
        HomepageStat::ensureTable();

        $validated = $request->validate([
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'integer', 'exists:homepage_stats,id'],
            'items.*.nilai' => ['required', 'string', 'max:60'],
            'items.*.label' => ['required', 'string', 'max:120'],
            'items.*.ikon' => ['nullable', 'string', 'max:80'],
            'items.*.urutan' => ['nullable', 'integer', 'min:0', 'max:999'],
            'items.*.is_active' => ['nullable'],
        ], [
            'items.*.nilai.required' => 'Setiap angka / nilai statistik wajib diisi.',
            'items.*.label.required' => 'Setiap label statistik wajib diisi.',
        ]);

        foreach ($validated['items'] as $row) {
            HomepageStat::where('id', $row['id'])->update([
                'nilai' => trim($row['nilai']),
                'label' => trim($row['label']),
                'ikon' => !empty($row['ikon']) ? trim($row['ikon']) : null,
                'urutan' => (int) ($row['urutan'] ?? 0),
                'is_active' => !empty($row['is_active']),
            ]);
        }

        return redirect()
            ->route('homepage-stat.index')
            ->with('success', 'Seluruh angka statistik beranda berhasil diperbarui.');
    }

    public function destroy(HomepageStat $homepageStat): RedirectResponse
    {
        $homepageStat->delete();

        return redirect()
            ->route('homepage-stat.index')
            ->with('success', 'Item angka statistik beranda berhasil dihapus.');
    }
}
