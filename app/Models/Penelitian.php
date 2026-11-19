<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Penelitian extends Model
{
    protected $table = 'penelitians';

    protected $fillable = [
        'jenis',
        'judul',
        'ketua',
        'anggota',
        'sumber_dana',
        'tahun',
        'bidang_riset',
        'link_publikasi',
        'is_active',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => AppServiceProvider::recordContentUpdate());
        static::deleted(fn () => AppServiceProvider::recordContentUpdate());
    }

    /**
     * Self-healing table check for cPanel/shared hosting deployments.
     */
    public static function ensureTable(): void
    {
        try {
            if (!Schema::hasTable('penelitians')) {
                Schema::create('penelitians', function (Blueprint $table) {
                    $table->id();
                    $table->string('jenis', 30)->default('penelitian');
                    $table->string('judul', 500);
                    $table->string('ketua');
                    $table->text('anggota')->nullable();
                    $table->string('sumber_dana')->nullable();
                    $table->unsignedSmallInteger('tahun')->default(date('Y'));
                    $table->string('bidang_riset')->nullable();
                    $table->string('link_publikasi', 500)->nullable();
                    $table->boolean('is_active')->default(true);
                    $table->timestamps();
                });
            }
        } catch (\Throwable $e) {
            // Ignore DDL restriction on shared hosting
        }
    }
}
