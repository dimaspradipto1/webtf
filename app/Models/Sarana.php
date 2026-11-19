<?php

namespace App\Models;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Sarana extends Model
{
    protected $table = 'saranas';

    protected static bool $columnsEnsured = false;

    protected $fillable = [
        'icon',
        'nama',
        'slug',
        'deskripsi',
        'foto',
        'foto_galeri',
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
        'foto_galeri' => 'array',
    ];

    protected static function booted(): void
    {
        static::saving(function (Sarana $sarana) {
            static::ensureColumns();

            if (Schema::hasColumn('saranas', 'slug') && (empty($sarana->slug) || $sarana->isDirty('nama'))) {
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
     * Self-healing: pastikan kolom detail laboratorium tersedia walau migrasi belum dijalankan di hosting.
     */
    public static function ensureColumns(): void
    {
        if (static::$columnsEnsured) {
            return;
        }
        static::$columnsEnsured = true;

        try {
            if (!Schema::hasTable('saranas')) {
                return;
            }

            $missing = !Schema::hasColumn('saranas', 'slug')
                || !Schema::hasColumn('saranas', 'foto')
                || !Schema::hasColumn('saranas', 'foto_galeri')
                || !Schema::hasColumn('saranas', 'kepala_lab')
                || !Schema::hasColumn('saranas', 'lokasi')
                || !Schema::hasColumn('saranas', 'kapasitas')
                || !Schema::hasColumn('saranas', 'daftar_perangkat')
                || !Schema::hasColumn('saranas', 'mata_kuliah_praktikum')
                || !Schema::hasColumn('saranas', 'jadwal_pemakaian');

            if ($missing) {
                Schema::table('saranas', function (Blueprint $table) {
                    if (!Schema::hasColumn('saranas', 'slug')) {
                        $table->string('slug', 220)->nullable()->unique()->after('nama');
                    }
                    if (!Schema::hasColumn('saranas', 'foto')) {
                        $table->string('foto', 255)->nullable()->after('deskripsi');
                    }
                    if (!Schema::hasColumn('saranas', 'foto_galeri')) {
                        $table->json('foto_galeri')->nullable()->after('foto');
                    }
                    if (!Schema::hasColumn('saranas', 'kepala_lab')) {
                        $table->string('kepala_lab', 200)->nullable()->after('foto');
                    }
                    if (!Schema::hasColumn('saranas', 'lokasi')) {
                        $table->string('lokasi', 200)->nullable()->after('kepala_lab');
                    }
                    if (!Schema::hasColumn('saranas', 'kapasitas')) {
                        $table->string('kapasitas', 100)->nullable()->after('lokasi');
                    }
                    if (!Schema::hasColumn('saranas', 'daftar_perangkat')) {
                        $table->text('daftar_perangkat')->nullable()->after('kapasitas');
                    }
                    if (!Schema::hasColumn('saranas', 'mata_kuliah_praktikum')) {
                        $table->text('mata_kuliah_praktikum')->nullable()->after('daftar_perangkat');
                    }
                    if (!Schema::hasColumn('saranas', 'jadwal_pemakaian')) {
                        $table->text('jadwal_pemakaian')->nullable()->after('mata_kuliah_praktikum');
                    }
                });

                if (Schema::hasColumn('saranas', 'slug')) {
                    $existing = DB::table('saranas')->whereNull('slug')->orWhere('slug', '')->select('id', 'nama')->get();
                    foreach ($existing as $row) {
                        $base = Str::slug($row->nama ?: 'fasilitas') ?: 'fasilitas';
                        $slug = $base;
                        $counter = 2;
                        while (DB::table('saranas')->where('slug', $slug)->where('id', '!=', $row->id)->exists()) {
                            $slug = $base . '-' . $counter;
                            $counter++;
                        }
                        DB::table('saranas')->where('id', $row->id)->update(['slug' => $slug]);
                    }
                }
            }
        } catch (\Throwable $e) {
            // Lanjutkan dengan fallback aman bila user DB hosting tidak memiliki izin DDL
        }
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
     * Daftar seluruh path foto ruangan (foto utama + foto galeri).
     */
    public function getAllFotoPathsAttribute(): array
    {
        $paths = [];
        if (!empty($this->foto)) {
            $paths[] = $this->foto;
        }
        if (is_array($this->foto_galeri)) {
            foreach ($this->foto_galeri as $p) {
                if (is_string($p) && trim($p) !== '' && !in_array($p, $paths, true)) {
                    $paths[] = $p;
                }
            }
        }

        return $paths;
    }

    /**
     * Daftar seluruh URL foto ruangan untuk ditampilkan di frontend.
     */
    public function getAllFotoUrlsAttribute(): array
    {
        return array_values(array_filter(array_map(function (string $path) {
            if (Str::startsWith($path, ['http://', 'https://'])) {
                return $path;
            }
            if (Storage::disk('public')->exists($path) || file_exists(public_path('storage/' . $path))) {
                return asset('storage/' . $path);
            }
            if (file_exists(public_path($path))) {
                return asset($path);
            }

            return asset('storage/' . $path);
        }, $this->all_foto_paths)));
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
