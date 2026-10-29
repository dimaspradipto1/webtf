<?php

namespace App\Http\Controllers;

use App\DataTables\UnduhanDataTable;
use App\Http\Requests\UnduhanRequest;
use App\Models\Unduhan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UnduhanController extends Controller
{
    public function index(UnduhanDataTable $dataTable)
    {
        return $dataTable->render('pages.unduhan.index');
    }

    public function create(): View
    {
        return view('pages.unduhan.create');
    }

    public function store(UnduhanRequest $request): RedirectResponse
    {
        $filePath = null;
        $fileSize = $request->file_size;

        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            $filePath = $uploadedFile->store('unduhan', 'public');

            if (! $fileSize) {
                $bytes = $uploadedFile->getSize();
                $fileSize = $this->formatBytes($bytes);
            }
        }

        Unduhan::create([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'file_path' => $filePath,
            'file_url' => $request->file_url,
            'file_size' => $fileSize,
            'deskripsi' => $request->deskripsi,
            'urutan' => $request->urutan ?? 0,
            'is_active' => $request->has('is_active') ? true : false,
            'download_count' => 0,
        ]);

        alert()->success('Berhasil!', 'Item E-Dokumen baru berhasil ditambahkan.');

        return redirect()->route('unduhan.index');
    }

    public function edit(Unduhan $unduhan): View
    {
        return view('pages.unduhan.edit', compact('unduhan'));
    }

    public function update(UnduhanRequest $request, Unduhan $unduhan): RedirectResponse
    {
        $data = [
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'file_url' => $request->file_url,
            'file_size' => $request->file_size,
            'deskripsi' => $request->deskripsi,
            'urutan' => $request->urutan ?? 0,
            'is_active' => $request->has('is_active') ? true : false,
        ];

        if ($request->hasFile('file')) {
            if ($unduhan->file_path && Storage::disk('public')->exists($unduhan->file_path)) {
                Storage::disk('public')->delete($unduhan->file_path);
            }

            $uploadedFile = $request->file('file');
            $data['file_path'] = $uploadedFile->store('unduhan', 'public');

            if (empty($data['file_size'])) {
                $data['file_size'] = $this->formatBytes($uploadedFile->getSize());
            }
        }

        $unduhan->update($data);

        alert()->success('Berhasil!', 'Item E-Dokumen berhasil diperbarui.');

        return redirect()->route('unduhan.index');
    }

    public function destroy(Unduhan $unduhan): RedirectResponse
    {
        if ($unduhan->file_path && Storage::disk('public')->exists($unduhan->file_path)) {
            Storage::disk('public')->delete($unduhan->file_path);
        }

        $unduhan->delete();

        alert()->success('Berhasil!', 'Item E-Dokumen berhasil dihapus.');

        return redirect()->route('unduhan.index');
    }

    /**
     * Helper format ukuran byte
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision).' '.$units[$pow];
    }
}
