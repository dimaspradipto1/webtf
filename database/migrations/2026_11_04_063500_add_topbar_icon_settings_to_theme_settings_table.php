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
            $table->string('topbar_social_bg_color', 30)->default('#ffffff')->after('topbar_text_color');
            $table->string('topbar_social_text_color', 30)->default('#000000')->after('topbar_social_bg_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('theme_settings', function (Blueprint $table) {
            $table->dropColumn([
                'topbar_social_bg_color',
                'topbar_social_text_color',
            ]);
        });
    }
};

