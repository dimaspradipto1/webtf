<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];

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
