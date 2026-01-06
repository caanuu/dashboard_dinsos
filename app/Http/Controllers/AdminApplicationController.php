<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // PENTING: Untuk membatasi teks (Str::limit)
use Barryvdh\DomPDF\Facade\Pdf; // PENTING: Gunakan Facade PDF yang benar
use Yajra\DataTables\Facades\DataTables; // PENTING: Gunakan Facade DataTables

class AdminApplicationController extends Controller
{
    /**
     * Menampilkan Halaman Dashboard Statistik
     */
    public function dashboard()
    {
        // Statistik Utama
        $stats = [
            'total' => Application::count(),
            'pending' => Application::where('status', 'pending')->count(),
            'verified' => Application::where('status', 'verified')->count(),
            'approved' => Application::where('status', 'approved')->count(),
            'rejected' => Application::where('status', 'rejected')->count(),

            // Mengambil 5 aktivitas terbaru untuk timeline
            'recent_logs' => ApplicationLog::with(['user', 'application.resident'])
                ->latest()
                ->limit(5)
                ->get()
        ];

        return view('dashboard', compact('stats'));
    }

    /**
     * Menampilkan Daftar Permohonan (DataTables JSON & View)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Menggunakan 'with' untuk Eager Loading agar query cepat
            $data = Application::with(['resident', 'serviceType'])->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('admin.application.show', $row->id) . '" class="btn btn-primary btn-sm shadow-sm"><i class="fas fa-eye"></i> Detail</a>';
                    return $btn;
                })
                ->addColumn('status_label', function ($row) {
                    // Menggunakan accessor getStatusColorAttribute dari Model
                    $color = $row->status_color ?? 'secondary';
                    return '<span class="badge bg-' . $color . ' text-uppercase">' . $row->status . '</span>';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d/m/Y H:i');
                })
                ->rawColumns(['action', 'status_label'])
                ->make(true);
        }
        return view('admin.applications.index');
    }

    /**
     * Menampilkan Detail Permohonan
     */
    public function show($id)
    {
        // Ambil data beserta log history-nya
        $application = Application::with(['resident', 'serviceType', 'logs.user'])->findOrFail($id);
        return view('admin.applications.show', compact('application'));
    }

    /**
     * Memproses Status (Verifikasi / Setuju / Tolak)
     */
    public function process(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:verify,approve,reject',
            'catatan' => 'required_if:action,reject'
        ]);

        $app = Application::findOrFail($id);
        $user = Auth::user();

        // Gunakan Transaction agar data aman
        DB::transaction(function () use ($app, $request, $user) {
            $newStatus = $app->status;
            $logAction = '';

            // Logika Status Berjenjang
            if ($request->action == 'verify') {
                $newStatus = 'verified';
                $logAction = 'MEMVERIFIKASI BERKAS';
            } elseif ($request->action == 'approve') {
                $newStatus = 'approved';
                $logAction = 'MENYETUJUI PERMOHONAN';
            } elseif ($request->action == 'reject') {
                $newStatus = 'rejected';
                $logAction = 'MENOLAK PERMOHONAN';
            }

            // Update Data Aplikasi
            $app->update([
                'status' => $newStatus,
                'keterangan_tolak' => $request->action == 'reject' ? $request->catatan : null
            ]);

            // Catat Log (Audit Trail)
            ApplicationLog::create([
                'application_id' => $app->id,
                'user_id' => $user->id,
                'action' => $logAction,
                'catatan' => $request->catatan ?? '-'
            ]);
        });

        return redirect()->back()->with('success', 'Status permohonan berhasil diperbarui.');
    }

    /**
     * Cetak Surat PDF
     */
    public function printLetter($id)
    {
        $app = Application::with(['resident', 'serviceType'])->findOrFail($id);

        if ($app->status != 'approved') {
            abort(403, 'Permohonan belum disetujui, surat tidak dapat dicetak.');
        }

        // Load View PDF
        $pdf = Pdf::loadView('admin.applications.pdf.letter_template', compact('app'));

        // Setup Ukuran Kertas F4/A4
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Surat_Rekomendasi_' . $app->nomor_tiket . '.pdf');
    }
}
