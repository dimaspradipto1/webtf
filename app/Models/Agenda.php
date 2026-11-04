<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Agenda extends Model
{
    protected $table = 'agendas';

    protected $fillable = [
        'title',
        'slug',
        'date_text',
        'start_date',
        'end_date',
        'location',
        'description',
        'link_url',
        'is_active',
        'urutan',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    protected static function booted()
    {
        static::saving(function ($agenda) {
            if (empty($agenda->slug) || $agenda->isDirty('title')) {
                $baseSlug = Str::slug($agenda->title ?? '');
                if (empty($baseSlug)) {
                    $baseSlug = 'agenda-'.($agenda->id ?? time());
                }
                $slug = $baseSlug;
                $counter = 1;

                while (static::where('slug', $slug)->where('id', '!=', $agenda->id ?? 0)->exists()) {
                    $slug = "{$baseSlug}-{$counter}";
                    $counter++;
                }

                $agenda->slug = $slug;
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
