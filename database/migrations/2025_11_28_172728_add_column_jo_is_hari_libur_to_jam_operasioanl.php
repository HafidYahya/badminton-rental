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
        Schema::table('jam_operasional', function (Blueprint $table) {
            $table->tinyInteger('jo_is_hari_libur')->nullable()->after('jo_jam_tutup');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jam_operasional', function (Blueprint $table) {
            $table->dropColumn('jo_is_hari_libur');
        });
    }
};