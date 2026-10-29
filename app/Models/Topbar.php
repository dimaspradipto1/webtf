<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topbar extends Model
{
    protected $table = 'topbars';

    protected $fillable = [
        'badge_text',
        'marquee_text',
        'badge_icon',
        'alamat',
        'jam_operasional',
        'telepon',
        'email',
        'social_media',
        'instagram_url',
        'youtube_url',
        'linkedin_url',
        'facebook_url',
        'tiktok_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'social_media' => 'array',
    ];
}
