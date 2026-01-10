<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ServiceType;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun ADMIN (Superuser)
        User::create([
            'name' => 'Administrator Sistem',
            'email' => 'admin@dinsos.go.id',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        // 2. Akun OPERATOR (Petugas Loket/Front Desk)
        User::create([
            'name' => 'Petugas Pelayanan',
            'email' => 'operator@dinsos.go.id',
            'password' => bcrypt('password'),
            'role' => 'operator'
        ]);

        // 3. Akun KEPALA DINAS (Untuk Approval)
        User::create([
            'name' => 'Kepala Dinas Sosial',
            'email' => 'kadis@dinsos.go.id',
            'password' => bcrypt('password'),
            'role' => 'kadis'
        ]);

        // 4. Master Data Layanan (Contoh Nyata)
        $layanan = [
            ['nama_layanan' => 'Rekomendasi BPJS PBI (Gratis)', 'kode_layanan' => 'BPJS-PBI'],
            ['nama_layanan' => 'Surat Keterangan Tidak Mampu (SKTM)', 'kode_layanan' => 'SKTM-UMUM'],
            ['nama_layanan' => 'Rekomendasi KIP Kuliah', 'kode_layanan' => 'KIP-KULIAH'],
            ['nama_layanan' => 'Bantuan Logistik Bencana', 'kode_layanan' => 'LOGISTIK-01'],
        ];

        foreach ($layanan as $l) {
            ServiceType::create($l);
        }
    }
}
