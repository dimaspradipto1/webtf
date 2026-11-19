<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('sambutan_dekans')) {
            Schema::table('sambutan_dekans', function (Blueprint $table) {
                if (!Schema::hasColumn('sambutan_dekans', 'video_judul')) {
                    $table->string('video_judul', 200)->nullable()->after('sambutan_dekan');
                }
                if (!Schema::hasColumn('sambutan_dekans', 'video_subjudul')) {
                    $table->string('video_subjudul', 300)->nullable()->after('video_judul');
                }
                if (!Schema::hasColumn('sambutan_dekans', 'video_url')) {
                    $table->string('video_url', 500)->nullable()->after('video_subjudul');
                }
                if (!Schema::hasColumn('sambutan_dekans', 'video_aktif')) {
                    $table->boolean('video_aktif')->default(true)->after('video_url');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('sambutan_dekans')) {
            Schema::table('sambutan_dekans', function (Blueprint $table) {
                foreach (['video_aktif', 'video_url', 'video_subjudul', 'video_judul'] as $col) {
                    if (Schema::hasColumn('sambutan_dekans', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};
