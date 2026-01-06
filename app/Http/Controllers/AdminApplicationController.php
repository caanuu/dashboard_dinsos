<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;

class AdminApplicationController extends Controller
{
    // 1. Menampilkan Daftar Permohonan (Datatables)
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Application::with(['resident', 'serviceType'])->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="/admin/application/'.$row->id.'" class="btn btn-primary btn-sm">Detail & Proses</a>';
                    return $btn;
                })
                ->addColumn('status_label', function($row){
                    return '<span class="badge bg-'.$row->status_color.'">'.strtoupper($row->status).'</span>';
                })
                ->rawColumns(['action', 'status_label'])
                ->make(true);
        }
        return view('admin.applications.index');
    }

    // 2. Halaman Detail & Verifikasi
    public function show($id)
    {
        $application = Application::with('logs.user')->findOrFail($id);
        return view('admin.applications.show', compact('application'));
    }

    // 3. LOGIKA UTAMA: Proses Status (Approve/Reject/Verifikasi)
    // Menggunakan DB Transaction agar data aman
    public function process(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:verify,approve,reject',
            'catatan' => 'required_if:action,reject'
        ]);

        $app = Application::findOrFail($id);
        $user = Auth::user();

        DB::transaction(function () use ($app, $request, $user) {
            $newStatus = $app->status;
            $logAction = '';

            // Logika State Machine Sederhana
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

            // Update Status
            $app->update([
                'status' => $newStatus,
                'keterangan_tolak' => $request->action == 'reject' ? $request->catatan : null
            ]);

            // Catat Log (Penting untuk Laporan: Transparansi)
            ApplicationLog::create([
                'application_id' => $app->id,
                'user_id' => $user->id,
                'action' => $logAction,
                'catatan' => $request->catatan
            ]);
        });

        return redirect()->back()->with('success', 'Status permohonan berhasil diperbarui.');
    }

    // 4. Cetak Surat Otomatis (Hanya jika Approved)
    public function printLetter($id)
    {
        $app = Application::findOrFail($id);

        if($app->status != 'approved') {
            abort(403, 'Permohonan belum disetujui');
        }

        $pdf = PDF::loadView('admin.pdf.letter_template', compact('app'));
        return $pdf->stream('Surat_Rekomendasi_'.$app->nomor_tiket.'.pdf');
    }
}
