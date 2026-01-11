<?php

namespace App\Http\Controllers;

use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // [Tambahkan ini untuk fitur text processing]

class ServiceTypeController extends Controller
{
    public function index()
    {
        $services = ServiceType::all();
        return view('admin.applications.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        // 1. Validasi (Hapus 'kode_layanan' dari validasi karena akan digenerate sistem)
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'jenis_bantuan' => 'required|string', // Pastikan ini string (sesuai request sebelumnya)
        ]);

        // 2. Logika Generate Kode Otomatis
        // Ambil slug dari jenis bantuan, misal "Bantuan Tunai" -> "BANTUAN-TUNAI"
        $prefix = strtoupper(Str::slug($request->jenis_bantuan));

        // Jika prefix kosong (misal input simbol semua), beri default 'SRV'
        if (empty($prefix)) {
            $prefix = 'SRV';
        }

        // Cari nomor urut terakhir untuk prefix ini
        // Contoh logika: Cek database untuk kode yang berawalan "BANTUAN-TUNAI-"
        $count = ServiceType::where('kode_layanan', 'like', $prefix . '-%')->count();
        $nextNumber = $count + 1;

        // Format kode: PREFIX-001 (padding 3 digit angka)
        $generatedCode = $prefix . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // Cek duplikasi (looping untuk memastikan unik jika ada data yang dihapus sebelumnya)
        while (ServiceType::where('kode_layanan', $generatedCode)->exists()) {
            $nextNumber++;
            $generatedCode = $prefix . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        }

        // 3. Simpan Data
        ServiceType::create([
            'nama_layanan' => $request->nama_layanan,
            'jenis_bantuan' => $request->jenis_bantuan,
            'kode_layanan' => $generatedCode, // Masukkan kode otomatis
            'deskripsi' => $request->deskripsi ?? null, // Opsional jika ada kolom deskripsi
        ]);

        return back()->with('success', 'Layanan berhasil ditambahkan. Kode Sistem: ' . $generatedCode);
    }

    // ... method update dan destroy tetap sama (pastikan update tidak merubah kode jika tidak perlu)
    public function update(Request $request, ServiceType $service)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'jenis_bantuan' => 'required|string',
        ]);

        // Kode layanan sebaiknya tidak diubah saat update untuk menjaga konsistensi data
        $service->update($request->only(['nama_layanan', 'jenis_bantuan', 'deskripsi']));

        return back()->with('success', 'Data layanan berhasil diperbarui.');
    }

    public function destroy(ServiceType $service)
    {
        $service->delete();
        return back()->with('success', 'Layanan dihapus.');
    }
}
