<?php

namespace App\Http\Controllers;

use App\DataTables\AgendaDataTable;
use App\Http\Requests\AgendaRequest;
use App\Models\Agenda;
use App\Models\Announcement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AgendaController extends Controller
{
    public function index(AgendaDataTable $dataTable)
    {
        $totalAnnouncements = Announcement::count();
        $totalAgendas = Agenda::count();

        return $dataTable->render('pages.agenda.index', compact('totalAnnouncements', 'totalAgendas'));
    }

    public function create(): View
    {
        $nextUrutan = (Agenda::max('urutan') ?? 0) + 1;

        return view('pages.agenda.create', compact('nextUrutan'));
    }

    public function store(AgendaRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Agenda::create([
            'title' => $validated['title'],
            'date_text' => $validated['date_text'],
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'location' => $validated['location'] ?? null,
            'description' => $validated['description'] ?? null,
            'link_url' => $validated['link_url'] ?? null,
            'is_active' => $request->boolean('is_active', true),
            'urutan' => $validated['urutan'] ?? ((Agenda::max('urutan') ?? 0) + 1),
            'created_by' => Auth::id(),
        ]);

        return redirect()
            ->route('agenda.index')
            ->with('success', 'Agenda baru berhasil ditambahkan.');
    }

    public function edit(Agenda $agenda): View
    {
        return view('pages.agenda.edit', compact('agenda'));
    }

    public function update(AgendaRequest $request, Agenda $agenda): RedirectResponse
    {
        $validated = $request->validated();

        $agenda->update([
            'title' => $validated['title'],
            'date_text' => $validated['date_text'],
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'location' => $validated['location'] ?? null,
            'description' => $validated['description'] ?? null,
            'link_url' => $validated['link_url'] ?? null,
            'is_active' => $request->boolean('is_active'),
            'urutan' => $validated['urutan'] ?? $agenda->urutan,
        ]);

        return redirect()
            ->route('agenda.index')
            ->with('success', 'Data agenda berhasil diperbarui.');
    }

    public function destroy(Agenda $agenda): RedirectResponse
    {
        $agenda->delete();

        return redirect()
            ->route('agenda.index')
            ->with('success', 'Agenda berhasil dihapus.');
    }
}
