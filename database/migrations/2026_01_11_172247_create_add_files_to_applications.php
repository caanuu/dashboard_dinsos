<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            // file_persyaratan lama kita gunakan khusus untuk PDF Proposal
            // Kita tambah 3 kolom baru untuk foto
            $table->string('file_ktp')->nullable()->after('file_persyaratan');
            $table->string('file_kk')->nullable()->after('file_ktp');
            $table->string('file_pengantar')->nullable()->after('file_kk');
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['file_ktp', 'file_kk', 'file_pengantar']);
        });
    }
};
