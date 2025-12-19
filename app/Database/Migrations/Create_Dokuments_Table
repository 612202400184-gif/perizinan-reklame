<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('dokumens', function (Blueprint $table) {
            $table->string('id_dokumen')->primary();
            $table->string('id_permohonan'); // FK
            $table->string('tipe_dokumen'); // KTP / Foto Lokasi
            $table->string('filePath');
            $table->foreign('id_permohonan')->references('id_permohonan')->on('permohonan_izins')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('dokumens');
    }
};
