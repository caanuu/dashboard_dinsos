@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Detail Permohonan: {{ $application->nomor_tiket }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <td width="30%">Nama Pemohon</td>
                            <td>: <strong>{{ $application->resident->nama_lengkap }}</strong></td>
                        </tr>
                        <tr>
                            <td>NIK</td>
                            <td>: {{ $application->resident->nik }}</td>
                        </tr>
                        <tr>
                            <td>Jenis Layanan</td>
                            <td>: <span class="badge bg-info">{{ $application->serviceType->nama_layanan }}</span></td>
                        </tr>
                        <tr>
                            <td>Status Saat Ini</td>
                            <td>: <span class="badge bg-{{ $application->status_color }}">{{ strtoupper($application->status) }}</span></td>
                        </tr>
                    </table>

                    <div class="mt-4 border-top pt-3">
                        <form action="{{ route('admin.application.process', $application->id) }}" method="POST">
                            @csrf

                            @if($application->status == 'pending')
                            <button name="action" value="verify" class="btn btn-warning">
                                <i class="fas fa-check"></i> Verifikasi Berkas
                            </button>
                            @endif

                            @if($application->status == 'verified' || $application->status == 'waiting_approval')
                            <button name="action" value="approve" class="btn btn-success" onclick="return confirm('Yakin setujui?')">
                                <i class="fas fa-signature"></i> Setujui & Terbitkan Surat
                            </button>
                            @endif

                            @if($application->status != 'approved' && $application->status != 'rejected')
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                            @endif

                            @if($application->status == 'approved')
                            <a href="{{ route('admin.application.print', $application->id) }}" class="btn btn-dark" target="_blank">
                                <i class="fas fa-print"></i> Cetak Surat PDF
                            </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="mb-0">Riwayat Proses</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($application->logs as $log)
                        <li class="list-group-item">
                            <small class="text-muted">{{ $log->created_at->format('d M Y H:i') }}</small><br>
                            <strong>{{ $log->user->name }}</strong><br>
                            <span class="text-primary">{{ $log->action }}</span>
                            @if($log->catatan)
                                <br><em class="text-danger">"{{ $log->catatan }}"</em>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rejectModal">
    <div class="modal-dialog">
        <form action="{{ route('admin.application.process', $application->id) }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Alasan Penolakan</h5>
            </div>
            <div class="modal-body">
                <textarea name="catatan" class="form-control" rows="3" placeholder="Misal: Data KTP tidak sesuai..." required></textarea>
                <input type="hidden" name="action" value="reject">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Tolak Permohonan</button>
            </div>
        </form>
    </div>
</div>
@endsection
