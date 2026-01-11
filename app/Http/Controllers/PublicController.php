<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\ServiceType;
use App\Models\Resident;
use App\Models\ApplicationLog;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PublicController extends Controller
{
    // 1. HALAMAN DEPAN (LANDING PAGE)
    public function index()
    {
        // Ambil Data Statistik Real-time
        $stats = [
            'total_masuk' => Application::count(),
            'tersalurkan' => Application::where('status', 'distributed')->count(),
            'diproses' => Application::whereIn('status', ['pending', 'verified', 'approved'])->count(),
        ];

        // Ambil Daftar Layanan yang tersedia di Database
        $services = ServiceType::all();

        return view('welcome', compact('stats', 'services'));
    }

    // --- FITUR BARU: PERMOHONAN ONLINE ---

    // 2. Halaman Form Pengajuan Online
    public function createApplication()
    {
        $services = ServiceType::all();
        return view('public_create', compact('services'));
    }

    // 3. Proses Simpan Permohonan Online (DIPERBARUI)
    public function storeApplication(Request $request)
    {
        // 1. Validasi Input (Diperbarui untuk Multiple Files)
        $request->validate([
            'nik' => 'required|numeric|digits:16',
            'no_kk' => 'required|numeric|digits:16',
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'required|string',
            'service_type_id' => 'required|exists:service_types,id',
            'penghasilan' => 'required|numeric',
            'jumlah_tanggungan' => 'required|numeric',

            // Validasi Khusus File
            'file_proposal' => 'required|file|mimes:pdf|max:5120', // PDF Maks 5MB
            'foto_ktp' => 'required|image|max:2048', // JPG/PNG Maks 2MB
            'foto_kk' => 'required|image|max:2048',
            'foto_pengantar' => 'required|image|max:2048',
        ]);

        // 2. Cek Duplikasi Permohonan (Agar tidak spam)
        $isDuplicate = Application::whereHas('resident', function ($q) use ($request) {
            $q->where('nik', $request->nik);
        })->where('service_type_id', $request->service_type_id)
            ->whereIn('status', ['pending', 'verified', 'approved'])
            ->exists();

        if ($isDuplicate) {
            return back()->with('error', 'GAGAL: Anda sudah memiliki permohonan aktif untuk layanan ini.');
        }

        $tiket = null;

        DB::transaction(function () use ($request, &$tiket) {
            // A. Upload File ke Folder Terpisah
            $pathProposal = $request->file('file_proposal')->store('dokumen/proposal', 'public');
            $pathKtp = $request->file('foto_ktp')->store('dokumen/ktp', 'public');
            $pathKk = $request->file('foto_kk')->store('dokumen/kk', 'public');
            $pathPengantar = $request->file('foto_pengantar')->store('dokumen/pengantar', 'public');

            // B. Simpan/Update Data Penduduk (Resident)
            $resident = Resident::updateOrCreate(
                ['nik' => $request->nik],
                [
                    'no_kk' => $request->no_kk,
                    'nama_lengkap' => $request->nama_lengkap,
                    'alamat' => $request->alamat,
                    'pekerjaan' => $request->pekerjaan,
                    'penghasilan' => $request->penghasilan,
                    'jumlah_tanggungan' => $request->jumlah_tanggungan,
                    'is_dtks' => $request->has('is_dtks'),
                ]
            );

            // C. Hitung Skor Kelayakan Sederhana
            $skor = 0;
            if ($resident->is_dtks)
                $skor += 50;
            if ($resident->penghasilan <= 1000000)
                $skor += 30;
            elseif ($resident->penghasilan <= 2500000)
                $skor += 10;
            if ($resident->jumlah_tanggungan >= 3)
                $skor += 10;

            // D. Generate Nomor Tiket
            $service = ServiceType::find($request->service_type_id);
            $tiket = $service->kode_layanan . '-' . date('ym') . '-' . rand(1000, 9999);

            // E. Simpan Aplikasi Baru (Mapping ke Kolom Database Baru)
            $app = Application::create([
                'resident_id' => $resident->id,
                'service_type_id' => $service->id,
                'nomor_tiket' => $tiket,

                // Simpan Path File
                'file_persyaratan' => $pathProposal, // PDF Proposal masuk ke sini
                'file_ktp' => $pathKtp,
                'file_kk' => $pathKk,
                'file_pengantar' => $pathPengantar,

                'status' => 'pending',
                'skor_kelayakan' => $skor,
                'validasi_dukcapil' => false,
                'is_online' => 1, // Menandakan ini inputan dari Website
            ]);

            // F. Catat Log Sistem
            ApplicationLog::create([
                'application_id' => $app->id,
                'user_id' => 1, // ID default (Admin Utama)
                'action' => 'SUBMIT ONLINE',
                'catatan' => "Permohonan mandiri via Website. Dokumen lengkap & terlampir."
            ]);
        });

        return redirect()->route('tracking', ['keyword' => $tiket])
            ->with('success', "Permohonan Berhasil! Nomor Tiket Anda: $tiket. Harap Simpan Nomor Ini.");
    }

    // 4. Halaman Cek Resi (Tracking)
    public function tracking(Request $request)
    {
        $result = null;
        if ($request->has('keyword')) {
            $keyword = $request->keyword;
            $result = Application::with(['resident', 'serviceType', 'logs'])
                ->where('nomor_tiket', $keyword)
                ->first();
        }
        return view('tracking', compact('result'));
    }

    // 5. Halaman Form Lapor
    public function lapor()
    {
        return view('lapor');
    }

    // 6. Proses Simpan Laporan/Pengaduan
    public function storeLapor(Request $request)
    {
        $request->validate([
            'nama_pelapor' => 'required|string|max:100',
            'nik_pelapor' => 'nullable|numeric',
            'isi_aduan' => 'required|string|min:10',
        ]);

        $tiket = 'ADUAN-' . date('ymd') . '-' . rand(100, 999);

        DB::table('complaints')->insert([
            'tiket_pengaduan' => $tiket,
            'nama_pelapor' => $request->nama_pelapor,
            'nik_pelapor' => $request->nik_pelapor,
            'isi_aduan' => $request->isi_aduan,
            'status' => 'masuk',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', "Laporan berhasil dikirim. Tiket: $tiket");
    }
}
