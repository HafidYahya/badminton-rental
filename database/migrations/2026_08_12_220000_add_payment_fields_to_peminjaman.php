<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->double('p_fee')->default(0)->after('p_total_harga');
            $table->double('p_total_payment')->default(0)->after('p_fee');
            $table->string('p_payment_number')->nullable()->after('p_payment_method');
            $table->dateTime('p_expired_at')->nullable()->after('p_payment_number');
            $table->dateTime('p_completed_at')->nullable()->after('p_expired_at');
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn(['p_fee', 'p_total_payment', 'p_payment_number', 'p_expired_at', 'p_completed_at']);
        });
    }
};
