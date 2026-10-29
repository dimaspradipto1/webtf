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
        if (! Schema::hasTable('akreditasi_dokumens')) {
            Schema::create('akreditasi_dokumens', function (Blueprint $table) {
                $table->id();
                $table->string('kategori_tab', 50)->default('instrumen'); // instrumen, kelengkapan
                $table->string('nama_tab')->default('Instrumen Akreditasi');
                $table->string('grup')->nullable();
                $table->string('nama_dokumen');
                $table->text('gdrive_url')->nullable();
                $table->integer('urutan')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akreditasi_dokumens');
    }
};

