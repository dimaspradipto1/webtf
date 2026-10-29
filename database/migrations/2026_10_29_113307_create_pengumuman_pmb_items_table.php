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
        Schema::create('pengumuman_pmb_items', function (Blueprint $table) {
            $table->id();
            $table->string('judul_tab');
            $table->string('nama_dokumen');
            $table->string('gdrive_url')->nullable();
            $table->string('tombol_teks')->nullable()->default('Lihat Dokumen');
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
        Schema::dropIfExists('pengumuman_pmb_items');
    }
};
