<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('izins', function (Blueprint $table) {
            $table->string('id_izin')->primary();
            $table->string('id_permohonan'); // FK
            $table->string('nomor_izin');
            $table->date('tanggal_terbit');
            $table->date('masa_berlaku');
            $table->foreign('id_permohonan')->references('id_permohonan')->on('permohonan_izins')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('izins');
    }
};
