<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Scheduled Tasks (Backup Otomatis Harian)
|--------------------------------------------------------------------------
| Menjalankan backup database dan storage otomatis setiap hari pukul 01:00 WIB
| dan langsung disimpan ke Drive D:\website teknik informatika.
*/
Schedule::command('system:backup --type=all')
    ->dailyAt('01:00')
    ->timezone('Asia/Jakarta')
    ->name('daily-system-backup')
    ->withoutOverlapping()
    ->appendOutputTo(storage_path('logs/backup-daily.log'));
