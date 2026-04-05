<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Application;
use App\Models\ApplicationLog;
use App\Models\Resident;
use App\Models\ServiceType;
use App\Models\User;

class AdminApplicationController extends Controller
{
    // 1. DASHBOARD MONEV
    public function dashboard()
    {
        $stats = [
            'total' => Application::count(),
            'pending' => Application::where('status', 'pending')->count(),
            'verified' => Application::where('status', 'verified')->count(),
            'approved' => Application::where('status', 'approved')->count(),
            'rejected' => Application::where('status', 'rejected')->count(),
            'recent_logs' => ApplicationLog::with(['user', 'application'])->latest()->limit(5)->get(),
            'total_aduan' => DB::table('complaints')->count(),
            'aduan_baru' => DB::table('complaints')->where('status', 'masuk')->count(),
            'recent_complaints' => DB::table('complaints')->orderBy('created_at', 'desc')->limit(5)->get()
        ];

        // LOGIC GRAFIK
        $chartData = array_fill(1, 12, 0);
        $monthlyData = Application::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        foreach ($monthlyData as $bulan => $total) {
            $chartData[$bulan] = $total;
        }

        // LOGIC GRAFIK PIE
        $statusRaw = Application::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $statusData = [
            $statusRaw['pending'] ?? 0,
            $statusRaw['verified'] ?? 0,
            $statusRaw['approved'] ?? 0,
            $statusRaw['rejected'] ?? 0,
            $statusRaw['distributed'] ?? 0,
        ];

        // LOGIC GRAFIK BAR - JENIS LAYANAN
        $serviceRaw = Application::join('service_types', 'applications.service_type_id', '=', 'service_types.id')
            ->selectRaw('service_types.nama_layanan, COUNT(*) as total')
            ->groupBy('service_types.id', 'service_types.nama_layanan')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        $serviceLabels = $serviceRaw->pluck('nama_layanan')->toArray();
        $serviceData = $serviceRaw->pluck('total')->toArray();

        return view('dashboard', compact('stats', 'chartData', 'statusData', 'serviceLabels', 'serviceData'));
    }

    // 2. HALAMAN LIST (INDEX)
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Application::with(['resident', 'serviceType'])
                ->select('applications.*')
                ->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('admin.application.show', $row->id) . '" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-eye me-1"></i>Detail</a>';
                })
                ->addColumn('status_label', function ($row) {
                    $color = match ($row->status) {
                        'pending' => 'warning',
                        'verified' => 'info',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'distributed' => 'success',
                        default => 'secondary',
                    };
                    return '<span class="badge bg-' . $color . '">' . strtoupper($row->status) . '</span>';
                })
                ->addColumn('skor', function ($row) {
                    $badge = $row->skor_kelayakan > 70 ? 'success' : ($row->skor_kelayakan > 40 ? 'warning' : 'danger');
                    return '<span class="badge bg-' . $badge . '">Skor: ' . $row->skor_kelayakan . '</span>';
                })
                ->addColumn('source', function ($row) {
                    if ($row->is_online == 1) {
                        return '<span class="badge bg-info text-dark"><i class="fas fa-globe me-1"></i> WEB</span>';
                    } else {
                        return '<span class="badge bg-secondary"><i class="fas fa-store me-1"></i> LOKET</span>';
                    }
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d/m/Y H:i');
                })
                ->rawColumns(['action', 'status_label', 'skor', 'source'])
                ->make(true);
        }
        return view('admin.applications.index');
    }

    // 3. FORM INPUT
    public function create()
    {
        $services = ServiceType::all();
        return view('admin.applications.create', compact('services'));
    }

    // 4. PROSES SIMPAN (STORE)
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|numeric|digits:16',
            'no_kk' => 'required|numeric|digits:16',
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'required|string',
            'service_type_id' => 'required|exists:service_types,id',
            'berkas' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'penghasilan' => 'required|numeric',
            'jumlah_tanggungan' => 'required|numeric',
        ]);

        $isDuplicate = Application::whereHas('resident', function ($q) use ($request) {
            $q->where('nik', $request->nik);
        })->where('service_type_id', $request->service_type_id)
            ->whereIn('status', ['pending', 'verified', 'approved'])
            ->exists();

        if ($isDuplicate) {
            return back()->with('error', 'GAGAL: Penduduk ini sedang memiliki permohonan aktif untuk layanan tersebut.');
        }

        DB::transaction(function () use ($request) {
            $filePath = $request->file('berkas')->store('persyaratan', 'public');

            $resident = Resident::updateOrCreate(
                ['nik' => $request->nik],
                [
                    'no_kk' => $request->no_kk,
                    'nama_lengkap' => $request->nama_lengkap,
                    'alamat' => $request->alamat,
                    'pekerjaan' => $request->pekerjaan,
                    'no_hp' => $request->no_hp ?? null,
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
            elseif ($resident->penghasilan <= 2500000)
                $skor += 10;
            if ($resident->jumlah_tanggungan >= 4)
                $skor += 20;
            elseif ($resident->jumlah_tanggungan >= 2)
                $skor += 10;

            $service = ServiceType::find($request->service_type_id);
            $tiket = $service->kode_layanan . '-' . date('ym') . '-' . rand(1000, 9999);
            $validasiDukcapil = (substr($request->nik, 0, 2) == '12');

            $app = Application::create([
                'resident_id' => $resident->id,
                'service_type_id' => $service->id,
                'nomor_tiket' => $tiket,
                'file_persyaratan' => $filePath,
                'status' => 'pending',
                'skor_kelayakan' => $skor,
                'validasi_dukcapil' => $validasiDukcapil,
                'is_online' => 0
            ]);

            ApplicationLog::create([
                'application_id' => $app->id,
                'user_id' => Auth::id(),
                'action' => 'INPUT PERMOHONAN',
                'catatan' => "Input Baru (Loket). Skor Sistem: {$skor}"
            ]);
        });

        return redirect()->route('admin.application.index')->with('success', 'Permohonan berhasil disimpan.');
    }

    // 5. HALAMAN DETAIL (SHOW)
    public function show($id)
    {
        $application = Application::with(['resident', 'serviceType', 'logs.user', 'distribution'])->findOrFail($id);
        return view('admin.applications.show', compact('application'));
    }

    // 6. PROSES VERIFIKASI/APPROVE (BAGIAN YANG DIPERBAIKI)
    public function process(Request $request, $id)
    {
        $app = Application::findOrFail($id);

        /** @var \App\Models\User $user */ // <-- PERBAIKAN: Memberitahu sistem tipe variabel $user
        $user = Auth::user();

        // Cek permission manual
        if ($request->action == 'approve') {
            if (!$user || !$user->hasRole('kadis')) {
                return back()->with('error', 'Hanya Kepala Dinas yang boleh menyetujui.');
            }
        }

        DB::transaction(function () use ($app, $request, $user) {
            $newStatus = match ($request->action) {
                'verify' => 'verified',
                'approve' => 'approved',
                'reject' => 'rejected',
                default => $app->status
            };

            $app->update([
                'status' => $newStatus,
                'keterangan_tolak' => $request->action == 'reject' ? $request->catatan : null
            ]);

            ApplicationLog::create([
                'application_id' => $app->id,
                'user_id' => $user->id,
                'action' => strtoupper($request->action),
                'catatan' => $request->catatan
            ]);
        });

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    // 7. CETAK SURAT
    public function printLetter($id)
    {
        $app = Application::with(['resident', 'serviceType'])->findOrFail($id);
        if ($app->status != 'approved')
            abort(403);

        $pdf = Pdf::loadView('admin.applications.pdf.letter_template', compact('app'));
        return $pdf->stream('Surat_' . $app->nomor_tiket . '.pdf');
    }

    // 8. EXPORT LAPORAN PDF
    public function exportPdf(Request $request)
    {
        $query = Application::with(['resident', 'serviceType']);

        // Filter berdasarkan tanggal jika ada
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $applications = $query->latest()->get();

        $pdf = Pdf::loadView('admin.reports.pdf', compact('applications'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan_Permohonan_' . date('Y-m-d') . '.pdf');
    }

    // 9. EXPORT LAPORAN EXCEL
    public function exportExcel(Request $request)
    {
        $query = Application::with(['resident', 'serviceType']);

        // Filter berdasarkan tanggal jika ada
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $applications = $query->latest()->get();

        // Buat CSV sederhana
        $filename = 'Laporan_Permohonan_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($applications) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'No',
                'Nomor Tiket',
                'Nama Pemohon',
                'NIK',
                'Jenis Layanan',
                'Status',
                'Tanggal Pengajuan',
                'Skor Kelayakan'
            ]);

            // Data
            $no = 1;
            foreach ($applications as $app) {
                fputcsv($file, [
                    $no++,
                    $app->nomor_tiket,
                    $app->resident->nama_lengkap,
                    $app->resident->nik,
                    $app->serviceType->nama_layanan,
                    strtoupper($app->status),
                    $app->created_at->format('d/m/Y H:i'),
                    $app->skor_kelayakan
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
