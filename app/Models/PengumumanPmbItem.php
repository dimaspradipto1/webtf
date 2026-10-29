<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengumumanPmbItem extends Model
{
    use HasFactory;

    protected $table = 'pengumuman_pmb_items';

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
        'urutan' => 'integer',
    ];
}
