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
        Schema::table('abouts', function (Blueprint $table) {
            if (! Schema::hasColumn('abouts', 'sejarah_link_url')) {
                $table->string('sejarah_link_url')->nullable();
            }
            if (! Schema::hasColumn('abouts', 'sejarah_link_label')) {
                $table->string('sejarah_link_label')->nullable();
            }
            if (! Schema::hasColumn('abouts', 'sejarah_pimpinan_judul')) {
                $table->string('sejarah_pimpinan_judul')->nullable();
            }
            if (! Schema::hasColumn('abouts', 'sejarah_pimpinan')) {
                $table->longText('sejarah_pimpinan')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abouts', function (Blueprint $table) {
            $table->dropColumn([
                'sejarah_link_url',
                'sejarah_link_label',
                'sejarah_pimpinan_judul',
                'sejarah_pimpinan',
            ]);
        });
    }
};

