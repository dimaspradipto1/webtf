<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Contact extends Model
{
    protected $table = 'contacts';

    protected $fillable = [
        'latitude',
        'longitude',
        'map',
        'no_wa',
        'email',
        'alamat',
        'jam_operasional',
    ];

    /**
     * Pastikan schema kolom jam_operasional tersedia (self-healing untuk hosting cPanel).
     */
    public static function ensureSchema(): void
    {
        try {
            if (Schema::hasTable('contacts') && !Schema::hasColumn('contacts', 'jam_operasional')) {
                Schema::table('contacts', function (Blueprint $table) {
                    if (!Schema::hasColumn('contacts', 'jam_operasional')) {
                        $table->string('jam_operasional')->nullable()->default('Senin – Sabtu: 08.00 – 17.00 WIB')->after('alamat');
                    }
                });
            }
        } catch (\Throwable $e) {
            // Ignore jika izin DDL terbatas pada lingkungan hosting tertentu
        }
    }

    /**
     * Dapatkan jam operasional dengan fallback aman.
     */
    public function getJamOperasionalAttribute($value): string
    {
        if (!empty($value)) {
            return $value;
        }

        $fallbackFile = storage_path('app/contact_settings.json');
        if (file_exists($fallbackFile)) {
            $json = json_decode(@file_get_contents($fallbackFile), true);
            if (!empty($json['jam_operasional'])) {
                return $json['jam_operasional'];
            }
        }

        return 'Senin – Sabtu: 08.00 – 17.00 WIB';
    }

    /**
     * Ekstrak koordinat latitude & longitude dari URL embed / tautan Google Maps.
     */
    public static function extractCoordinatesFromMap(?string $map): ?array
    {
        if (empty($map)) {
            return null;
        }

        // 1. Format embed Google Maps: !2d{lng}!3d{lat} atau !3d{lat}!2d{lng}
        if (preg_match('/!2d(-?\d+\.\d+)!3d(-?\d+\.\d+)/', $map, $m)) {
            return ['latitude' => $m[2], 'longitude' => $m[1]];
        }
        if (preg_match('/!3d(-?\d+\.\d+)!2d(-?\d+\.\d+)/', $map, $m)) {
            return ['latitude' => $m[1], 'longitude' => $m[2]];
        }

        // 2. Format directions embed: !1d{lat}!2d{lng} (ambil yang terakhir sebagai tujuan)
        if (preg_match_all('/!1d(-?\d+\.\d+)!2d(-?\d+\.\d+)/', $map, $matches, PREG_SET_ORDER)) {
            $last = end($matches);
            if ((float) $last[1] >= -90 && (float) $last[1] <= 90 && (float) $last[2] >= -180 && (float) $last[2] <= 180) {
                return ['latitude' => $last[1], 'longitude' => $last[2]];
            }
        }

        // 3. Format tautan Google Maps standar: @lat,lng atau q=lat,lng
        if (preg_match('/(?:@|[?&]q=)(-?\d+\.\d+),\s*(-?\d+\.\d+)/', $map, $m)) {
            return ['latitude' => $m[1], 'longitude' => $m[2]];
        }

        return null;
    }

    /**
     * Cek apakah koordinat masih menggunakan default dummy Jakarta (-6.200000, 106.816666).
     */
    public static function isLegacyJakartaCoordinate(?string $lat, ?string $lng): bool
    {
        return trim((string) $lat) === '-6.200000' && trim((string) $lng) === '106.816666';
    }

    public function getResolvedLatitudeAttribute(): ?string
    {
        if (empty($this->latitude) || self::isLegacyJakartaCoordinate($this->latitude, $this->longitude)) {
            $coords = self::extractCoordinatesFromMap($this->map);
            if ($coords) {
                return $coords['latitude'];
            }
        }

        return $this->latitude;
    }

    public function getResolvedLongitudeAttribute(): ?string
    {
        if (empty($this->longitude) || self::isLegacyJakartaCoordinate($this->latitude, $this->longitude)) {
            $coords = self::extractCoordinatesFromMap($this->map);
            if ($coords) {
                return $coords['longitude'];
            }
        }

        return $this->longitude;
    }

    /**
     * Dapatkan URL embed Google Maps yang aman (bebas tag HTML iframe).
     */
    public function getMapEmbedUrlAttribute(): ?string
    {
        if (!empty($this->map)) {
            if (preg_match('/src=["\']([^"\']+)["\']/i', $this->map, $matches)) {
                return $matches[1];
            }
            return trim($this->map);
        }

        if (!empty($this->latitude) && !empty($this->longitude)) {
            return "https://maps.google.com/maps?q={$this->latitude},{$this->longitude}&hl=id&z=16&output=embed";
        }

        return null;
    }

    /**
     * Dapatkan tag iframe Google Maps yang siap dirender di view.
     */
    public function getMapIframeAttribute(): string
    {
        $url = $this->map_embed_url;
        if (!empty($url)) {
            return '<iframe src="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
        }

        if (!empty($this->map) && str_contains($this->map, '<iframe')) {
            return $this->map;
        }

        return '';
    }
}
