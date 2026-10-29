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
        Schema::create('pendampingan_acara_settings', function (Blueprint $table) {
            $table->id();
            $table->string('judul_hero')->default('Pendampingan Acara');
            $table->string('subjudul_hero')->default('Layanan Konsultasi Protokol & Pendampingan Kegiatan Resmi Teknik Informatika');
            $table->string('judul_seksi')->default('Pendampingan Acara');
            $table->string('sapaan')->default('Halo, Civitas Akademika Teknik Informatika dan Mitra Eksternal!');
            $table->text('paragraf_1')->nullable();
            $table->text('paragraf_2')->nullable();
            $table->text('poin_bantuan')->nullable();
            $table->text('paragraf_3')->nullable();
            $table->string('link_form', 1000)->nullable();
            $table->string('tombol_teks')->default('Ajukan Permohonan');
            $table->string('no_wa', 50)->nullable();
            $table->string('file_sop', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendampingan_acara_settings');
    }
};
