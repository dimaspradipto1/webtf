<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContactMessage extends Model
{
    protected $table = 'contact_messages';

    protected static bool $tableEnsured = false;

    public const KATEGORI_LIST = [
        'PMB',
        'Akademik',
        'Kerja Sama',
        'Lainnya',
    ];

    protected $fillable = [
        'nama',
        'email',
        'kategori',
        'pesan',
        'status',
        'ip_address',
        'email_forwarded',
        'read_at',
    ];

    protected $casts = [
        'email_forwarded' => 'boolean',
        'read_at' => 'datetime',
    ];

    public static function ensureTable(): void
    {
        if (static::$tableEnsured) {
            return;
        }
        static::$tableEnsured = true;

        try {
            if (!Schema::hasTable('contact_messages')) {
                Schema::create('contact_messages', function (Blueprint $table) {
                    $table->id();
                    $table->string('nama', 150);
                    $table->string('email', 150);
                    $table->string('kategori', 50)->default('Lainnya');
                    $table->text('pesan');
                    $table->string('status', 20)->default('baru');
                    $table->string('ip_address', 45)->nullable();
                    $table->boolean('email_forwarded')->default(false);
                    $table->timestamp('read_at')->nullable();
                    $table->timestamps();
                });
            }
        } catch (\Throwable $e) {
            // Abaikan bila user DB hosting tidak memiliki izin DDL
        }
    }
}
