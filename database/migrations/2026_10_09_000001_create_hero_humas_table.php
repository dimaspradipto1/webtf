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
        Schema::create('hero_humas', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable()->default('Selamat Datang');
            $table->string('subjudul')->nullable()->default('di Biro Hubungan Masyarakat dan Protokoler Teknik Informatika');
            $table->string('badge_text')->nullable()->default('Layanan');
            $table->string('background_image')->nullable();
            $table->string('pill_text_1')->nullable()->default('Informasi Khusus PMB TA 2026/2027');
            $table->string('pill_url_1')->nullable();
            $table->string('pill_text_2')->nullable()->default('Pengumuman Prestasi & Kejuaraan Kampus');
            $table->string('pill_url_2')->nullable();
            $table->string('pill_text_3')->nullable()->default('Live Chat Layanan Humas');
            $table->string('pill_url_3')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_humas');
    }
};
