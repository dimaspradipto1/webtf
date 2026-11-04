<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Announcement extends Model
{
    protected $table = 'announcements';

    protected $fillable = [
        'title',
        'slug',
        'date',
        'content',
        'file_path',
        'link_url',
        'is_active',
        'urutan',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    protected static function booted()
    {
        static::saving(function ($announcement) {
            if (empty($announcement->date)) {
                $announcement->date = now()->toDateString();
            }

            if (empty($announcement->slug) || $announcement->isDirty('title')) {
                $baseSlug = Str::slug($announcement->title ?? '');
                if (empty($baseSlug)) {
                    $baseSlug = 'pengumuman-'.($announcement->id ?? time());
                }
                $slug = $baseSlug;
                $counter = 1;

                while (static::where('slug', $slug)->where('id', '!=', $announcement->id ?? 0)->exists()) {
                    $slug = "{$baseSlug}-{$counter}";
                    $counter++;
                }

                $announcement->slug = $slug;
            }
        });

        static::saved(function () {
            AppServiceProvider::recordContentUpdate();
        });

        static::deleted(function () {
            AppServiceProvider::recordContentUpdate();
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

