<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pimpinan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'slug',
        'jabatan',
        'foto',
        'tempat_tanggal_lahir',
        'email',
        'pendidikan',
        'pengalaman_organisasi',
        'pengalaman_kerja',
        'riwayat_jabatan',
        'baris',
        'urutan',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'baris' => 'integer',
            'urutan' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Pimpinan $pimpinan) {
            if (empty($pimpinan->slug)) {
                $baseSlug = Str::slug($pimpinan->nama) ?: 'pimpinan';
                $slug = $baseSlug;
                $counter = 1;
                while (static::where('slug', $slug)->where('id', '!=', $pimpinan->id ?? 0)->exists()) {
                    $slug = $baseSlug.'-'.$counter++;
                }
                $pimpinan->slug = $slug;
            }
        });
    }

    public static function parseLines(?string $text): array
    {
        if (empty($text)) {
            return [];
        }

        // Convert <li> tags to newlines if HTML is used
        $clean = preg_replace('/<\/li>/i', "\n", $text);
        $clean = strip_tags($clean);
        $lines = preg_split('/\r\n|\r|\n/', $clean);

        return array_values(array_filter(array_map(function ($line) {
            return trim(preg_replace('/^[\-\•\*]\s*/u', '', trim($line)));
        }, $lines), fn ($line) => $line !== ''));
    }

    public function getPendidikanListAttribute(): array
    {
        return self::parseLines($this->pendidikan);
    }

    public function getPengalamanOrganisasiListAttribute(): array
    {
        return self::parseLines($this->pengalaman_organisasi);
    }

    public function getPengalamanKerjaListAttribute(): array
    {
        return self::parseLines($this->pengalaman_kerja);
    }

    public function getRiwayatJabatanListAttribute(): array
    {
        return self::parseLines($this->riwayat_jabatan);
    }
}

