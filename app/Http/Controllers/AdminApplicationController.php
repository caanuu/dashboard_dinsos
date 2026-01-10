<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Penting untuk file
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

// Import Model
use App\Models\Application;
use App\Models\ApplicationLog;
use App\Models\Resident;
use App\Models\ServiceType;
use App\Models\User;

class AdminApplicationController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total' => Application::count(),
            'pending' => Application::where('status', 'pending')->count(),
            'verified' => Application::where('status', 'verified')->count(),
            'approved' => Application::where('status', 'approved')->count(),
            'rejected' => Application::where('status', 'rejected')->count(),
            'recent_logs' => ApplicationLog::with(['user', 'application'])->latest()->limit(5)->get()
        ];
        return view('dashboard', compact('stats'));
    }

    public function create()
    {
        $services = ServiceType::all();
        return view('admin.applications.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|numeric|digits:16',
            'no_kk' => 'required|numeric|digits:16',
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'required|string',
            'service_type_id' => 'required|exists:service_types,id',
            // Validasi File (Max 2MB, PDF/JPG/PNG)
            'berkas' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Upload File
            $filePath = null;
            if ($request->hasFile('berkas')) {
                // Simpan di folder: storage/app/public/persyaratan
                $filePath = $request->file('berkas')->store('persyaratan', 'public');
            }

            // 2. Data Penduduk
            $resident = Resident::updateOrCreate(
                ['nik' => $request->nik],
                [
                    'no_kk' => $request->no_kk,
                    'nama_lengkap' => $request->nama_lengkap,
                    'alamat' => $request->alamat,
                    'pekerjaan' => $request->pekerjaan,
                    'is_dtks' => $request->has('is_dtks') ? true : false, // Checkbox DTKS
                ]
            );

            // 3. Nomor Tiket
            $service = ServiceType::find($request->service_type_id);
            $tiket = $service->kode_layanan . '-' . date('ym') . '-' . rand(1000, 9999);

            // 4. Simpan Aplikasi
            $app = Application::create([
                'resident_id' => $resident->id,
                'service_type_id' => $service->id,
                'nomor_tiket' => $tiket,
                'file_persyaratan' => $filePath, // Simpan Path
                'status' => 'pending'
            ]);

            // 5. Log
            ApplicationLog::create([
                'application_id' => $app->id,
                'user_id' => Auth::id(),
                'action' => 'INPUT PERMOHONAN',
                'catatan' => 'Input baru dengan berkas persyaratan.'
            ]);
        });

        return redirect()->route('admin.application.index')->with('success', 'Permohonan berhasil dikirim.');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Application::with(['resident', 'serviceType'])->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('admin.application.show', $row->id) . '" class="btn btn-sm btn-primary shadow-sm">Detail</a>';
                })
                ->addColumn('status_label', function ($row) {
                    return '<span class="badge bg-' . $row->status_color . '">' . strtoupper($row->status) . '</span>';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d/m/Y H:i');
                })
                ->rawColumns(['action', 'status_label'])
                ->make(true);
        }
        return view('admin.applications.index');
    }

    public function show($id)
    {
        $application = Application::with(['resident', 'serviceType', 'logs.user'])->findOrFail($id);
        return view('admin.applications.show', compact('application'));
    }

    public function process(Request $request, $id)
    {
        $app = Application::findOrFail($id);
        /** @var User $user */
        $user = Auth::user();

        if ($request->action == 'approve' && !$user->hasRole('kadis')) {
            return back()->with('error', 'Hanya Kepala Dinas yang boleh menyetujui.');
        }
        if ($request->action == 'verify' && !$user->hasRole(['operator', 'admin'])) {
            return back()->with('error', 'Hanya Operator yang boleh memverifikasi.');
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

    public function printLetter($id)
    {
        $app = Application::with(['resident', 'serviceType'])->findOrFail($id);
        if ($app->status != 'approved') abort(403);

        $pdf = Pdf::loadView('admin.applications.pdf.letter_template', compact('app'));
        return $pdf->stream('Surat_' . $app->nomor_tiket . '.pdf');
    }
}
