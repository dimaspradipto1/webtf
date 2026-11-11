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
        if (Schema::hasTable('contacts') && !Schema::hasColumn('contacts', 'jam_operasional')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->string('jam_operasional')->nullable()->default('Senin – Sabtu: 08.00 – 17.00 WIB')->after('alamat');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('contacts') && Schema::hasColumn('contacts', 'jam_operasional')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->dropColumn('jam_operasional');
            });
        }
    }
};
