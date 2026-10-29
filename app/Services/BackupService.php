<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use ZipArchive;

class BackupService
{
    /**
     * Nama folder target backup sesuai permintaan user
     */
    protected const FOLDER_NAME = 'website teknik informatika';

    /**
     * Dapatkan path direktori backup (Drive D: diprioritaskan)
     */
    public function getBackupDirectory(): string
    {
        // Cek ketersediaan Drive D: pada sistem Windows
        if (is_dir('D:\\') || is_dir('D:/')) {
            $path = 'D:\\' . self::FOLDER_NAME;
        } else {
            // Fallback aman jika sistem tidak memiliki Drive D:
            $path = storage_path('app/backups/' . self::FOLDER_NAME);
        }

        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    /**
     * Dapatkan informasi drive dan folder penyimpanan
     */
    public function getTargetInfo(): array
    {
        $dir = $this->getBackupDirectory();
        $isDriveD = Str::startsWith(strtoupper($dir), 'D:');

        $freeBytes = @disk_free_space($dir) ?: 0;
        $totalBytes = @disk_total_space($dir) ?: 0;

        $files = $this->getBackupList();
        $totalBackupBytes = array_sum(array_column($files, 'raw_size'));

        return [
            'directory' => $dir,
            'is_drive_d' => $isDriveD,
            'free_space' => $this->formatBytes($freeBytes),
            'total_space' => $this->formatBytes($totalBytes),
            'free_bytes' => $freeBytes,
            'total_bytes' => $totalBytes,
            'used_percent' => $totalBytes > 0 ? round((($totalBytes - $freeBytes) / $totalBytes) * 100, 1) : 0,
            'total_files' => count($files),
            'total_backup_size' => $this->formatBytes($totalBackupBytes),
        ];
    }

    /**
     * Backup Database ke file SQL dengan format penamaan: date_namafile
     * Contoh: 2026-10-29_194512_database.sql
     */
    public function backupDatabase(?string $customName = null): array
    {
        $dir = $this->getBackupDirectory();
        $prefix = now('Asia/Jakarta')->format('Y-m-d_His');
        $label = $customName ? Str::slug($customName) : 'database';
        $filename = "{$prefix}_{$label}.sql";
        $targetFile = $dir . DIRECTORY_SEPARATOR . $filename;

        try {
            $dumpSuccess = false;

            // 1. Coba gunakan mysqldump via binary jika tersedia
            $mysqldumpPath = $this->findMysqldumpBinary();
            if ($mysqldumpPath) {
                $dumpSuccess = $this->exportDatabaseWithMysqldump($mysqldumpPath, $targetFile);
            }

            // 2. Jika mysqldump tidak tersedia atau gagal, gunakan native PDO exporter (100% fail-safe)
            if (!$dumpSuccess || !File::exists($targetFile) || filesize($targetFile) === 0) {
                $this->exportDatabaseWithPdo($targetFile);
            }

            if (!File::exists($targetFile) || filesize($targetFile) === 0) {
                throw new Exception("Gagal menghasilkan file backup database SQL.");
            }

            $size = filesize($targetFile);

            Log::info("Backup database berhasil dibuat: {$filename} ({$this->formatBytes($size)})");

            return [
                'success' => true,
                'type' => 'database',
                'filename' => $filename,
                'path' => $targetFile,
                'size' => $this->formatBytes($size),
                'raw_size' => $size,
                'message' => "Backup database SQL berhasil disimpan di {$dir}",
            ];
        } catch (Exception $e) {
            Log::error("Backup database gagal: " . $e->getMessage());
            if (File::exists($targetFile)) {
                @unlink($targetFile);
            }

            return [
                'success' => false,
                'type' => 'database',
                'filename' => $filename,
                'message' => "Gagal backup database: " . $e->getMessage(),
            ];
        }
    }

    /**
     * Backup Storage (Folder Uploads/Public Storage) ke file ZIP dengan format penamaan: date_namafile
     * Contoh: 2026-10-29_194512_storage.zip
     */
    public function backupStorage(?string $customName = null): array
    {
        $dir = $this->getBackupDirectory();
        $prefix = now('Asia/Jakarta')->format('Y-m-d_His');
        $label = $customName ? Str::slug($customName) : 'storage';
        $filename = "{$prefix}_{$label}.zip";
        $targetFile = $dir . DIRECTORY_SEPARATOR . $filename;

        try {
            if (!class_exists('ZipArchive')) {
                throw new Exception("Ekstensi PHP ZipArchive tidak aktif.");
            }

            $sourcePath = storage_path('app/public');
            if (!File::exists($sourcePath)) {
                throw new Exception("Direktori storage/app/public tidak ditemukan.");
            }

            $zip = new ZipArchive();
            if ($zip->open($targetFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                throw new Exception("Tidak dapat membuat file ZIP di: {$targetFile}");
            }

            // Rekursif tambahkan semua file dari storage/app/public
            $files = File::allFiles($sourcePath);
            foreach ($files as $file) {
                $relativePath = 'storage/' . $file->getRelativePathname();
                $zip->addFile($file->getRealPath(), $relativePath);
            }

            // Tambahkan juga file uploads lain jika ada di public/uploads
            $publicUploads = public_path('uploads');
            if (File::exists($publicUploads)) {
                $uploadFiles = File::allFiles($publicUploads);
                foreach ($uploadFiles as $file) {
                    $relativePath = 'uploads/' . $file->getRelativePathname();
                    $zip->addFile($file->getRealPath(), $relativePath);
                }
            }

            // Simpan manifest info backup
            $manifest = json_encode([
                'app_name' => config('app.name', 'Teknik Informatika UIS'),
                'backup_type' => 'storage',
                'created_at' => date('Y-m-d H:i:s'),
                'total_files' => count($files),
            ], JSON_PRETTY_PRINT);
            $zip->addFromString('backup-manifest.json', $manifest);

            $zip->close();

            if (!File::exists($targetFile) || filesize($targetFile) === 0) {
                throw new Exception("Gagal menghasilkan file backup storage ZIP.");
            }

            $size = filesize($targetFile);
            Log::info("Backup storage berhasil dibuat: {$filename} ({$this->formatBytes($size)})");

            return [
                'success' => true,
                'type' => 'storage',
                'filename' => $filename,
                'path' => $targetFile,
                'size' => $this->formatBytes($size),
                'raw_size' => $size,
                'message' => "Backup storage ZIP berhasil disimpan di {$dir}",
            ];
        } catch (Exception $e) {
            Log::error("Backup storage gagal: " . $e->getMessage());
            if (File::exists($targetFile)) {
                @unlink($targetFile);
            }

            return [
                'success' => false,
                'type' => 'storage',
                'filename' => $filename,
                'message' => "Gagal backup storage: " . $e->getMessage(),
            ];
        }
    }

    /**
     * Backup Database dan Storage sekaligus
     */
    public function backupAll(?string $customName = null): array
    {
        $dbResult = $this->backupDatabase($customName);
        $storageResult = $this->backupStorage($customName);

        $success = $dbResult['success'] && $storageResult['success'];

        return [
            'success' => $success,
            'database' => $dbResult,
            'storage' => $storageResult,
            'message' => $success 
                ? "Backup database dan storage berhasil disimpan di drive target!"
                : "Salah satu proses backup mengalami kendala. Periksa log.",
        ];
    }

    /**
     * Dapatkan daftar file backup yang ada di direktori target
     */
    public function getBackupList(): array
    {
        $dir = $this->getBackupDirectory();
        if (!File::exists($dir)) {
            return [];
        }

        $files = File::files($dir);
        $list = [];

        foreach ($files as $file) {
            $ext = strtolower($file->getExtension());
            if (!in_array($ext, ['sql', 'zip'])) {
                continue;
            }

            $filename = $file->getFilename();
            $type = $ext === 'sql' ? 'database' : 'storage';
            $size = $file->getSize();
            $mtime = $file->getMTime();

            $carbonTime = \Carbon\Carbon::createFromTimestamp($mtime)->timezone('Asia/Jakarta');
            $list[] = [
                'filename' => $filename,
                'type' => $type,
                'extension' => $ext,
                'path' => $file->getRealPath(),
                'size' => $this->formatBytes($size),
                'raw_size' => $size,
                'mtime' => $mtime,
                'created_at' => $carbonTime->translatedFormat('d M Y, H:i:s') . ' WIB',
                'created_at_human' => $carbonTime->locale('id')->diffForHumans(),
            ];
        }

        // Urutkan dari yang terbaru (mtime desc)
        usort($list, function ($a, $b) {
            return $b['mtime'] <=> $a['mtime'];
        });

        return $list;
    }

    /**
     * Hapus file backup tertentu
     */
    public function deleteBackup(string $filename): bool
    {
        $cleanFilename = basename($filename);
        $dir = $this->getBackupDirectory();
        $filePath = $dir . DIRECTORY_SEPARATOR . $cleanFilename;

        if (File::exists($filePath) && in_array(strtolower(pathinfo($filePath, PATHINFO_EXTENSION)), ['sql', 'zip'])) {
            return @unlink($filePath);
        }

        return false;
    }

    /**
     * Dapatkan path aman untuk download
     */
    public function getDownloadPath(string $filename): ?string
    {
        $cleanFilename = basename($filename);
        $dir = $this->getBackupDirectory();
        $filePath = $dir . DIRECTORY_SEPARATOR . $cleanFilename;

        if (File::exists($filePath) && in_array(strtolower(pathinfo($filePath, PATHINFO_EXTENSION)), ['sql', 'zip'])) {
            return $filePath;
        }

        return null;
    }

    /**
     * Cari lokasi binary mysqldump pada sistem
     */
    protected function findMysqldumpBinary(): ?string
    {
        $candidates = [
            'mysqldump',
            'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump.exe',
            'C:\\laragon\\bin\\mysql\\mysql-8.0.28-winx64\\bin\\mysqldump.exe',
            'C:\\laragon\\bin\\mysql\\current\\bin\\mysqldump.exe',
            'C:\\xampp\\mysql\\bin\\mysqldump.exe',
            '/usr/bin/mysqldump',
            '/usr/local/bin/mysqldump',
        ];

        // Cari di folder mysql laragon secara dinamis
        $laragonMysqlBase = 'C:\\laragon\\bin\\mysql';
        if (File::exists($laragonMysqlBase)) {
            $dirs = File::directories($laragonMysqlBase);
            foreach ($dirs as $dir) {
                $possible = $dir . '\\bin\\mysqldump.exe';
                if (File::exists($possible)) {
                    array_unshift($candidates, $possible);
                }
            }
        }

        foreach ($candidates as $bin) {
            if ($bin === 'mysqldump') {
                $check = @shell_exec('where.exe mysqldump 2>NUL');
                if ($check && trim($check) !== '') {
                    return 'mysqldump';
                }
            } elseif (File::exists($bin)) {
                return $bin;
            }
        }

        return null;
    }

    /**
     * Ekspor database dengan mysqldump
     */
    protected function exportDatabaseWithMysqldump(string $binary, string $targetFile): bool
    {
        $connection = config('database.default', 'mysql');
        $host = config("database.connections.{$connection}.host", '127.0.0.1');
        $port = config("database.connections.{$connection}.port", '3306');
        $database = config("database.connections.{$connection}.database");
        $username = config("database.connections.{$connection}.username", 'root');
        $password = config("database.connections.{$connection}.password", '');

        $passwordArg = $password !== '' && $password !== null ? '--password=' . escapeshellarg($password) : '';

        $cmd = sprintf(
            '"%s" --user=%s %s --host=%s --port=%s --single-transaction --quick --routines --triggers %s > "%s"',
            $binary,
            escapeshellarg($username),
            $passwordArg,
            escapeshellarg($host),
            escapeshellarg((string) $port),
            escapeshellarg($database),
            $targetFile
        );

        $process = Process::fromShellCommandline($cmd);
        $process->setTimeout(300);
        $process->run();

        return $process->isSuccessful() && File::exists($targetFile) && filesize($targetFile) > 0;
    }

    /**
     * Ekspor database dengan PDO (Native PHP Fallback)
     */
    protected function exportDatabaseWithPdo(string $targetFile): void
    {
        $pdo = DB::connection()->getPdo();
        $handle = fopen($targetFile, 'w');
        if (! $handle) {
            throw new Exception("Tidak dapat membuka file target untuk penulisan: {$targetFile}");
        }

        $dbName = config('database.connections.' . config('database.default') . '.database');

        fwrite($handle, "-- ═══════════════════════════════════════════════════════════\n");
        fwrite($handle, "-- BACKUP DATABASE SISTEM TEKNIK INFORMATIKA (UIS)\n");
        fwrite($handle, "-- Tanggal Ekspor : " . date('Y-m-d H:i:s') . "\n");
        fwrite($handle, "-- Database Target: {$dbName}\n");
        fwrite($handle, "-- Driver         : MySQL via Native PDO Engine\n");
        fwrite($handle, "-- ═══════════════════════════════════════════════════════════\n\n");
        fwrite($handle, "SET FOREIGN_KEY_CHECKS=0;\n");
        fwrite($handle, "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n");
        fwrite($handle, "START TRANSACTION;\n");
        fwrite($handle, "SET time_zone = \"+07:00\";\n\n");

        $tables = [];
        $stmt = $pdo->query("SHOW FULL TABLES WHERE Table_Type = 'BASE TABLE'");
        while ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $tables[] = $row[0];
        }

        foreach ($tables as $table) {
            fwrite($handle, "\n-- --------------------------------------------------------\n");
            fwrite($handle, "-- Struktur tabel untuk `{$table}`\n");
            fwrite($handle, "-- --------------------------------------------------------\n");
            fwrite($handle, "DROP TABLE IF EXISTS `{$table}`;\n");

            $createStmt = $pdo->query("SHOW CREATE TABLE `{$table}`");
            $createRow = $createStmt->fetch(\PDO::FETCH_NUM);
            fwrite($handle, $createRow[1] . ";\n\n");

            fwrite($handle, "-- Dumping data untuk tabel `{$table}`\n");
            $rowsStmt = $pdo->query("SELECT * FROM `{$table}`");

            $batch = [];
            while ($row = $rowsStmt->fetch(\PDO::FETCH_NUM)) {
                $escaped = array_map(function ($val) use ($pdo) {
                    if ($val === null) {
                        return 'NULL';
                    }
                    return $pdo->quote($val);
                }, $row);
                $batch[] = "(" . implode(", ", $escaped) . ")";

                if (count($batch) >= 200) {
                    fwrite($handle, "INSERT INTO `{$table}` VALUES \n" . implode(",\n", $batch) . ";\n");
                    $batch = [];
                }
            }
            if (!empty($batch)) {
                fwrite($handle, "INSERT INTO `{$table}` VALUES \n" . implode(",\n", $batch) . ";\n");
            }
        }

        fwrite($handle, "\nSET FOREIGN_KEY_CHECKS=1;\n");
        fwrite($handle, "COMMIT;\n");
        fclose($handle);
    }

    /**
     * Format byte ke satuan yang mudah dibaca
     */
    public function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
