<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('application_logs', function (Blueprint $table) {
            $table->id();
            $table->uuid('application_id');
            $table->foreign('application_id')->references('id')->on('applications');
            $table->foreignId('user_id')->constrained('users'); // Siapa yang aksi?
            $table->string('action'); // VERIFIKASI, TOLAK, SETUJUI
            $table->text('catatan')->nullable(); // Alasan/Catatan
            $table->timestamps();
        });
    }
};
