<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Dosen extends Model
{
    protected $table = 'dosens';

    protected static bool $columnsEnsured = false;

    protected $fillable = [
        'layanan_id',
        'prodi_nama',
        'nama_dosen',
        'jabatan_fungsional',
        'nidn',
        'nuptk',
        'bidang_keahlian',
        'link',
        'link_sinta',
        'link_scholar',
        'foto',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'urutan' => 'integer',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(fn () => static::ensureColumns());
    }

    public static function ensureColumns(): void
    {
        if (static::$columnsEnsured) {
            return;
        }
        static::$columnsEnsured = true;

        try {
            if (!Schema::hasTable('dosens')) {
                return;
            }

            if (
                !Schema::hasColumn('dosens', 'bidang_keahlian')
                || !Schema::hasColumn('dosens', 'link_sinta')
                || !Schema::hasColumn('dosens', 'link_scholar')
            ) {
                Schema::table('dosens', function (Blueprint $table) {
                    if (!Schema::hasColumn('dosens', 'bidang_keahlian')) {
                        $table->string('bidang_keahlian', 255)->nullable()->after('nuptk');
                    }
                    if (!Schema::hasColumn('dosens', 'link_sinta')) {
                        $table->string('link_sinta', 500)->nullable()->after('link');
                    }
                    if (!Schema::hasColumn('dosens', 'link_scholar')) {
                        $table->string('link_scholar', 500)->nullable()->after('link_sinta');
                    }
                });
            }
        } catch (\Throwable $e) {
            // Abaikan bila DB hosting tidak mengizinkan DDL
        }
    }

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }
}
