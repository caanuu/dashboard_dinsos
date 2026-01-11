<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Resident;
use App\Models\ServiceType;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat User Admin, Operator, dan Kadis
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@dinsos.go.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Operator Pelayanan',
            'email' => 'operator@dinsos.go.id',
            'password' => Hash::make('password'),
            'role' => 'operator',
        ]);

        User::create([
            'name' => 'Kepala Dinas',
            'email' => 'kadis@dinsos.go.id',
            'password' => Hash::make('password'),
            'role' => 'kadis',
        ]);

        // 2. Buat Data Jenis Layanan (Service Types)
        // PERBAIKAN: Menambahkan field 'jenis_bantuan'
        ServiceType::create([
            'nama_layanan' => 'Rekomendasi BPJS PBI (Gratis)',
            'kode_layanan' => 'BPJS-PBI',
            'jenis_bantuan' => 'Jasa', // Ditambahkan
            'deskripsi' => 'Rekomendasi untuk pembuatan BPJS Kesehatan yang iurannya dibayar pemerintah.',
        ]);

        ServiceType::create([
            'nama_layanan' => 'Surat Keterangan Tidak Mampu (SKTM)',
            'kode_layanan' => 'SKTM-UMUM',
            'jenis_bantuan' => 'Jasa', // Ditambahkan
            'deskripsi' => 'Surat keterangan untuk keperluan administrasi sekolah atau rumah sakit.',
        ]);

        ServiceType::create([
            'nama_layanan' => 'Bantuan Logistik Bencana',
            'kode_layanan' => 'LOGISTIK-01',
            'jenis_bantuan' => 'Sembako', // Ditambahkan
            'deskripsi' => 'Bantuan berupa sembako/pakaian untuk korban bencana.',
        ]);

        ServiceType::create([
            'nama_layanan' => 'Santunan Lansia',
            'kode_layanan' => 'TUNAI-LANSIA',
            'jenis_bantuan' => 'Tunai', // Ditambahkan
            'deskripsi' => 'Bantuan uang tunai bulanan untuk lanjut usia terlantar.',
        ]);

        // 3. Buat Data Penduduk Dummy (Optional)
        Resident::create([
            'nik' => '1234567890123456',
            'no_kk' => '1234567890123456',
            'nama_lengkap' => 'Budi Santoso',
            'alamat' => 'Jl. Merdeka No. 1, Medan',
            'pekerjaan' => 'Buruh Harian Lepas',
            'penghasilan' => 1500000,
            'jumlah_tanggungan' => 3,
            'is_dtks' => true,
            'no_hp' => '081234567890',
        ]);
    }
}
