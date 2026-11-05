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
        Schema::table('theme_settings', function (Blueprint $table) {
            $table->string('header_logo')->nullable()->after('header_is_sticky');
            $table->string('header_title')->nullable()->default('TEKNIK INFORMATIKA')->after('header_logo');
            $table->string('header_subtitle')->nullable()->default('Fakultas Sains dan Teknologi')->after('header_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('theme_settings', function (Blueprint $table) {
            $table->dropColumn([
                'header_logo',
                'header_title',
                'header_subtitle',
            ]);
        });
    }
};
