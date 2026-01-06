<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('service_types', function (Blueprint $table) {
            $table->id();
            $table->string('nama_layanan'); // Contoh: SKTM, Rekomendasi BPJS
            $table->string('kode_layanan')->unique(); // Contoh: SKTM-01
            $table->json('syarat_dokumen')->nullable(); // Disimpan dalam JSON
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_types');
    }
};
