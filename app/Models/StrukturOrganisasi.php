<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrukturOrganisasi extends Model
{
    protected $table = 'struktur_organisasis';

    protected $fillable = [
        'url_struktur',
        'url_struktur_organisasi',
    ];

    public function getUrlStrukturAttribute($value): ?string
    {
        return $value ?: ($this->attributes['url_struktur_organisasi'] ?? null);
    }
}
