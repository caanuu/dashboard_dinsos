@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-dark mb-0">Detail Permohonan: {{ $application->nomor_tiket }}</h4>
            <a href="{{ route('admin.application.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0 fw-bold"><i class="fas fa-user me-2"></i>Data Pemohon</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="text-muted" width="35%">NIK</td>
                                <td class="fw-bold">{{ $application->resident->nik }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Nama</td>
                                <td class="fw-bold">{{ $application->resident->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">No KK</td>
                                <td>{{ $application->resident->no_kk }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Alamat</td>
                                <td>{{ $application->resident->alamat }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Layanan</td>
                                <td><span class="badge bg-info">{{ $application->serviceType->nama_layanan }}</span></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Status</td>
                                <td>
                                    <span class="badge bg-{{ $application->status_color }}">
                                        {{ strtoupper($application->status) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Aksi Proses</h6>

                        <form action="{{ route('admin.application.process', $application->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="small text-muted">Catatan (Opsional)</label>
                                <textarea name="catatan" class="form-control" rows="2" placeholder="Alasan penolakan atau catatan verifikasi..."></textarea>
                            </div>

                            <div class="d-grid gap-2">
                                @if (in_array(Auth::user()->role, ['operator', 'admin']) && $application->status == 'pending')
                                    <button type="submit" name="action" value="verify" class="btn btn-primary">
                                        <i class="fas fa-check-double me-1"></i> Verifikasi Berkas
                                    </button>
                                @endif

                                @if (Auth::user()->role == 'kadis' && $application->status == 'verified')
                                    <button type="submit" name="action" value="approve" class="btn btn-success">
                                        <i class="fas fa-signature me-1"></i> Setujui & Tanda Tangan
                                    </button>
                                    <button type="submit" name="action" value="reject" class="btn btn-danger">
                                        <i class="fas fa-times-circle me-1"></i> Tolak Permohonan
                                    </button>
                                @endif

                                @if ($application->status == 'approved')
                                    <a href="{{ route('admin.application.print', $application->id) }}" target="_blank"
                                        class="btn btn-dark">
                                        <i class="fas fa-print me-1"></i> Cetak Surat Rekomendasi
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h6 class="mb-0 fw-bold">Riwayat Proses</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($application->logs as $log)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1 text-primary">{{ $log->action }}</h6>
                                        <small class="text-muted">{{ $log->created_at->format('d M Y H:i') }}</small>
                                    </div>
                                    <p class="mb-1 small">
                                        Oleh: <strong>{{ $log->user->name }}</strong> ({{ ucfirst($log->user->role) }})
                                    </p>
                                    @if ($log->catatan)
                                        <div class="alert alert-light border mt-2 py-2 px-3 small fst-italic mb-0">
                                            "{{ $log->catatan }}"
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="p-4 text-center text-muted">Belum ada riwayat aktivitas.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
