<?php

namespace App\Http\Controllers;

use App\Services\BackupService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BackupController extends Controller
{
    protected BackupService $backupService;

    public function __construct(BackupService $backupService)
    {
        $this->backupService = $backupService;
    }

    /**
     * Tampilkan halaman manajemen backup database & storage
     */
    public function index()
    {
        $targetInfo = $this->backupService->getTargetInfo();
        $backups = $this->backupService->getBackupList();

        // Cek log aktivitas backup otomatis jika ada
        $logPath = storage_path('logs/backup-daily.log');
        $recentLog = null;
        if (File::exists($logPath)) {
            $lines = file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            if (!empty($lines)) {
                $recentLog = implode("\n", array_slice($lines, -15));
            }
        }

        return view('pages.backup.index', compact('targetInfo', 'backups', 'recentLog'));
    }

    /**
     * Jalankan backup database secara manual
     */
    public function backupDatabase(Request $request): RedirectResponse
    {
        $customName = $request->input('name') ? trim($request->input('name')) : null;
        $result = $this->backupService->backupDatabase($customName);

        if ($result['success']) {
            return redirect()->route('backup.index')->with('success', "Database berhasil di-backup: {$result['filename']} ({$result['size']}) dan disimpan di {$result['path']}");
        }

        return redirect()->route('backup.index')->with('error', $result['message']);
    }

    /**
     * Jalankan backup storage (file uploads) secara manual
     */
    public function backupStorage(Request $request): RedirectResponse
    {
        $customName = $request->input('name') ? trim($request->input('name')) : null;
        $result = $this->backupService->backupStorage($customName);

        if ($result['success']) {
            return redirect()->route('backup.index')->with('success', "Storage berhasil di-backup: {$result['filename']} ({$result['size']}) dan disimpan di {$result['path']}");
        }

        return redirect()->route('backup.index')->with('error', $result['message']);
    }

    /**
     * Jalankan backup database & storage sekaligus
     */
    public function backupAll(Request $request): RedirectResponse
    {
        $customName = $request->input('name') ? trim($request->input('name')) : null;
        $result = $this->backupService->backupAll($customName);

        if ($result['success']) {
            $dbFile = $result['database']['filename'];
            $storageFile = $result['storage']['filename'];
            return redirect()->route('backup.index')->with('success', "Backup lengkap berhasil! File database ({$dbFile}) dan storage ({$storageFile}) telah disimpan di Drive D:.");
        }

        return redirect()->route('backup.index')->with('error', $result['message']);
    }

    /**
     * Download file backup langsung dari browser
     */
    public function download(string $filename): BinaryFileResponse|RedirectResponse
    {
        $filePath = $this->backupService->getDownloadPath($filename);

        if (!$filePath || !File::exists($filePath)) {
            return redirect()->route('backup.index')->with('error', 'File backup tidak ditemukan atau tidak valid.');
        }

        return response()->download($filePath, $filename);
    }

    /**
     * Hapus file backup tertentu
     */
    public function destroy(string $filename): RedirectResponse
    {
        $deleted = $this->backupService->deleteBackup($filename);

        if ($deleted) {
            return redirect()->route('backup.index')->with('success', "File backup '{$filename}' berhasil dihapus.");
        }

        return redirect()->route('backup.index')->with('error', "Gagal menghapus file backup '{$filename}'.");
    }
}

