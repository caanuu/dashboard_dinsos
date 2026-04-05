@extends('layouts.sikasos')

@section('sidebar')
    <div class="menu-section">
        <div class="menu-title">Menu Utama</div>
        <a href="{{ route('masyarakat.dashboard') }}" class="nav-link-custom">
            <i class="fas fa-home"></i>
            Dashboard
        </a>
    </div>

    <div class="menu-section">
        <div class="menu-title">Pengajuan Bantuan</div>
        <a href="{{ route('masyarakat.applications.create') }}" class="nav-link-custom">
            <i class="fas fa-plus-circle"></i>
            Ajukan Bantuan
        </a>
        <a href="{{ route('masyarakat.applications.index') }}" class="nav-link-custom active">
            <i class="fas fa-list"></i>
            Pengajuan Saya
        </a>
    </div>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-file-alt me-2"></i>Detail Pengajuan
        </h1>
        <p class="text-muted mb-0">Nomor Tiket: <strong class="text-primary">{{ $application->nomor_tiket }}</strong></p>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Informasi Pengajuan -->
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Pengajuan</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Jenis Layanan</th>
                            <td>{{ $application->serviceType->nama_layanan }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Bantuan</th>
                            <td><span class="badge bg-info">{{ ucfirst($application->serviceType->jenis_bantuan) }}</span></td>
                        </tr>
                        <tr>
                            <th>Tanggal Pengajuan</th>
                            <td>{{ $application->created_at->format('d F Y, H:i') }} WIB</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($application->status == 'pending')
                                    <span class="badge bg-warning text-dark fs-6">
                                        <i class="fas fa-clock me-1"></i>Pending - Menunggu Verifikasi
                                    </span>
                                @elseif($application->status == 'verified')
                                    <span class="badge bg-info fs-6">
                                        <i class="fas fa-check me-1"></i>Diverifikasi
                                    </span>
                                @elseif($application->status == 'approved')
                                    <span class="badge bg-success fs-6">
                                        <i class="fas fa-check-circle me-1"></i>Disetujui
                                    </span>
                                @elseif($application->status == 'rejected')
                                    <span class="badge bg-danger fs-6">
                                        <i class="fas fa-times-circle me-1"></i>Ditolak
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @if($application->status == 'rejected' && $application->keterangan_tolak)
                            <tr>
                                <th>Alasan Penolakan</th>
                                <td class="text-danger">{{ $application->keterangan_tolak }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

            <!-- Data Pemohon -->
            <div class="card mb-3">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Data Pemohon</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Nama Lengkap</th>
                            <td>{{ $application->resident->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <th>NIK</th>
                            <td>{{ $application->resident->nik }}</td>
                        </tr>
                        <tr>
                            <th>No. KK</th>
                            <td>{{ $application->resident->no_kk }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $application->resident->alamat }}</td>
                        </tr>
                        <tr>
                            <th>No. HP</th>
                            <td>{{ $application->resident->no_hp }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Dokumen Pendukung -->
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-paperclip me-2"></i>Dokumen Pendukung</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($application->file_ktp)
                            <div class="col-md-4 mb-2">
                                <a href="{{ Storage::url($application->file_ktp) }}" target="_blank" class="btn btn-outline-primary btn-sm w-100">
                                    <i class="fas fa-file-pdf me-1"></i>Lihat KTP
                                </a>
                            </div>
                        @endif
                        @if($application->file_kk)
                            <div class="col-md-4 mb-2">
                                <a href="{{ Storage::url($application->file_kk) }}" target="_blank" class="btn btn-outline-primary btn-sm w-100">
                                    <i class="fas fa-file-pdf me-1"></i>Lihat KK
                                </a>
                            </div>
                        @endif
                        @if($application->file_pendukung)
                            <div class="col-md-4 mb-2">
                                <a href="{{ Storage::url($application->file_pendukung) }}" target="_blank" class="btn btn-outline-primary btn-sm w-100">
                                    <i class="fas fa-file-pdf me-1"></i>Lihat Pendukung
                                </a>
                            </div>
                        @endif
                    </div>
                    @if(!$application->file_ktp && !$application->file_kk && !$application->file_pendukung)
                        <p class="text-muted mb-0">Tidak ada dokumen yang diupload</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Timeline Status -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Status</h5>
                </div>
                <div class="card-body">
                    @if($application->logs->count() > 0)
                        <div class="timeline">
                            @foreach($application->logs as $log)
                                <div class="timeline-item mb-3">
                                    <div class="d-flex">
                                        <div class="me-2">
                                            <i class="fas fa-circle text-primary" style="font-size: 8px;"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-bold">{{ $log->action }}</div>
                                            <div class="small text-muted">
                                                {{ $log->created_at->format('d M Y, H:i') }}
                                            </div>
                                            @if($log->catatan)
                                                <div class="small mt-1">{{ $log->catatan }}</div>
                                            @endif
                                            <div class="small text-muted">oleh: {{ $log->user->name }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">Belum ada riwayat</p>
                    @endif
                </div>
            </div>

            <div class="d-grid gap-2 mt-3">
                <a href="{{ route('masyarakat.applications.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
@endsection
