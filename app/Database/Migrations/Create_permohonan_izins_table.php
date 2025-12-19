<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('permohonan_izins', function (Blueprint $table) {
            $table->string('id_permohonan')->primary(); // PK (Format REG-xxxx)
            $table->date('tanggal_pengajuan');
            $table->string('status'); // Pending, Survey, Approval, Siap Bayar, Selesai
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('permohonan_izins');
    }
};
