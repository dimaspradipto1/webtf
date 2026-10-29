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
        Schema::create('survey_layanan_settings', function (Blueprint $table) {
            $table->id();
            $table->string('judul_hero')->default('Survey Layanan');
            $table->string('subjudul_hero')->default('Kuesioner Evaluasi Kepuasan & Mutu Pelayanan Humas Teknik Informatika');
            $table->string('judul_seksi')->default('Survei Evaluasi');
            $table->text('deskripsi_seksi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('survey_layanan_buttons', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255); // contoh: Survei Kepuasan Informasi Publik
            $table->string('link_url', 1000); // link Google Form / kuesioner
            $table->string('tombol_teks', 100)->default('Isi Survei'); // teks tombol, default "Isi Survei"
            $table->boolean('target_blank')->default(true);
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_layanan_buttons');
        Schema::dropIfExists('survey_layanan_settings');
    }
};
