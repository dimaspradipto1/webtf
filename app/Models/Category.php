<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'color',
        'icon',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = static::generateUniqueSlug($category->name, $category->type ?? 'berita');
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = static::generateUniqueSlug($category->name, $category->type ?? 'berita', $category->id);
            }
        });
    }

    /**
     * Buat slug unik per tipe modul.
     */
    public static function generateUniqueSlug(string $name, string $type = 'berita', ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name) ?: 'kategori';
        $slug = $baseSlug;
        $counter = 1;

        while (static::where('type', $type)->where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    /**
     * Dapatkan daftar kategori aktif untuk modul tertentu.
     */
    public static function getOptions(string $type = 'berita')
    {
        static::ensureTableAndDefaults();

        $categories = static::where('type', $type)
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        if ($categories->isEmpty()) {
            return collect(static::defaultPresets($type))->map(function ($item, $index) use ($type) {
                return (object) [
                    'id' => null,
                    'name' => is_array($item) ? $item['name'] : $item,
                    'slug' => is_array($item) ? ($item['slug'] ?? Str::slug($item['name'])) : Str::slug($item),
                    'type' => $type,
                    'color' => is_array($item) ? ($item['color'] ?? null) : null,
                    'icon' => is_array($item) ? ($item['icon'] ?? null) : null,
                ];
            });
        }

        return $categories;
    }

    /**
     * Daftar preset bawaan per modul.
     */
    public static function defaultPresets(?string $type = null): array
    {
        $presets = [
            'berita' => [
                ['name' => 'Berita Universitas', 'slug' => 'berita-universitas', 'icon' => 'bi-mortarboard', 'color' => '#0d6efd'],
                ['name' => 'Berita Humas', 'slug' => 'berita-humas', 'icon' => 'bi-megaphone', 'color' => '#198754'],
                ['name' => 'Akademik & Kemahasiswaan', 'slug' => 'akademik-kemahasiswaan', 'icon' => 'bi-book', 'color' => '#0dcaf0'],
                ['name' => 'Teknologi & Rekayasa', 'slug' => 'teknologi-rekayasa', 'icon' => 'bi-cpu', 'color' => '#6610f2'],
                ['name' => 'Bisnis & Manajemen', 'slug' => 'bisnis-manajemen', 'icon' => 'bi-briefcase', 'color' => '#fd7e14'],
                ['name' => 'K3 & Lingkungan Industri', 'slug' => 'k3-lingkungan-industri', 'icon' => 'bi-shield-check', 'color' => '#ffc107'],
                ['name' => 'Penelitian & Riset', 'slug' => 'penelitian-riset', 'icon' => 'bi-lightbulb', 'color' => '#20c997'],
                ['name' => 'Pengabdian Masyarakat', 'slug' => 'pengabdian-masyarakat', 'icon' => 'bi-people', 'color' => '#d63384'],
                ['name' => 'Kerjasama Industri', 'slug' => 'kerjasama-industri', 'icon' => 'bi-handshake', 'color' => '#6f42c1'],
                ['name' => 'Pengumuman & Agenda', 'slug' => 'pengumuman-agenda', 'icon' => 'bi-calendar-event', 'color' => '#6c757d'],
            ],
            'unduhan' => [
                ['name' => 'Dokumen', 'slug' => 'dokumen', 'icon' => 'bi-file-earmark-text', 'color' => '#0d6efd'],
                ['name' => 'Panduan', 'slug' => 'panduan', 'icon' => 'bi-journal-bookmark', 'color' => '#198754'],
                ['name' => 'Pedoman', 'slug' => 'pedoman', 'icon' => 'bi-book', 'color' => '#dc3545'],
                ['name' => 'SOP', 'slug' => 'sop', 'icon' => 'bi-clipboard-check', 'color' => '#ffc107'],
                ['name' => 'Template', 'slug' => 'template', 'icon' => 'bi-file-earmark-spreadsheet', 'color' => '#0dcaf0'],
                ['name' => 'Lainnya', 'slug' => 'lainnya', 'icon' => 'bi-folder', 'color' => '#6c757d'],
            ],
            'galeri' => [
                ['name' => 'Universitas', 'slug' => 'universitas', 'icon' => 'bi-building', 'color' => '#0d6efd'],
                ['name' => 'Humas', 'slug' => 'humas', 'icon' => 'bi-camera', 'color' => '#198754'],
            ],
            'testimoni' => [
                ['name' => 'Alumni', 'slug' => 'alumni', 'icon' => 'bi-mortarboard', 'color' => '#0d6efd'],
                ['name' => 'Mahasiswa', 'slug' => 'mahasiswa', 'icon' => 'bi-person', 'color' => '#198754'],
                ['name' => 'Dosen / Pengajar', 'slug' => 'dosen-pengajar', 'icon' => 'bi-person-badge', 'color' => '#6610f2'],
                ['name' => 'Mitra Industri', 'slug' => 'mitra-industri', 'icon' => 'bi-building-check', 'color' => '#fd7e14'],
                ['name' => 'Orang Tua Mahasiswa', 'slug' => 'orang-tua-mahasiswa', 'icon' => 'bi-people', 'color' => '#d63384'],
            ],
        ];

        if ($type) {
            return $presets[$type] ?? [];
        }

        return $presets;
    }

    /**
     * Pastikan tabel dan data bawaan tersedia secara otomatis (self-healing untuk hosting cPanel).
     */
    public static function ensureTableAndDefaults(): void
    {
        try {
            if (!Schema::hasTable('categories')) {
                Schema::create('categories', function (Blueprint $table) {
                    $table->id();
                    $table->string('name');
                    $table->string('slug');
                    $table->string('type')->default('berita')->index();
                    $table->text('description')->nullable();
                    $table->string('color')->nullable();
                    $table->string('icon')->nullable();
                    $table->integer('order')->default(0);
                    $table->boolean('is_active')->default(true);
                    $table->timestamps();

                    $table->index(['type', 'slug']);
                });
            }

            // Seed defaults jika tabel kosong
            if (static::count() === 0) {
                foreach (static::defaultPresets() as $type => $items) {
                    $order = 1;
                    foreach ($items as $item) {
                        static::firstOrCreate(
                            ['type' => $type, 'slug' => $item['slug']],
                            [
                                'name' => $item['name'],
                                'icon' => $item['icon'] ?? null,
                                'color' => $item['color'] ?? null,
                                'order' => $order++,
                                'is_active' => true,
                            ]
                        );
                    }
                }
            }
        } catch (\Throwable $e) {
            // Lanjutkan jika ada kendala koneksi DDL
        }
    }

    /**
     * Hitung jumlah konten yang menggunakan kategori ini.
     */
    public function getItemsCountAttribute(): int
    {
        try {
            return match ($this->type) {
                'berita' => News::where('category', $this->name)->orWhere('category', $this->slug)->count(),
                'unduhan' => Unduhan::where('kategori', $this->name)->orWhere('kategori', $this->slug)->count(),
                'galeri' => Gallery::where('kategori', $this->name)->orWhere('kategori', $this->slug)->count(),
                'testimoni' => Testimonial::where('kategori', $this->name)->orWhere('kategori', $this->slug)->count(),
                default => 0,
            };
        } catch (\Throwable $e) {
            return 0;
        }
    }

    /**
     * Label representatif modul / tipe.
     */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'berita' => 'Berita & Informasi',
            'unduhan' => 'E-Dokumen / SOP',
            'galeri' => 'Galeri Dokumentasi',
            'testimoni' => 'Testimoni',
            'faq' => 'FAQ',
            default => ucfirst($this->type),
        };
    }

    /**
     * Warna badge untuk tipe modul.
     */
    public function getTypeBadgeColorAttribute(): string
    {
        return match ($this->type) {
            'berita' => 'primary',
            'unduhan' => 'info',
            'galeri' => 'success',
            'testimoni' => 'warning',
            'faq' => 'secondary',
            default => 'dark',
        };
    }
}
