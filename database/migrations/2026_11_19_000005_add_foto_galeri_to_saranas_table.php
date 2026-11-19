<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('saranas') && !Schema::hasColumn('saranas', 'foto_galeri')) {
            Schema::table('saranas', function (Blueprint $table) {
                $table->json('foto_galeri')->nullable()->after('foto');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('saranas') && Schema::hasColumn('saranas', 'foto_galeri')) {
            Schema::table('saranas', function (Blueprint $table) {
                $table->dropColumn('foto_galeri');
            });
        }
    }
};
