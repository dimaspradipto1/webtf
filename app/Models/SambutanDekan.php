<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SambutanDekan extends Model
{
    protected $table = 'sambutan_dekans';

    protected static bool $videoColumnsEnsured = false;

    protected $fillable = [
        'nama_dekan',
        'jabatan_dekan',
        'foto_dekan',
        'kutipan_singkat',
        'sambutan_dekan',
        'video_judul',
        'video_subjudul',
        'video_url',
        'video_aktif',
    ];

    protected $casts = [
        'video_aktif' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(fn () => static::ensureVideoColumns());
        static::saved(fn () => AppServiceProvider::recordContentUpdate());
    }

    /**
     * Self-healing: pastikan kolom video profil tersedia walau migrasi belum dijalankan di hosting.
     */
    public static function ensureVideoColumns(): void
    {
        if (static::$videoColumnsEnsured) {
            return;
        }
        static::$videoColumnsEnsured = true;

        try {
            if (!Schema::hasTable('sambutan_dekans')) {
                return;
            }

            if (
                !Schema::hasColumn('sambutan_dekans', 'video_judul')
                || !Schema::hasColumn('sambutan_dekans', 'video_subjudul')
                || !Schema::hasColumn('sambutan_dekans', 'video_url')
                || !Schema::hasColumn('sambutan_dekans', 'video_aktif')
            ) {
                Schema::table('sambutan_dekans', function (Blueprint $table) {
                    if (!Schema::hasColumn('sambutan_dekans', 'video_judul')) {
                        $table->string('video_judul', 200)->nullable()->after('sambutan_dekan');
                    }
                    if (!Schema::hasColumn('sambutan_dekans', 'video_subjudul')) {
                        $table->string('video_subjudul', 300)->nullable()->after('video_judul');
                    }
                    if (!Schema::hasColumn('sambutan_dekans', 'video_url')) {
                        $table->string('video_url', 500)->nullable()->after('video_subjudul');
                    }
                    if (!Schema::hasColumn('sambutan_dekans', 'video_aktif')) {
                        $table->boolean('video_aktif')->default(true)->after('video_url');
                    }
                });
            }
        } catch (\Throwable $e) {
            // Lanjutkan aman bila user DB hosting tidak memiliki izin DDL
        }
    }

    /**
     * Ekstrak YouTube Video ID dari berbagai format URL YouTube.
     */
    public function getYoutubeIdAttribute(): ?string
    {
        $url = trim((string) ($this->video_url ?? ''));
        if ($url === '') {
            return null;
        }

        $patterns = [
            '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/|youtube\.com\/shorts\/)([A-Za-z0-9_-]{11})/i',
            '/[?&]v=([A-Za-z0-9_-]{11})/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    /**
     * URL Embed YouTube yang aman untuk iframe.
     */
    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        $id = $this->youtube_id;

        return $id ? "https://www.youtube.com/embed/{$id}?rel=0" : null;
    }
}
