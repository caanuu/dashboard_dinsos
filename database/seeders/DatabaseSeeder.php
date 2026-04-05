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
        // ========================================
        // SIKASOS - Sistem Informasi Kesejahteraan Sosial
        // ========================================

        // 1. Buat User Admin/Petugas dan Masyarakat
        User::create([
            'name' => 'Admin SIKASOS',
            'email' => 'admin@sikasos.go.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $userMasyarakat = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('masyarakat123'),
            'role' => 'masyarakat',
        ]);

        User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'password' => Hash::make('masyarakat123'),
            'role' => 'masyarakat',
        ]);

        // 2. Buat Data Jenis Layanan (Service Types)
        $serviceBPJS = ServiceType::create([
            'nama_layanan' => 'Rekomendasi BPJS PBI (Gratis)',
            'kode_layanan' => 'BPJS-PBI',
            'jenis_bantuan' => 'jasa',
            'deskripsi' => 'Rekomendasi untuk pembuatan BPJS Kesehatan yang iurannya dibayar pemerintah.',
        ]);

        $serviceSKTM = ServiceType::create([
            'nama_layanan' => 'Surat Keterangan Tidak Mampu (SKTM)',
            'kode_layanan' => 'SKTM-UMUM',
            'jenis_bantuan' => 'jasa',
            'deskripsi' => 'Surat keterangan untuk keperluan administrasi sekolah atau rumah sakit.',
        ]);

        $serviceLogistik = ServiceType::create([
            'nama_layanan' => 'Bantuan Logistik Bencana',
            'kode_layanan' => 'LOGISTIK-01',
            'jenis_bantuan' => 'sembako',
            'deskripsi' => 'Bantuan berupa sembako/pakaian untuk korban bencana.',
        ]);

        $serviceLansia = ServiceType::create([
            'nama_layanan' => 'Santunan Lansia',
            'kode_layanan' => 'TUNAI-LANSIA',
            'jenis_bantuan' => 'tunai',
            'deskripsi' => 'Bantuan uang tunai bulanan untuk lanjut usia terlantar.',
        ]);

        // 3. Buat Data Penduduk Dummy
        $resident1 = Resident::create([
            'nik' => '1234567890123456',
            'no_kk' => '1234567890123456',
            'nama_lengkap' => 'Budi Santoso',
            'alamat' => 'Jl. Merdeka No. 1, Tebing Tinggi',
            'pekerjaan' => 'Buruh Harian Lepas',
            'penghasilan' => 1500000,
            'jumlah_tanggungan' => 3,
            'is_dtks' => true,
            'no_hp' => '081234567890',
        ]);

        $resident2 = Resident::create([
            'nik' => '1234567890123457',
            'no_kk' => '1234567890123457',
            'nama_lengkap' => 'Siti Aminah',
            'alamat' => 'Jl. Sudirman No. 45, Tebing Tinggi',
            'pekerjaan' => 'Pedagang Kecil',
            'penghasilan' => 1200000,
            'jumlah_tanggungan' => 2,
            'is_dtks' => true,
            'no_hp' => '081234567891',
        ]);

        $resident3 = Resident::create([
            'nik' => '1234567890123458',
            'no_kk' => '1234567890123458',
            'nama_lengkap' => 'Ahmad Yani',
            'alamat' => 'Jl. Gatot Subroto No. 12, Tebing Tinggi',
            'pekerjaan' => 'Pensiunan',
            'penghasilan' => 800000,
            'jumlah_tanggungan' => 1,
            'is_dtks' => false,
            'no_hp' => '081234567892',
        ]);
    }
}
