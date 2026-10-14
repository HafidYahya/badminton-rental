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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('p_id');
            $table->unsignedBigInteger('p_customer_id');
            $table->unsignedBigInteger('p_lapangan_id');
            $table->double('p_harga_per_jam');
            $table->double('p_diskon')->nullable();
            $table->double('p_total_harga');
            $table->date('p_tanggal');
            $table->dateTime('p_jam_mulai');
            $table->dateTime('p_jam_selesai');
            $table->smallInteger('p_total_jam');
            $table->string('p_status')->default('PENDING');
            $table->text('p_alasan_cancel')->nullable();
            $table->timestamps();

            $table->foreign('p_customer_id')->references('c_id')->on('customer')->cascadeOnDelete();
            $table->foreign('p_lapangan_id')->references('l_id')->on('lapangan')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};