<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('saranas')) {
            Schema::table('saranas', function (Blueprint $table) {
                if (!Schema::hasColumn('saranas', 'slug')) {
                    $table->string('slug', 220)->nullable()->unique()->after('nama');
                }
                if (!Schema::hasColumn('saranas', 'foto')) {
                    $table->string('foto', 255)->nullable()->after('deskripsi');
                }
                if (!Schema::hasColumn('saranas', 'kepala_lab')) {
                    $table->string('kepala_lab', 200)->nullable()->after('foto');
                }
                if (!Schema::hasColumn('saranas', 'lokasi')) {
                    $table->string('lokasi', 200)->nullable()->after('kepala_lab');
                }
                if (!Schema::hasColumn('saranas', 'kapasitas')) {
                    $table->string('kapasitas', 100)->nullable()->after('lokasi');
                }
                if (!Schema::hasColumn('saranas', 'daftar_perangkat')) {
                    $table->text('daftar_perangkat')->nullable()->after('kapasitas');
                }
                if (!Schema::hasColumn('saranas', 'mata_kuliah_praktikum')) {
                    $table->text('mata_kuliah_praktikum')->nullable()->after('daftar_perangkat');
                }
                if (!Schema::hasColumn('saranas', 'jadwal_pemakaian')) {
                    $table->text('jadwal_pemakaian')->nullable()->after('mata_kuliah_praktikum');
                }
            });

            // Isi slug otomatis untuk data sarana yang sudah ada
            $existing = DB::table('saranas')->select('id', 'nama', 'slug')->get();
            foreach ($existing as $row) {
                if (empty($row->slug)) {
                    $base = Str::slug($row->nama ?: 'fasilitas') ?: 'fasilitas';
                    $slug = $base;
                    $counter = 2;
                    while (DB::table('saranas')->where('slug', $slug)->where('id', '!=', $row->id)->exists()) {
                        $slug = $base . '-' . $counter;
                        $counter++;
                    }
                    DB::table('saranas')->where('id', $row->id)->update(['slug' => $slug]);
                }
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('saranas')) {
            Schema::table('saranas', function (Blueprint $table) {
                $cols = [
                    'slug',
                    'foto',
                    'kepala_lab',
                    'lokasi',
                    'kapasitas',
                    'daftar_perangkat',
                    'mata_kuliah_praktikum',
                    'jadwal_pemakaian',
                ];
                foreach ($cols as $col) {
                    if (Schema::hasColumn('saranas', $col)) {
                        if ($col === 'slug') {
                            $table->dropUnique(['slug']);
                        }
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};
