<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->string('id_pembayaran')->primary();
            $table->string('id_permohonan'); // FK
            $table->float('nominal');
            $table->string('metode_pembayaran');
            $table->string('status_pembayaran'); // Lunas / Menunggu
            $table->foreign('id_permohonan')->references('id_permohonan')->on('permohonan_izins')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('pembayarans');
    }
};
