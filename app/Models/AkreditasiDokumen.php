<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkreditasiDokumen extends Model
{
    use HasFactory;

    protected $table = 'akreditasi_dokumens';

    protected $fillable = [
        'kategori_tab',
        'nama_tab',
        'grup',
        'nama_dokumen',
        'gdrive_url',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('urutan')->orderBy('id');
    }
}

