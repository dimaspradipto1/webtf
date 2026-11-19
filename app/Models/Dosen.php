<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dosen extends Model
{
    protected $table = 'dosens';

    protected $fillable = [
        'layanan_id',
        'prodi_nama',
        'nama_dosen',
        'jabatan_fungsional',
        'nidn',
        'nuptk',
        'bidang_keahlian',
        'link',
        'link_sinta',
        'link_scholar',
        'foto',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'urutan' => 'integer',
        'is_active' => 'boolean',
    ];

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }
}
