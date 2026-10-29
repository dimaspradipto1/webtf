<?php

namespace App\Http\Controllers;

use App\DataTables\MilestoneDataTable;
use App\Http\Requests\MilestoneRequest;
use App\Models\About;
use App\Models\Milestone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MilestoneController extends Controller
{
    public function index(MilestoneDataTable $dataTable)
    {
        $about = About::first();

        return $dataTable->render('pages.milistone.index', compact('about'));
    }

    public function updateSetting(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'sejarah_label' => ['nullable', 'string', 'max:255'],
            'sejarah_judul' => ['nullable', 'string', 'max:255'],
            'sejarah_judul_highlight' => ['nullable', 'string', 'max:255'],
            'sejarah_deskripsi_1' => ['nullable', 'string'],
            'sejarah_deskripsi_2' => ['nullable', 'string'],
            'sejarah_card_judul' => ['nullable', 'string', 'max:255'],
            'sejarah_card_subjudul' => ['nullable', 'string', 'max:255'],
            'sejarah_card_narasi' => ['nullable', 'string'],
            'sejarah_pilar_1' => ['nullable', 'string', 'max:100'],
            'sejarah_pilar_2' => ['nullable', 'string', 'max:100'],
            'sejarah_pilar_3' => ['nullable', 'string', 'max:100'],
            'sejarah_link_url' => ['nullable', 'string', 'max:1000'],
            'sejarah_link_label' => ['nullable', 'string', 'max:255'],
            'sejarah_pimpinan_judul' => ['nullable', 'string', 'max:255'],
            'eras' => ['nullable', 'array'],
            'eras.*.era' => ['nullable', 'string', 'max:255'],
            'eras.*.items' => ['nullable', 'array'],
            'eras.*.items.*.periode' => ['nullable', 'string', 'max:255'],
            'eras.*.items.*.pimpinan' => ['nullable', 'string', 'max:255'],
        ]);

        // Process eras array if submitted
        if ($request->has('eras')) {
            $cleanEras = [];
            foreach ($request->input('eras', []) as $eraData) {
                $eraTitle = trim($eraData['era'] ?? '');
                $cleanItems = [];
                foreach ($eraData['items'] ?? [] as $row) {
                    $periode = trim($row['periode'] ?? '');
                    $pimpinan = trim($row['pimpinan'] ?? '');
                    if ($periode !== '' || $pimpinan !== '') {
                        $cleanItems[] = [
                            'periode' => $periode,
                            'pimpinan' => $pimpinan,
                        ];
                    }
                }
                if ($eraTitle !== '' || count($cleanItems) > 0) {
                    $cleanEras[] = [
                        'era' => $eraTitle ?: 'Era Kepemimpinan',
                        'items' => $cleanItems,
                    ];
                }
            }
            $validated['sejarah_pimpinan'] = $cleanEras;
        }
        unset($validated['eras']);

        $about = About::first();
        if ($about) {
            $about->update($validated);
        } else {
            About::create($validated);
        }

        return redirect()
            ->route('milestone.index')
            ->with('success', 'Pengaturan Sejarah YAPISTA & Pimpinan dari Masa ke Masa berhasil diperbarui.');
    }

    public function create(): View
    {
        return view('pages.milistone.create');
    }

    public function store(MilestoneRequest $request): RedirectResponse
    {
        Milestone::create($request->validated());

        return redirect()
            ->route('milestone.index')
            ->with('success', 'Milestone berhasil ditambahkan.');
    }

    public function edit(Milestone $milestone): View
    {
        return view('pages.milistone.edit', compact('milestone'));
    }

    public function update(MilestoneRequest $request, Milestone $milestone): RedirectResponse
    {
        $milestone->update($request->validated());

        return redirect()
            ->route('milestone.index')
            ->with('success', 'Milestone berhasil diperbarui.');
    }

    public function destroy(Milestone $milestone): RedirectResponse
    {
        $milestone->delete();

        return redirect()
            ->route('milestone.index')
            ->with('success', 'Milestone berhasil dihapus.');
    }
}
