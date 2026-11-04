<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->date('date');
            $table->longText('content')->nullable();
            $table->string('file_path')->nullable();
            $table->string('link_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // Seed default initial data matching the website mockups
        DB::table('announcements')->insert([
            [
                'title' => 'Pengumuman Pengisian KRS dan validasi KRS Tahun Akademik 2026/2027 Gasal',
                'slug' => 'pengumuman-pengisian-krs-dan-validasi-krs-ta-2026-2027-gasal',
                'date' => '2026-08-15',
                'content' => 'Diberitahukan kepada seluruh mahasiswa Program Studi Teknik Informatika (FST) bahwa periode pengisian KRS online dan proses validasi oleh Dosen Pembimbing Akademik (PA) untuk Semester Gasal Tahun Akademik 2026/2027 telah dibuka.',
                'file_path' => null,
                'link_url' => null,
                'is_active' => true,
                'urutan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pengumuman Semester Antara TA. 2025-2026',
                'slug' => 'pengumuman-semester-antara-ta-2025-2026',
                'date' => '2026-08-01',
                'content' => 'Informasi pendaftaran dan pelaksanaan perkuliahan Semester Antara Tahun Akademik 2025-2026 bagi mahasiswa yang ingin melakukan perbaikan nilai atau percepatan kelulusan.',
                'file_path' => null,
                'link_url' => null,
                'is_active' => true,
                'urutan' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};

