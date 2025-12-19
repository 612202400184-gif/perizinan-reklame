<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('surveys', function (Blueprint $table) {
            $table->string('id_survey')->primary();
            $table->string('id_permohonan'); // FK
            $table->string('lokasi'); // Koordinat atau Alamat Detail
            $table->text('hasil_survey');
            $table->date('tanggal_survey');
            $table->foreign('id_permohonan')->references('id_permohonan')->on('permohonan_izins')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('surveys');
    }
};
