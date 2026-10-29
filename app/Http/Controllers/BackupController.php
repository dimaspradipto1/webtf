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

    /**
     * Dapatkan token rahasia untuk sinkronisasi cPanel -> Laptop
     */
    public function getSyncToken(): string
    {
        $token = env('BACKUP_SYNC_TOKEN');
        if (empty($token)) {
            $token = substr(hash('sha256', (string) config('app.key')), 0, 24);
        }

        return $token;
    }

    /**
     * Endpoint API Sinkronisasi Otomatis dari Laptop (Tanpa GDrive)
     * Menggunakan Token Rahasia untuk mengunduh backup terbaru ke laptop (Drive D:\ atau C:\)
     */
    public function syncDownload(Request $request)
    {
        $token = $request->query('token');
        $expectedToken = $this->getSyncToken();

        if (!$token || !hash_equals((string) $expectedToken, (string) $token)) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak: Token autentikasi sinkronisasi tidak valid.',
            ], 403);
        }

        $type = strtolower($request->query('type', 'database')); // 'database' atau 'storage'

        // Cari backup terbaru sesuai tipe
        $latest = $this->backupService->getLatestBackup($type);

        // Jika belum ada file backup, generate otomatis sekarang
        if (!$latest) {
            if ($type === 'storage') {
                $this->backupService->backupStorage();
            } else {
                $this->backupService->backupDatabase();
            }
            $latest = $this->backupService->getLatestBackup($type);
        }

        if (!$latest || !File::exists($latest['path'])) {
            return response()->json([
                'success' => false,
                'message' => "File backup tipe {$type} tidak ditemukan di server.",
            ], 404);
        }

        return response()->download($latest['path'], $latest['filename']);
    }

    /**
     * Download skrip otomatis Windows (.bat) untuk ditaruh di laptop
     */
    public function downloadSyncScript()
    {
        $token = $this->getSyncToken();
        $domain = url('/');

        $batContent = "@echo off\r\n"
            . "REM ===================================================================\r\n"
            . "REM   SKRIP AUTO-SYNC BACKUP DARI CPANEL KE LAPTOP (WINDOWS)\r\n"
            . "REM   Mendukung: Drive D:\\ (Utama) dan Drive C:\\ (Otomatis jika D: tidak ada)\r\n"
            . "REM   Tanpa Google Drive / Tanpa Software Tambahan\r\n"
            . "REM ===================================================================\r\n"
            . "chcp 65001 >nul\r\n"
            . "title Sinkronisasi Backup Web Teknik Informatika ke Laptop\r\n"
            . "echo.\r\n"
            . "echo ================================================================\r\n"
            . "echo   MEMULAI SINKRONISASI BACKUP DARI CPANEL KE LAPTOP\r\n"
            . "echo   Domain: {$domain}\r\n"
            . "echo ================================================================\r\n"
            . "echo.\r\n"
            . "REM 1. Deteksi Drive Target (Prioritas D:\\, fallback ke C:\\ jika tidak ada D:\\)\r\n"
            . "if exist \"D:\\\" (\r\n"
            . "    set \"TARGET_DIR=D:\\website teknik informatika\"\r\n"
            . "    echo [OK] Terdeteksi Drive D:. Lokasi penyimpanan: %TARGET_DIR%\r\n"
            . ") else (\r\n"
            . "    set \"TARGET_DIR=C:\\website teknik informatika\"\r\n"
            . "    echo [INFO] Drive D: tidak ditemukan di laptop ini. Dialihkan ke: %TARGET_DIR%\r\n"
            . ")\r\n"
            . "\r\n"
            . "REM 2. Buat folder jika belum ada\r\n"
            . "if not exist \"%TARGET_DIR%\" (\r\n"
            . "    mkdir \"%TARGET_DIR%\"\r\n"
            . "    echo [OK] Folder baru berhasil dibuat di %TARGET_DIR%\r\n"
            . ")\r\n"
            . "\r\n"
            . "REM 3. Dapatkan format tanggal YYYY-MM-DD_HHmmss standar\r\n"
            . "for /f \"tokens=*\" %%a in ('powershell -NoProfile -Command \"Get-Date -Format yyyy-MM-dd_HHmmss\"') do set \"TIMESTAMP=%%a\"\r\n"
            . "if \"%TIMESTAMP%\"==\"\" set \"TIMESTAMP=%date:~6,4%-%date:~3,2%-%date:~0,2%_%time:~0,2%%time:~3,2%%time:~6,2%\"\r\n"
            . "\r\n"
            . "echo.\r\n"
            . "echo [1/2] Mengunduh Backup Database SQL dari server cPanel...\r\n"
            . "curl.exe -f -k -s -S \"{$domain}/api/backup-sync/download?token={$token}&type=database\" -o \"%TARGET_DIR%\\temp_db.sql\"\r\n"
            . "if %ERRORLEVEL% equ 0 (\r\n"
            . "    move /y \"%TARGET_DIR%\\temp_db.sql\" \"%TARGET_DIR%\\%TIMESTAMP%_database.sql\" >nul 2>&1\r\n"
            . "    if exist \"%TARGET_DIR%\\temp_db.sql\" move /y \"%TARGET_DIR%\\temp_db.sql\" \"%TARGET_DIR%\\database_latest.sql\" >nul 2>&1\r\n"
            . "    echo [BERHASIL] File Database berhasil disimpan: %TIMESTAMP%_database.sql\r\n"
            . ") else (\r\n"
            . "    echo [GAGAL] Gagal mengunduh database dari cPanel. Periksa koneksi internet.\r\n"
            . ")\r\n"
            . "\r\n"
            . "echo.\r\n"
            . "echo [2/2] Mengunduh Backup Storage Media (ZIP) dari server cPanel...\r\n"
            . "curl.exe -f -k -s -S \"{$domain}/api/backup-sync/download?token={$token}&type=storage\" -o \"%TARGET_DIR%\\temp_storage.zip\"\r\n"
            . "if %ERRORLEVEL% equ 0 (\r\n"
            . "    move /y \"%TARGET_DIR%\\temp_storage.zip\" \"%TARGET_DIR%\\%TIMESTAMP%_storage.zip\" >nul 2>&1\r\n"
            . "    if exist \"%TARGET_DIR%\\temp_storage.zip\" move /y \"%TARGET_DIR%\\temp_storage.zip\" \"%TARGET_DIR%\\storage_latest.zip\" >nul 2>&1\r\n"
            . "    echo [BERHASIL] File Storage berhasil disimpan: %TIMESTAMP%_storage.zip\r\n"
            . ") else (\r\n"
            . "    echo [GAGAL] Gagal mengunduh storage dari cPanel. Periksa koneksi internet.\r\n"
            . ")\r\n"
            . "\r\n"
            . "echo.\r\n"
            . "echo ================================================================\r\n"
            . "echo   SINKRONISASI SELESAI!\r\n"
            . "echo   Semua file telah diamankan ke: %TARGET_DIR%\r\n"
            . "echo ================================================================\r\n"
            . "pause\r\n";

        return response($batContent, 200, [
            'Content-Type' => 'application/x-bat',
            'Content-Disposition' => 'attachment; filename="sync-backup-ke-laptop.bat"',
        ]);
    }
}

