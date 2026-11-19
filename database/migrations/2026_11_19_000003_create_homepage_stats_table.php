<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('homepage_stats')) {
            Schema::create('homepage_stats', function (Blueprint $table) {
                $table->id();
                $table->string('nilai', 60);
                $table->string('label', 120);
                $table->string('ikon', 80)->nullable();
                $table->unsignedInteger('urutan')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (DB::table('homepage_stats')->count() === 0) {
            $now = now();
            DB::table('homepage_stats')->insert([
                [
                    'nilai' => '1.250+',
                    'label' => 'Mahasiswa Aktif',
                    'ikon' => 'bi-people-fill',
                    'urutan' => 1,
                    'is_active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'nilai' => '2.400+',
                    'label' => 'Lulusan',
                    'ikon' => 'bi-mortarboard-fill',
                    'urutan' => 2,
                    'is_active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'nilai' => '24',
                    'label' => 'Dosen Tetap',
                    'ikon' => 'bi-person-badge-fill',
                    'urutan' => 3,
                    'is_active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'nilai' => '100+',
                    'label' => 'Mitra Industri',
                    'ikon' => 'bi-buildings-fill',
                    'urutan' => 4,
                    'is_active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'nilai' => 'Baik Sekali',
                    'label' => 'Akreditasi',
                    'ikon' => 'bi-patch-check-fill',
                    'urutan' => 5,
                    'is_active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('homepage_stats');
    }
};
