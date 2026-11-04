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
            $table->string('footer_bg_color', 30)->default('#000000')->after('sections_order');
            $table->string('footer_text_color', 30)->default('#ffffff')->after('footer_bg_color');
            $table->string('footer_heading_color', 30)->default('#f9dc4b')->after('footer_text_color');
            $table->string('footer_border_top_color', 30)->default('#f9dc4b')->after('footer_heading_color');
            $table->string('footer_link_color', 30)->default('#ffffff')->after('footer_border_top_color');
            $table->string('footer_link_hover_color', 30)->default('#f9dc4b')->after('footer_link_color');
            $table->string('footer_social_bg_color', 30)->default('#f9dc4b')->after('footer_link_hover_color');
            $table->string('footer_social_text_color', 30)->default('#000000')->after('footer_social_bg_color');
            $table->text('footer_description')->nullable()->after('footer_social_text_color');
            $table->string('footer_copyright', 255)->nullable()->after('footer_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('theme_settings', function (Blueprint $table) {
            $table->dropColumn([
                'footer_bg_color',
                'footer_text_color',
                'footer_heading_color',
                'footer_border_top_color',
                'footer_link_color',
                'footer_link_hover_color',
                'footer_social_bg_color',
                'footer_social_text_color',
                'footer_description',
                'footer_copyright',
            ]);
        });
    }
};
