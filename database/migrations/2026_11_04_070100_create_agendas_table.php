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
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('date_text');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->string('link_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // Seed default initial data matching the website mockups
        DB::table('agendas')->insert([
            [
                'title' => 'Pendaftaran Semester Antara',
                'slug' => 'pendaftaran-semester-antara',
                'date_text' => '20 - 31 Juli 2026',
                'start_date' => '2026-07-20',
                'end_date' => '2026-07-31',
                'location' => 'Portal SIAKAD & Ruang Administrasi TF',
                'description' => 'Masa pendaftaran dan pembayaran perkuliahan Semester Antara Program Studi Teknik Informatika.',
                'link_url' => null,
                'is_active' => true,
                'urutan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Perkuliahan Semester Antara',
                'slug' => 'perkuliahan-semester-antara',
                'date_text' => '03 - 28 Agustus 2026',
                'start_date' => '2026-08-03',
                'end_date' => '2026-08-28',
                'location' => 'Laboratorium Komputer & Ruang Kuliah FST',
                'description' => 'Pelaksanaan kegiatan belajar mengajar Semester Antara secara tatap muka dan praktikum.',
                'link_url' => null,
                'is_active' => true,
                'urutan' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Penyerahan Nilai Semester Antara',
                'slug' => 'penyerahan-nilai-semester-antara',
                'date_text' => '31 Agustus - 05 September 2026',
                'start_date' => '2026-08-31',
                'end_date' => '2026-09-05',
                'location' => 'Sistem Informasi Akademik',
                'description' => 'Batas akhir input dan validasi nilai akhir mahasiswa oleh dosen pengampu mata kuliah.',
                'link_url' => null,
                'is_active' => true,
                'urutan' => 3,
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
        Schema::dropIfExists('agendas');
    }
};
