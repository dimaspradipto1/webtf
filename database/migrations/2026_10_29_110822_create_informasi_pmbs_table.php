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
        Schema::create('informasi_pmbs', function (Blueprint $table) {
            $table->id();
            $table->string('judul_hero')->nullable()->default('Penerimaan Mahasiswa Baru FST UIS 2026');
            $table->string('subjudul_hero')->nullable()->default('Tahun Akademik 2026/2027');
            $table->string('link_pendaftaran')->nullable()->default('https://pmb.uis.ac.id');
            $table->string('no_whatsapp')->nullable()->default('081270000000');
            $table->string('banner_hero')->nullable();
            
            // Brosur
            $table->string('brosur_gambar')->nullable();
            $table->string('brosur_pdf')->nullable();
            
            // Akreditasi & Keunggulan
            $table->string('akreditasi_predikat')->nullable()->default('B');
            $table->string('akreditasi_teks')->nullable()->default('Mutu Sangat Baik Terakreditasi dengan Predikat "B" oleh BAN-PT');
            $table->json('keunggulan_items')->nullable();
            
            // Infografis Upload (PNG/JPG)
            $table->string('jadwal_gambar')->nullable();
            $table->string('biaya_gambar')->nullable();
            $table->string('alur_gambar')->nullable();
            
            // Kelas PMB (3 Paket)
            $table->string('reguler_b_nama')->nullable()->default('Reguler B');
            $table->string('reguler_b_biaya')->nullable()->default('Rp 625.000 / Bulan');
            $table->text('reguler_b_keterangan')->nullable();
            
            $table->string('reguler_a_nama')->nullable()->default('Reguler A');
            $table->string('reguler_a_biaya')->nullable()->default('Rp 825.000 / Bulan');
            $table->text('reguler_a_keterangan')->nullable();
            
            $table->string('reguler_c_nama')->nullable()->default('Reguler C');
            $table->string('reguler_c_biaya')->nullable()->default('Rp 925.000 / Bulan');
            $table->text('reguler_c_keterangan')->nullable();
            
            // CTA Bawah
            $table->string('banner_cta')->nullable();
            $table->string('cta_judul')->nullable()->default('Jadilah Bagian Dari Fakultas Sains Dan Teknologi UIS');
            $table->string('cta_subjudul')->nullable()->default('Pendaftaran Telah Dibuka Sekarang');
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_pmbs');
    }
};
