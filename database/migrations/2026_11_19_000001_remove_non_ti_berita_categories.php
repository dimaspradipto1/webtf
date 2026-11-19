<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('categories')) {
            DB::table('categories')
                ->where('type', 'berita')
                ->whereIn('slug', [
                    'bisnis-manajemen',
                    'k3-lingkungan-industri',
                    'k3-keselamatan-kerja',
                    'kesehatan-lingkungan',
                ])
                ->delete();
        }
    }

    public function down(): void
    {
        // No-op
    }
};
