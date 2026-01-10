<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Data Penduduk (Ditambah data untuk Scoring)
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('no_kk', 16);
            $table->string('nama_lengkap');
            $table->text('alamat');
            $table->string('pekerjaan')->nullable();
            $table->integer('jumlah_tanggungan')->default(0); // SKORING
            $table->decimal('penghasilan', 15, 2)->default(0); // SKORING
            $table->boolean('is_dtks')->default(false); // SKORING
            $table->string('no_hp')->nullable();
            $table->timestamps();
        });

        // 2. Jenis Layanan
        Schema::create('service_types', function (Blueprint $table) {
            $table->id();
            $table->string('nama_layanan');
            $table->string('kode_layanan')->unique();
            $table->enum('jenis_bantuan', ['tunai', 'sembako', 'barang', 'jasa']); // Klasifikasi
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // 3. Permohonan (Applications)
        Schema::create('applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('resident_id')->constrained('residents')->onDelete('cascade');
            $table->foreignId('service_type_id')->constrained('service_types');
            $table->string('nomor_tiket')->unique();
            $table->string('file_persyaratan')->nullable();

            // VERIFIKASI & SCORING
            $table->integer('skor_kelayakan')->default(0);
            $table->boolean('validasi_dukcapil')->default(false); // Hasil Cek NIK

            $table->enum('status', ['pending', 'verified', 'approved', 'rejected', 'distributed'])->default('pending');
            $table->text('keterangan_tolak')->nullable();
            $table->timestamps();
        });

        // 4. Penyaluran Bantuan (Distribution) - BARU
        Schema::create('distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('application_id')->constrained('applications')->onDelete('cascade');
            $table->date('tanggal_penyaluran');
            $table->string('lokasi_penyaluran');
            $table->string('bukti_penyaluran')->nullable(); // Foto penyerahan/TTD
            $table->enum('status_realisasi', ['terjadwal', 'disalurkan', 'gagal'])->default('terjadwal');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        // 5. Pengaduan Masyarakat - BARU
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('tiket_pengaduan')->unique();
            $table->string('nama_pelapor'); // Bisa anonim atau ambil dari user
            $table->string('nik_pelapor')->nullable();
            $table->text('isi_aduan');
            $table->text('tanggapan_petugas')->nullable();
            $table->enum('status', ['masuk', 'diproses', 'selesai'])->default('masuk');
            $table->timestamps();
        });

        // 6. Log Aplikasi
        Schema::create('application_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('application_id')->constrained('applications')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->string('action');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_logs');
        Schema::dropIfExists('complaints');
        Schema::dropIfExists('distributions');
        Schema::dropIfExists('applications');
        Schema::dropIfExists('service_types');
        Schema::dropIfExists('residents');
    }
};
