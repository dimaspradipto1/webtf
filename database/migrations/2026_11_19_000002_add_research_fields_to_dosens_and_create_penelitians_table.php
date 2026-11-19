<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('dosens')) {
            Schema::table('dosens', function (Blueprint $table) {
                if (!Schema::hasColumn('dosens', 'bidang_keahlian')) {
                    $table->string('bidang_keahlian')->nullable()->after('nuptk');
                }
                if (!Schema::hasColumn('dosens', 'link_sinta')) {
                    $table->string('link_sinta', 500)->nullable()->after('link');
                }
                if (!Schema::hasColumn('dosens', 'link_scholar')) {
                    $table->string('link_scholar', 500)->nullable()->after('link_sinta');
                }
            });
        }

        if (!Schema::hasTable('penelitians')) {
            Schema::create('penelitians', function (Blueprint $table) {
                $table->id();
                $table->string('jenis', 30)->default('penelitian'); // penelitian | pengabdian
                $table->string('judul', 500);
                $table->string('ketua');
                $table->text('anggota')->nullable();
                $table->string('sumber_dana')->nullable();
                $table->unsignedSmallInteger('tahun')->default(2026);
                $table->string('bidang_riset')->nullable();
                $table->string('link_publikasi', 500)->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('penelitians');
        if (Schema::hasTable('dosens')) {
            Schema::table('dosens', function (Blueprint $table) {
                $cols = array_filter(['bidang_keahlian', 'link_sinta', 'link_scholar'], fn ($c) => Schema::hasColumn('dosens', $c));
                if (!empty($cols)) {
                    $table->dropColumn($cols);
                }
            });
        }
    }
};
