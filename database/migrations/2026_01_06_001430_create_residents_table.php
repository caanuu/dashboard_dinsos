<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_residents_table.php
    public function up()
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('no_kk', 16);
            $table->string('nama_lengkap');
            $table->text('alamat');
            $table->string('pekerjaan')->nullable();
            $table->decimal('penghasilan', 15, 2)->default(0); // Untuk scoring kemiskinan
            $table->timestamps();
        });
    }
};
