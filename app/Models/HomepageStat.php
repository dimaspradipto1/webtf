<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HomepageStat extends Model
{
    protected $table = 'homepage_stats';

    protected $fillable = [
        'nilai',
        'label',
        'ikon',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'urutan' => 'integer',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => AppServiceProvider::recordContentUpdate());
        static::deleted(fn () => AppServiceProvider::recordContentUpdate());
    }

    public static function ensureTable(): void
    {
        if (!Schema::hasTable('homepage_stats')) {
            Schema::create('homepage_stats', function (Blueprint $table) {
                $table->id();
                $table->string('nilai', 60);
                $table->string('label', 120);
                $table->string('ikon', 80)->nullable();
                $table->unsignedInteger('urutan')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }
}
