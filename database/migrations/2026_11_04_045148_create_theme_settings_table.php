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
        Schema::create('theme_settings', function (Blueprint $table) {
            $table->id();
            
            // Header / Navbar Styling
            $table->string('header_bg_color', 30)->default('#f9dc4b');
            $table->string('header_text_color', 30)->default('#ffffff');
            $table->string('header_active_bg_color', 30)->default('#000000');
            $table->string('header_active_text_color', 30)->default('#ffffff');
            $table->string('header_login_bg_color', 30)->default('#000000');
            $table->string('header_login_text_color', 30)->default('#ffffff');
            $table->string('header_shadow_color', 30)->default('#f9dc4b');
            $table->boolean('header_is_sticky')->default(true);
            
            // Topbar Styling
            $table->string('topbar_bg_color', 30)->default('#000000');
            $table->string('topbar_text_color', 30)->default('#ffffff');
            
            // Website Accent Color
            $table->string('accent_color', 30)->default('#f9dc4b');
            
            // Reordering Sections JSON
            $table->json('sections_order')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_settings');
    }
};
