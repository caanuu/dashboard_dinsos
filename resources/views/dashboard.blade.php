@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        <h3 class="fw-bold text-dark">Dashboard Overview</h3>
        <p class="text-muted">Selamat datang kembali, {{ Auth::user()->name }}!</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Total Permohonan</p>
                            <h2 class="mb-0 fw-bold text-dark">{{ $stats['total'] }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                            <i class="fas fa-folder-open fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Menunggu Verifikasi</p>
                            <h2 class="mb-0 fw-bold text-dark">{{ $stats['pending'] }}</h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning">
                            <i class="fas fa-clock fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Disetujui</p>
                            <h2 class="mb-0 fw-bold text-dark">{{ $stats['approved'] }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                            <i class="fas fa-check-circle fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Ditolak</p>
                            <h2 class="mb-0 fw-bold text-dark">{{ $stats['rejected'] }}</h2>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle text-danger">
                            <i class="fas fa-times-circle fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold mb-0"><i class="fas fa-history me-2 text-primary"></i> Aktivitas Terakhir</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach ($stats['recent_logs'] as $log)
                            <div class="list-group-item px-4 py-3">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 fw-bold text-dark">{{ $log->action }}</h6>
                                    <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1 small">
                                    Oleh <span class="fw-bold">{{ $log->user->name }}</span>
                                    pada permohonan <span
                                        class="badge bg-light text-dark border">{{ $log->application->nomor_tiket ?? '-' }}</span>
                                </p>
                                @if ($log->catatan)
                                    <small class="text-danger fst-italic">"{{ Str::limit($log->catatan, 50) }}"</small>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer bg-white border-0 text-center py-3">
                    <a href="{{ route('admin.application.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua
                        Permohonan</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body p-4">
                    <h5 class="fw-bold"><i class="fas fa-bullhorn me-2"></i> Info Sistem</h5>
                    <p class="small opacity-75 mt-3">
                        Pastikan memverifikasi NIK pemohon melalui integrasi DTKS sebelum menyetujui permohonan bantuan.
                    </p>
                    <hr class="border-white opacity-25">
                    <div class="d-grid gap-2">
                        <button class="btn btn-light text-primary fw-bold btn-sm">
                            <i class="fas fa-book me-1"></i> Panduan Operator
                        </button>
                        <button class="btn btn-outline-light btn-sm">
                            <i class="fas fa-download me-1"></i> Download Rekap Bulanan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
