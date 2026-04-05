<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambah kolom NIK dan No HP untuk user warga
            $table->string('nik', 16)->nullable()->unique()->after('email');
            $table->string('no_hp', 15)->nullable()->after('nik');
        });

        // Mengubah kolom role agar bisa menerima 'warga'
        // Kita ubah ke string agar fleksibel (jika sebelumnya enum)
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('warga')->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nik', 'no_hp']);
        });
    }
};
