<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('service_types', function (Blueprint $table) {
            // Mengubah kolom 'jenis_bantuan' dari ENUM menjadi STRING
            // agar admin bisa mengetik apa saja secara mandiri.
            $table->string('jenis_bantuan')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_types', function (Blueprint $table) {
            // Kembalikan ke ENUM jika di-rollback (Opsional)
            // Pastikan data yang ada sesuai dengan opsi ini sebelum rollback
            $table->enum('jenis_bantuan', ['tunai', 'sembako', 'barang', 'jasa'])->change();
        });
    }
};
