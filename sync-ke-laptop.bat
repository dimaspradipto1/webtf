@echo off
REM ═══════════════════════════════════════════════════════════════════════
REM   SKRIP AUTO-SYNC BACKUP DARI CPANEL KE LAPTOP / KOMPUTER ADMIN
REM   - Otomatis Cek Drive: Jika ada Drive D: -> Simpan di D:\website teknik informatika
REM   - Jika laptop TIDAK ADA Drive D: -> Otomatis Simpan di C:\website teknik informatika
REM   - Tanpa Google Drive / Tanpa Software Tambahan (Direct Transfer)
REM ═══════════════════════════════════════════════════════════════════════
chcp 65001 >nul
title Sinkronisasi Backup Web Teknik Informatika ke Laptop

echo.
echo =======================================================================
echo   SINKRONISASI BACKUP WEB TEKNIK INFORMATIKA (UIS) KE LAPTOP
echo =======================================================================
echo.

REM 1. Tentukan URL Website & Token Rahasia (Ganti domain saat sudah online di cPanel)
set "WEBSITE_URL=http://localhost:8000"
set "SYNC_TOKEN=f047569ec724c4860549ccb9"

REM 2. Deteksi Drive Harddisk Laptop (Prioritas Drive D:, jika tidak ada pindah ke Drive C:)
if exist "D:\" (
    set "TARGET_DIR=D:\website teknik informatika"
    echo [INFO] Terdeteksi Drive D: pada laptop.
    echo        Target direktori: %TARGET_DIR%
) else (
    set "TARGET_DIR=C:\website teknik informatika"
    echo [INFO] Laptop tidak memiliki Drive D:, otomatis dialihkan ke Drive C:.
    echo        Target direktori: %TARGET_DIR%
)

REM 3. Buat folder baru jika belum ada
if not exist "%TARGET_DIR%" (
    mkdir "%TARGET_DIR%"
    echo [OK] Folder baru berhasil dibuat di: %TARGET_DIR%
)

REM 4. Dapatkan format tanggal YYYY-MM-DD_HHmmss standar
for /f "tokens=*" %%a in ('powershell -NoProfile -Command "Get-Date -Format yyyy-MM-dd_HHmmss"') do set "TIMESTAMP=%%a"
if "%TIMESTAMP%"=="" set "TIMESTAMP=%date:~6,4%-%date:~3,2%-%date:~0,2%_%time:~0,2%%time:~3,2%%time:~6,2%"

echo.
echo [1/2] Mengunduh Backup Database SQL dari server...
curl.exe -f -k -s -S "%WEBSITE_URL%/api/backup-sync/download?token=%SYNC_TOKEN%&type=database" -o "%TARGET_DIR%\temp_db.sql"
if %ERRORLEVEL% equ 0 (
    move /y "%TARGET_DIR%\temp_db.sql" "%TARGET_DIR%\%TIMESTAMP%_database.sql" >nul 2>&1
    if exist "%TARGET_DIR%\temp_db.sql" move /y "%TARGET_DIR%\temp_db.sql" "%TARGET_DIR%\database_latest.sql" >nul 2>&1
    echo [BERHASIL] File Database SQL berhasil disimpan: %TIMESTAMP%_database.sql
) else (
    echo [GAGAL] Gagal mengunduh database. Pastikan server online dan token valid.
)

echo.
echo [2/2] Mengunduh Backup Storage Uploads (ZIP) dari server...
curl.exe -f -k -s -S "%WEBSITE_URL%/api/backup-sync/download?token=%SYNC_TOKEN%&type=storage" -o "%TARGET_DIR%\temp_storage.zip"
if %ERRORLEVEL% equ 0 (
    move /y "%TARGET_DIR%\temp_storage.zip" "%TARGET_DIR%\%TIMESTAMP%_storage.zip" >nul 2>&1
    if exist "%TARGET_DIR%\temp_storage.zip" move /y "%TARGET_DIR%\temp_storage.zip" "%TARGET_DIR%\storage_latest.zip" >nul 2>&1
    echo [BERHASIL] File Storage ZIP berhasil disimpan: %TIMESTAMP%_storage.zip
) else (
    echo [GAGAL] Gagal mengunduh storage ZIP. Pastikan server online dan token valid.
)

echo.
echo =======================================================================
echo   SINKRONISASI SELESAI!
echo   Semua file backup telah berhasil diamankan di: %TARGET_DIR%
echo =======================================================================
echo.
pause
