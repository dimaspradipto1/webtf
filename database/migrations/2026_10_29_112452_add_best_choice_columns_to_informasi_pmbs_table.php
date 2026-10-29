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
        Schema::table('informasi_pmbs', function (Blueprint $table) {
            $table->boolean('reguler_b_is_best')->default(true)->after('reguler_b_keterangan');
            $table->boolean('reguler_a_is_best')->default(false)->after('reguler_a_keterangan');
            $table->boolean('reguler_c_is_best')->default(false)->after('reguler_c_keterangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi_pmbs', function (Blueprint $table) {
            $table->dropColumn(['reguler_b_is_best', 'reguler_a_is_best', 'reguler_c_is_best']);
        });
    }
};
