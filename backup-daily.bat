@echo off
REM ═══════════════════════════════════════════════════════════════
REM   SCRIPT BACKUP HARIAN OTOMATIS — WEB TEKNIK INFORMATIKA (UIS)
REM   Target Penyimpanan: D:\website teknik informatika
REM   Format Penamaan   : date_namafile (.sql & .zip)
REM ═══════════════════════════════════════════════════════════════

cd /d "%~dp0"

echo [===========================================================] >> storage\logs\backup-daily.log
echo [%date% %time%] Memulai eksekusi backup otomatis... >> storage\logs\backup-daily.log

php artisan system:backup --type=all >> storage\logs\backup-daily.log 2>&1

echo [%date% %time%] Eksekusi backup otomatis selesai. >> storage\logs\backup-daily.log
echo [===========================================================] >> storage\logs\backup-daily.log

