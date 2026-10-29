<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permintaan_rilis_settings', function (Blueprint $table) {
            $table->id();
            $table->string('judul_hero')->default('Permintaan Rilis');
            $table->string('subjudul_hero')->default('Layanan Publikasi Berita & Siaran Pers Resmi Teknik Informatika');
            $table->string('badge_label')->default('LAYANAN PUBLIKASI & SIARAN PERS');
            $table->string('judul_seksi')->default('Ketentuan Permintaan Rilis Berita');
            $table->text('deskripsi_seksi')->nullable();

            // Link & Kontak Pengajuan
            $table->string('link_form', 1000)->nullable();
            $table->string('no_wa', 50)->nullable();
            $table->string('email_tujuan', 100)->nullable();
            $table->string('file_sop', 255)->nullable();

            // Parameter & Teks Khusus
            $table->integer('min_kata')->default(250);
            $table->integer('min_paragraf')->default(4);
            $table->text('catatan_tambahan')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan_rilis_settings');
    }
};
