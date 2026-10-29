<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KalenderAkademikItem extends Model
{
    protected $table = 'kalender_akademik_items';

    protected $fillable = [
        'judul_tab',
        'nama_dokumen',
        'gdrive_url',
        'tombol_teks',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}

