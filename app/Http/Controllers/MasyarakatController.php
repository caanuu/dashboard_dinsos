<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Resident;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MasyarakatController extends Controller
{
    /**
     * Dashboard Masyarakat
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Statistik pengajuan user
        $totalPengajuan = Application::where('user_id', $user->id)->count();
        $pending = Application::where('user_id', $user->id)->where('status', 'pending')->count();
        $approved = Application::where('user_id', $user->id)->where('status', 'approved')->count();
        $rejected = Application::where('user_id', $user->id)->where('status', 'rejected')->count();
        
        // Pengajuan terbaru
        $recentApplications = Application::where('user_id', $user->id)
            ->with(['serviceType', 'resident'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('masyarakat.dashboard', compact(
            'totalPengajuan', 
            'pending', 
            'approved', 
            'rejected', 
            'recentApplications'
        ));
    }

    /**
     * Daftar Pengajuan Saya
     */
    public function myApplications()
    {
        $user = Auth::user();
        
        $applications = Application::where('user_id', $user->id)
            ->with(['serviceType', 'resident'])
            ->latest()
            ->paginate(10);
        
        return view('masyarakat.applications.index', compact('applications'));
    }

    /**
     * Form Pengajuan Bantuan
     */
    public function createApplication()
    {
        $serviceTypes = ServiceType::all();
        
        // Ambil data resident berdasarkan nama user
        $resident = Resident::where('nama_lengkap', Auth::user()->name)->first();
        
        return view('masyarakat.applications.create', compact('serviceTypes', 'resident'));
    }

    /**
     * Simpan Pengajuan Bantuan
     */
    public function storeApplication(Request $request)
    {
        $validated = $request->validate([
            'service_type_id' => 'required|exists:service_types,id',
            'resident_id' => 'required|exists:residents,id',
            'file_ktp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Generate nomor tiket unik
        $nomorTiket = 'SIKASOS-' . date('Ymd') . '-' . strtoupper(Str::random(6));

        // Upload multiple files
        $fileKtp = null;
        $fileKk = null;
        $filePengantar = null;

        if ($request->hasFile('file_ktp')) {
            $fileKtp = $request->file('file_ktp')->store('applications/ktp', 'public');
        }
        
        if ($request->hasFile('file_kk')) {
            $fileKk = $request->file('file_kk')->store('applications/kk', 'public');
        }
        
        if ($request->hasFile('file_pendukung')) {
            $filePengantar = $request->file('file_pendukung')->store('applications/pengantar', 'public');
        }

        // Buat application
        $application = Application::create([
            'user_id' => Auth::id(),
            'resident_id' => $validated['resident_id'],
            'service_type_id' => $validated['service_type_id'],
            'nomor_tiket' => $nomorTiket,
            'file_persyaratan' => $fileKtp ?? $fileKk ?? $filePengantar, // Fallback untuk compatibility
            'file_ktp' => $fileKtp,
            'file_kk' => $fileKk,
            'file_pengantar' => $filePengantar,
            'status' => 'pending',
            'skor_kelayakan' => 0,
            'validasi_dukcapil' => false,
        ]);

        return redirect()->route('masyarakat.applications.show', $application->id)
            ->with('success', 'Pengajuan berhasil dibuat dengan nomor tiket: ' . $nomorTiket);
    }

    /**
     * Detail Pengajuan & Tracking Status
     */
    public function showApplication($id)
    {
        $application = Application::with(['serviceType', 'resident', 'logs.user', 'distribution'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);
        
        return view('masyarakat.applications.show', compact('application'));
    }

    /**
     * Halaman Profil Masyarakat
     */
    public function profile()
    {
        $user = Auth::user();
        $resident = Resident::where('nama_lengkap', $user->name)->first();
        
        return view('masyarakat.profile', compact('user', 'resident'));
    }

    /**
     * Update Profil Masyarakat
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'pekerjaan' => 'nullable|string',
            'penghasilan' => 'nullable|numeric',
            'jumlah_tanggungan' => 'nullable|integer',
        ]);

        // Update user
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Update resident
        $resident = Resident::where('nama_lengkap', $user->name)->first();
        if ($resident) {
            $resident->update([
                'nama_lengkap' => $validated['name'],
                'no_hp' => $validated['no_hp'],
                'alamat' => $validated['alamat'],
                'pekerjaan' => $validated['pekerjaan'] ?? $resident->pekerjaan,
                'penghasilan' => $validated['penghasilan'] ?? $resident->penghasilan,
                'jumlah_tanggungan' => $validated['jumlah_tanggungan'] ?? $resident->jumlah_tanggungan,
            ]);
        }

        return redirect()->route('masyarakat.profile')->with('success', 'Profil berhasil diupdate!');
    }
}
