<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Sarana extends Model
{
    protected $table = 'saranas';

    protected $fillable = [
        'icon',
        'nama',
        'slug',
        'deskripsi',
        'foto',
        'kepala_lab',
        'lokasi',
        'kapasitas',
        'daftar_perangkat',
        'mata_kuliah_praktikum',
        'jadwal_pemakaian',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (Sarana $sarana) {
            if (empty($sarana->slug) || $sarana->isDirty('nama')) {
                $base = Str::slug($sarana->nama ?: 'fasilitas') ?: 'fasilitas';
                $slug = $base;
                $counter = 2;
                while (
                    static::where('slug', $slug)
                        ->when($sarana->exists, fn ($q) => $q->where('id', '!=', $sarana->id))
                        ->exists()
                ) {
                    $slug = $base . '-' . $counter;
                    $counter++;
                }
                $sarana->slug = $slug;
            }
        });

        static::saved(fn () => AppServiceProvider::recordContentUpdate());
        static::deleted(fn () => AppServiceProvider::recordContentUpdate());
    }

    /**
     * Scope: hanya data aktif, urut tampil.
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true)->orderBy('urutan');
    }

    /**
     * URL foto ruangan jika tersedia.
     */
    public function getFotoUrlAttribute(): ?string
    {
        if (empty($this->foto)) {
            return null;
        }

        if (Str::startsWith($this->foto, ['http://', 'https://'])) {
            return $this->foto;
        }

        if (Storage::disk('public')->exists($this->foto) || file_exists(public_path('storage/' . $this->foto))) {
            return asset('storage/' . $this->foto);
        }

        if (file_exists(public_path($this->foto))) {
            return asset($this->foto);
        }

        return asset('storage/' . $this->foto);
    }

    /**
     * Pecah field multiline menjadi array baris bersih.
     */
    public function parseLines(?string $text): array
    {
        if (empty($text)) {
            return [];
        }

        return collect(preg_split('/\r\n|\r|\n/', $text))
            ->map(fn ($line) => trim(ltrim($line, "-•* \t")))
            ->filter(fn ($line) => $line !== '')
            ->values()
            ->all();
    }
}
