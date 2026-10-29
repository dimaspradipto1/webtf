<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('kalender_akademik_items')) {
            Schema::create('kalender_akademik_items', function (Blueprint $table) {
                $table->id();
                $table->string('judul_tab');
                $table->string('nama_dokumen');
                $table->string('gdrive_url', 1000)->nullable();
                $table->string('tombol_teks')->default('Lihat Document');
                $table->integer('urutan')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('kalender_akademik_items');
    }
};

