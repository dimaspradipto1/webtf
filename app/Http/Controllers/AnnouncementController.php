<?php

namespace App\Http\Controllers;

use App\DataTables\AnnouncementDataTable;
use App\Http\Requests\AnnouncementRequest;
use App\Models\Agenda;
use App\Models\Announcement;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function __construct(
        protected FileUploadService $fileUploadService
    ) {}

    public function index(AnnouncementDataTable $dataTable)
    {
        $totalAnnouncements = Announcement::count();
        $totalAgendas = Agenda::count();

        return $dataTable->render('pages.announcement.index', compact('totalAnnouncements', 'totalAgendas'));
    }

    public function create(): View
    {
        $nextUrutan = (Announcement::max('urutan') ?? 0) + 1;

        return view('pages.announcement.create', compact('nextUrutan'));
    }

    public function store(AnnouncementRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $this->fileUploadService->upload($request->file('file'), 'announcements');
        }

        Announcement::create([
            'title' => $validated['title'],
            'date' => $validated['date'],
            'content' => $validated['content'] ?? null,
            'file_path' => $filePath,
            'link_url' => $validated['link_url'] ?? null,
            'is_active' => $request->boolean('is_active', true),
            'urutan' => $validated['urutan'] ?? ((Announcement::max('urutan') ?? 0) + 1),
            'created_by' => Auth::id(),
        ]);

        return redirect()
            ->route('announcements.index')
            ->with('success', 'Pengumuman baru berhasil dipublikasikan.');
    }

    public function edit(Announcement $announcement): View
    {
        return view('pages.announcement.edit', compact('announcement'));
    }

    public function update(AnnouncementRequest $request, Announcement $announcement): RedirectResponse
    {
        $validated = $request->validated();

        $filePath = $announcement->file_path;

        if ($request->boolean('delete_file') && $filePath) {
            $this->fileUploadService->delete($filePath);
            $filePath = null;
        }

        if ($request->hasFile('file')) {
            if ($announcement->file_path) {
                $this->fileUploadService->delete($announcement->file_path);
            }
            $filePath = $this->fileUploadService->upload($request->file('file'), 'announcements');
        }

        $announcement->update([
            'title' => $validated['title'],
            'date' => $validated['date'],
            'content' => $validated['content'] ?? null,
            'file_path' => $filePath,
            'link_url' => $validated['link_url'] ?? null,
            'is_active' => $request->boolean('is_active'),
            'urutan' => $validated['urutan'] ?? $announcement->urutan,
        ]);

        return redirect()
            ->route('announcements.index')
            ->with('success', 'Data pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement): RedirectResponse
    {
        if ($announcement->file_path) {
            $this->fileUploadService->delete($announcement->file_path);
        }

        $announcement->delete();

        return redirect()
            ->route('announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}
