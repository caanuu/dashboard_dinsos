<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceType;
use App\Models\Application;
use App\Models\Resident;
use App\Models\ApplicationLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WargaController extends Controller
{
    // Dashboard Warga: Menampilkan PROFIL & Riwayat (di halaman.blade.php)
    public function index()
    {
        $user = Auth::user();

        // Cari Resident berdasarkan NIK User untuk ditampilkan di Profil
        $resident = Resident::where('nik', $user->nik)->first();

        $applications = [];
        $stats = ['total' => 0, 'pending' => 0, 'approved' => 0];

        if ($resident) {
            $applications = Application::with('serviceType')
                ->where('resident_id', $resident->id)
                ->latest()
                ->get();

            $stats['total'] = $applications->count();
            $stats['pending'] = $applications->whereIn('status', ['pending', 'verified'])->count();
            $stats['approved'] = $applications->whereIn('status', ['approved', 'distributed'])->count();
        }

        // Return ke view 'halaman' sesuai permintaan
        return view('halaman', compact('user', 'resident', 'applications', 'stats'));
    }

    // Form Pengajuan Baru
    public function create()
    {
        $user = Auth::user();
        $resident = Resident::where('nik', $user->nik)->first();
        $services = ServiceType::all();

        return view('warga.create', compact('user', 'resident', 'services'));
    }

    // Simpan Permohonan Warga (Tidak berubah)
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'service_type_id' => 'required|exists:service_types,id',
            'nama_lengkap' => 'required|string',
            'no_kk' => 'required|numeric|digits:16',
            'alamat' => 'required|string',
            'penghasilan' => 'required|numeric',
            'jumlah_tanggungan' => 'required|numeric',
            'file_proposal' => 'required|file|mimes:pdf|max:5120',
            'foto_ktp' => 'required|image|max:2048',
            'foto_kk' => 'required|image|max:2048',
            'foto_pengantar' => 'required|image|max:2048',
        ]);

        $isDuplicate = Application::whereHas('resident', function ($q) use ($user) {
            $q->where('nik', $user->nik);
        })->where('service_type_id', $request->service_type_id)
            ->whereIn('status', ['pending', 'verified', 'approved'])
            ->exists();

        if ($isDuplicate) {
            return back()->with('error', 'Anda sudah mengajukan layanan ini dan sedang diproses.');
        }

        DB::transaction(function () use ($request, $user) {
            $pathProposal = $request->file('file_proposal')->store('dokumen/proposal', 'public');
            $pathKtp = $request->file('foto_ktp')->store('dokumen/ktp', 'public');
            $pathKk = $request->file('foto_kk')->store('dokumen/kk', 'public');
            $pathPengantar = $request->file('foto_pengantar')->store('dokumen/pengantar', 'public');

            $resident = Resident::updateOrCreate(
                ['nik' => $user->nik],
                [
                    'no_kk' => $request->no_kk,
                    'nama_lengkap' => $request->nama_lengkap,
                    'alamat' => $request->alamat,
                    'pekerjaan' => $request->pekerjaan,
                    'no_hp' => $user->no_hp,
                    'penghasilan' => $request->penghasilan,
                    'jumlah_tanggungan' => $request->jumlah_tanggungan,
                    'is_dtks' => $request->has('is_dtks'),
                ]
            );

            $skor = 0;
            if ($resident->is_dtks)
                $skor += 50;
            if ($resident->penghasilan <= 1000000)
                $skor += 30;

            $service = ServiceType::find($request->service_type_id);
            $tiket = $service->kode_layanan . '-' . date('ym') . '-' . rand(1000, 9999);

            $app = Application::create([
                'resident_id' => $resident->id,
                'service_type_id' => $service->id,
                'nomor_tiket' => $tiket,
                'file_persyaratan' => $pathProposal,
                'file_ktp' => $pathKtp,
                'file_kk' => $pathKk,
                'file_pengantar' => $pathPengantar,
                'status' => 'pending',
                'skor_kelayakan' => $skor,
                'is_online' => 1,
            ]);

            ApplicationLog::create([
                'application_id' => $app->id,
                'user_id' => $user->id,
                'action' => 'SUBMIT USER',
                'catatan' => "Diajukan melalui Dashboard Warga."
            ]);
        });

        // Redirect kembali ke halaman profil/dashboard
        return redirect()->route('warga.dashboard')->with('success', 'Permohonan berhasil dikirim!');
    }
}
