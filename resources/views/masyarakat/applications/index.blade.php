@extends('layouts.sikasos')

@section('content')
    <!-- Page Header -->
    <div class="glass-card p-4 mb-4">
        <h2 class="text-white fw-bold mb-2">
            <i class="fas fa-list me-2"></i>Daftar Pengajuan Saya
        </h2>
        <p class="text-white mb-0" style="opacity: 0.9;">
            Semua pengajuan bantuan yang pernah Anda ajukan
        </p>
    </div>

    <!-- Applications List -->
    @if($applications->count() > 0)
        <div class="content-card">
            <div class="table-responsive">
                <table class="table table-glass mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Tiket</th>
                            <th>Jenis Layanan</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $index => $app)
                            <tr>
                                <td>{{ $applications->firstItem() + $index }}</td>
                                <td><strong style="color: #667eea;">{{ $app->nomor_tiket }}</strong></td>
                                <td>{{ $app->serviceType->nama_layanan }}</td>
                                <td>{{ $app->created_at->format('d M Y H:i') }}</td>
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
                                    <a href="{{ route('masyarakat.applications.show', $app->id) }}" class="btn btn-sm btn-primary rounded-pill">
                                        <i class="fas fa-eye me-1"></i>Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $applications->links() }}
            </div>
        </div>
    @else
        <div class="content-card text-center py-5">
            <i class="fas fa-inbox fa-4x mb-3" style="color: #cbd5e1;"></i>
            <h5 style="color: #64748b;">Belum Ada Pengajuan</h5>
            <p class="text-muted mb-4">
                Anda belum memiliki pengajuan. 
                <a href="{{ route('masyarakat.applications.create') }}" class="text-primary">Klik di sini</a> untuk mengajukan bantuan.
            </p>
            <a href="{{ route('masyarakat.applications.create') }}" class="btn btn-primary btn-lg rounded-pill px-5">
                <i class="fas fa-plus-circle me-2"></i>Ajukan Bantuan Baru
            </a>
        </div>
    @endif
@endsection
