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
        Schema::create('page_headers', function (Blueprint $table) {
            $table->id();
            $table->string('page_key')->unique();
            $table->string('judul');
            $table->text('subjudul')->nullable();
            $table->string('badge_text')->nullable();
            $table->string('breadcrumb_label')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_headers');
    }
};

