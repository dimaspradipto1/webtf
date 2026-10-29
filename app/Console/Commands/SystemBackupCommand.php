<?php

namespace App\Console\Commands;

use App\Services\BackupService;
use Illuminate\Console\Command;

class SystemBackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:backup 
                            {--type=all : Tipe backup: all, database, atau storage}
                            {--name= : Label opsional untuk nama file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Melakukan backup database dan storage website Teknik Informatika ke Drive D:';

    /**
     * Execute the console command.
     */
    public function handle(BackupService $backupService): int
    {
        $type = strtolower($this->option('type') ?: 'all');
        $name = $this->option('name');

        $this->info("═══════════════════════════════════════════════════════════");
        $this->info("  PROSES BACKUP OTOMATIS TEKNIK INFORMATIKA (UIS)");
        $this->info("  Waktu: " . now('Asia/Jakarta')->translatedFormat('d F Y, H:i:s') . " WIB");
        $this->info("═══════════════════════════════════════════════════════════");

        $targetDir = $backupService->getBackupDirectory();
        $this->line("Target Direktori : <comment>{$targetDir}</comment>");
        $this->line("Tipe Backup      : <comment>{$type}</comment>");
        $this->newLine();

        $success = true;

        if ($type === 'database' || $type === 'all') {
            $this->comment(">> Memulai backup database MySQL...");
            $res = $backupService->backupDatabase($name);
            if ($res['success']) {
                $this->info("   [OK] Database berhasil di-backup:");
                $this->line("        File : {$res['filename']}");
                $this->line("        Size : {$res['size']}");
            } else {
                $this->error("   [FAIL] " . $res['message']);
                $success = false;
            }
        }

        if ($type === 'storage' || $type === 'all') {
            $this->comment(">> Memulai backup storage (file uploads)...");
            $res = $backupService->backupStorage($name);
            if ($res['success']) {
                $this->info("   [OK] Storage berhasil di-backup:");
                $this->line("        File : {$res['filename']}");
                $this->line("        Size : {$res['size']}");
            } else {
                $this->error("   [FAIL] " . $res['message']);
                $success = false;
            }
        }

        $this->newLine();
        if ($success) {
            $this->info("✔ Seluruh proses backup berhasil diselesaikan dan disimpan di Drive D:!");
            return Command::SUCCESS;
        } else {
            $this->warn("⚠ Terjadi kegagalan pada sebagian atau seluruh proses backup.");
            return Command::FAILURE;
        }
    }
}

