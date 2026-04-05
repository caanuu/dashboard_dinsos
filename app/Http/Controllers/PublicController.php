<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\ServiceType;

class PublicController extends Controller
{
    /**
     * Halaman Landing Page (Welcome)
     * Menampilkan statistik dan daftar layanan
     */
    public function index()
    {
        // Ambil Data Statistik Real-time
        $stats = [
            'total_masuk' => Application::count(),
            'tersalurkan' => Application::where('status', 'distributed')->count(),
            'diproses' => Application::whereIn('status', ['pending', 'verified', 'approved'])->count(),
        ];

        // Ambil Daftar Layanan yang tersedia
        $services = ServiceType::all();

        return view('welcome', compact('stats', 'services'));
    }

    /**
     * Halaman Tracking Status Pengajuan
     * Masyarakat bisa cek status dengan nomor tiket
     */
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
}
