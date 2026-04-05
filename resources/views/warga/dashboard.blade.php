@extends('layouts.admin') {{-- Menggunakan layout admin tapi disesuaikan kontennya --}}

@section('title', 'Dashboard Warga')

@section('content')
    <div class="row">
        {{-- STATISTIK SINGKAT --}}
        <div class="col-md-12 mb-4">
            <div class="card border-0 bg-primary text-white shadow-sm"
                style="background: linear-gradient(45deg, #0d6efd, #0a58ca);">
                <div class="card-body p-4">
                    <h4 class="fw-bold">Halo, {{ $user->name }}!</h4>
                    <p class="mb-0 opacity-75">Selamat datang di layanan mandiri. NIK: {{ $user->nik }}</p>
                </div>
            </div>
        </div>

        {{-- KARTU STATUS --}}
        <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <h1 class="fw-bold text-primary">{{ $stats['total'] }}</h1>
                    <small class="text-muted">Total Pengajuan</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <h1 class="fw-bold text-warning">{{ $stats['pending'] }}</h1>
                    <small class="text-muted">Sedang Diproses</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <h1 class="fw-bold text-success">{{ $stats['approved'] }}</h1>
                    <small class="text-muted">Disetujui/Selesai</small>
                </div>
            </div>
        </div>

        {{-- TOMBOL AKSI --}}
        <div class="col-12 mb-4 text-end">
            <a href="{{ route('warga.application.create') }}" class="btn btn-primary shadow-sm fw-bold">
                <i class="fas fa-plus-circle me-2"></i> Buat Permohonan Baru
            </a>
        </div>

        {{-- TABEL RIWAYAT --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold">Riwayat Permohonan Anda</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light small text-muted">
                                <tr>
                                    <th class="ps-4">Tanggal</th>
                                    <th>Tiket</th>
                                    <th>Layanan</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applications as $app)
                                    <tr>
                                        <td class="ps-4 text-muted small">{{ $app->created_at->format('d M Y') }}</td>
                                        <td class="fw-bold font-monospace">{{ $app->nomor_tiket }}</td>
                                        <td>{{ $app->serviceType->nama_layanan }}</td>
                                        <td>
                                            @if ($app->status == 'pending')
                                                <span class="badge bg-warning text-dark">DIPROSES</span>
                                            @elseif($app->status == 'verified')
                                                <span class="badge bg-info">TERVERIFIKASI</span>
                                            @elseif($app->status == 'approved')
                                                <span class="badge bg-success">DISETUJUI</span>
                                            @elseif($app->status == 'distributed')
                                                <span class="badge bg-purple"
                                                    style="background-color: #6f42c1; color:white;">SELESAI</span>
                                            @else
                                                <span class="badge bg-danger">DITOLAK</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4 text-muted small">
                                            {{ $app->keterangan_tolak ?? ($app->status == 'approved' ? 'Silakan ambil surat di kantor.' : '-') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat permohonan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
