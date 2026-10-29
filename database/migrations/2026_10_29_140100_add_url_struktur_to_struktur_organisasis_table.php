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
        Schema::table('struktur_organisasis', function (Blueprint $table) {
            if (! Schema::hasColumn('struktur_organisasis', 'url_struktur')) {
                $table->string('url_struktur')->nullable()->after('id');
            }
            if (Schema::hasColumn('struktur_organisasis', 'url_struktur_organisasi')) {
                $table->string('url_struktur_organisasi')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('struktur_organisasis', function (Blueprint $table) {
            if (Schema::hasColumn('struktur_organisasis', 'url_struktur')) {
                $table->dropColumn('url_struktur');
            }
        });
    }
};
