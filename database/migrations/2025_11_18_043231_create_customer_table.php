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
        Schema::create('customer', function (Blueprint $table) {
            $table->id('c_id');
            $table->string('c_nama_lengkap');
            $table->string('c_no_hp');
            $table->string('c_username');
            $table->string('c_password');
            $table->text('c_alamat');
            $table->string('c_foto_profile');
            $table->string('c_is_member');
            $table->string('c_status');
            $table->date('c_tanggal_daftar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};