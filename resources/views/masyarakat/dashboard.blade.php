@extends('layouts.sikasos')

@section('content')
    <!-- Welcome Section -->
    <div class="glass-card p-4 mb-4">
        <h2 class="text-white fw-bold mb-2">
            <i class="fas fa-hand-sparkles me-2"></i>Selamat Datang, {{ Auth::user()->name }}!
        </h2>
        <p class="text-white mb-0" style="opacity: 0.9;">
            Kelola pengajuan bantuan sosial Anda dengan mudah dan cepat
        </p>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="stat-card-glass">
                <div class="stat-icon-glass">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-value-glass">{{ $totalPengajuan }}</div>
                <div class="stat-label-glass">Total Pengajuan</div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stat-card-glass">
                <div class="stat-icon-glass">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-value-glass">{{ $pending }}</div>
                <div class="stat-label-glass">Menunggu Verifikasi</div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stat-card-glass">
                <div class="stat-icon-glass">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value-glass">{{ $approved }}</div>
                <div class="stat-label-glass">Disetujui</div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stat-card-glass">
                <div class="stat-icon-glass">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-value-glass">{{ $rejected }}</div>
                <div class="stat-label-glass">Ditolak</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="glass-card p-4 mb-4">
        <h5 class="text-white fw-bold mb-4">
            <i class="fas fa-bolt me-2"></i>Aksi Cepat
        </h5>
        <div class="d-flex gap-3 flex-wrap">
            <a href="{{ route('masyarakat.applications.create') }}" class="btn-glass btn-solid">
                <i class="fas fa-plus-circle"></i>
                <span>Ajukan Bantuan Baru</span>
            </a>
            <a href="{{ route('masyarakat.applications.index') }}" class="btn-glass">
                <i class="fas fa-list"></i>
                <span>Lihat Semua Pengajuan</span>
            </a>
            <a href="{{ route('tracking') }}" target="_blank" class="btn-glass">
                <i class="fas fa-search"></i>
                <span>Tracking Status</span>
            </a>
        </div>
    </div>

    <!-- Recent Applications -->
    <div class="content-card">
        <h5 class="fw-bold mb-4" style="color: #1e293b;">
            <i class="fas fa-history me-2" style="color: #667eea;"></i>Pengajuan Terbaru
        </h5>
        
        @if($recentApplications->count() > 0)
            <div class="table-responsive">
                <table class="table table-glass mb-0">
                    <thead>
                        <tr>
                            <th>Nomor Tiket</th>
                            <th>Jenis Layanan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentApplications as $app)
                            <tr>
                                <td>
                                    <strong style="color: #667eea;">{{ $app->nomor_tiket }}</strong>
                                </td>
                                <td>{{ $app->serviceType->nama_layanan }}</td>
                                <td>{{ $app->created_at->format('d M Y') }}</td>
                                <td>
                                    @if($app->status == 'pending')
                                        <span class="badge-glass" style="background: rgba(245, 158, 11, 0.2); color: #f59e0b;">
                                            <i class="fas fa-clock me-1"></i>Pending
                                        </span>
                                    @elseif($app->status == 'verified')
                                        <span class="badge-glass" style="background: rgba(59, 130, 246, 0.2); color: #3b82f6;">
                                            <i class="fas fa-check me-1"></i>Diverifikasi
                                        </span>
                                    @elseif($app->status == 'approved')
                                        <span class="badge-glass" style="background: rgba(16, 185, 129, 0.2); color: #10b981;">
                                            <i class="fas fa-check-circle me-1"></i>Disetujui
                                        </span>
                                    @elseif($app->status == 'rejected')
                                        <span class="badge-glass" style="background: rgba(239, 68, 68, 0.2); color: #ef4444;">
                                            <i class="fas fa-times-circle me-1"></i>Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('masyarakat.applications.show', $app->id) }}" 
                                       class="btn btn-sm btn-primary rounded-pill">
                                        <i class="fas fa-eye me-1"></i>Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-4x mb-3" style="color: #cbd5e1;"></i>
                <h5 style="color: #64748b;">Belum Ada Pengajuan</h5>
                <p class="text-muted mb-4">Anda belum memiliki pengajuan bantuan. Mulai ajukan sekarang!</p>
                <a href="{{ route('masyarakat.applications.create') }}" class="btn btn-primary btn-lg rounded-pill px-5">
                    <i class="fas fa-plus-circle me-2"></i>Ajukan Bantuan Baru
                </a>
            </div>
        @endif
    </div>
@endsection
