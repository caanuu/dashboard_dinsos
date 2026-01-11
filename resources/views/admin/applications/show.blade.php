@extends('layouts.admin')
@section('title', 'Detail Permohonan')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold m-0 text-primary">Informasi Pemohon</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%" class="text-muted">Nomor Tiket</td>
                            <td class="fw-bold">{{ $application->nomor_tiket }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Jenis Layanan</td>
                            <td>{{ $application->serviceType->nama_layanan }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <hr class="my-0">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">NIK</td>
                            <td>{{ $application->resident->nik }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Nama Lengkap</td>
                            <td>{{ $application->resident->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status DTKS</td>
                            <td>
                                @if ($application->resident->is_dtks)
                                    <span class="badge bg-success">Terdaftar DTKS</span>
                                @else
                                    <span class="badge bg-secondary">Non-DTKS</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Skor Kelayakan</td>
                            <td>
                                <h4
                                    class="mb-0 fw-bold {{ $application->skor_kelayakan > 70 ? 'text-success' : 'text-warning' }}">
                                    {{ $application->skor_kelayakan }}
                                </h4>
                            </td>
                        </tr>

                        {{-- UPDATE: TAMPILAN FILE --}}
                        <tr>
                            <td class="text-muted align-top pt-3">Dokumen</td>
                            <td>
                                {{-- 1. PDF Proposal --}}
                                <a href="{{ asset('storage/' . $application->file_persyaratan) }}" target="_blank"
                                    class="btn btn-danger btn-sm w-100 text-start mb-2">
                                    <i class="fas fa-file-pdf me-2"></i> Buka Dokumen Proposal (PDF)
                                </a>

                                {{-- 2. Foto Persyaratan Grid --}}
                                <div class="row g-2">
                                    <div class="col-4">
                                        @if ($application->file_ktp)
                                            <a href="{{ asset('storage/' . $application->file_ktp) }}" target="_blank"
                                                class="d-block border rounded p-1 text-center text-decoration-none bg-light hover-bg-gray">
                                                <i class="fas fa-id-card fa-lg text-primary mb-1"></i><br>
                                                <small class="text-muted" style="font-size: 10px;">FOTO KTP</small>
                                            </a>
                                        @endif
                                    </div>
                                    <div class="col-4">
                                        @if ($application->file_kk)
                                            <a href="{{ asset('storage/' . $application->file_kk) }}" target="_blank"
                                                class="d-block border rounded p-1 text-center text-decoration-none bg-light">
                                                <i class="fas fa-users fa-lg text-success mb-1"></i><br>
                                                <small class="text-muted" style="font-size: 10px;">FOTO KK</small>
                                            </a>
                                        @endif
                                    </div>
                                    <div class="col-4">
                                        @if ($application->file_pengantar)
                                            <a href="{{ asset('storage/' . $application->file_pengantar) }}" target="_blank"
                                                class="d-block border rounded p-1 text-center text-decoration-none bg-light">
                                                <i class="fas fa-envelope fa-lg text-warning mb-1"></i><br>
                                                <small class="text-muted" style="font-size: 10px;">PENGANTAR</small>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- LOG RIWAYAT --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light py-2">
                    <small class="fw-bold text-uppercase">Riwayat Proses</small>
                </div>
                <div class="list-group list-group-flush">
                    @foreach ($application->logs as $log)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong class="small">{{ $log->user->name ?? 'System/User' }}</strong>
                                <small class="text-muted">{{ $log->created_at->format('d M H:i') }}</small>
                            </div>
                            <span class="badge bg-secondary small">{{ $log->action }}</span>
                            <span class="text-muted small fst-italic ms-2">"{{ $log->catatan }}"</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-4">
            {{-- PANEL AKSI STATUS (SAMA SEPERTI SEBELUMNYA) --}}
            <div class="card shadow border-0 mb-3">
                <div class="card-body text-center bg-{{ $application->status_color ?? 'primary' }} text-white rounded">
                    <h6 class="text-uppercase opacity-75 mb-1">Status Saat Ini</h6>
                    <h3 class="fw-bold mb-0">{{ strtoupper($application->status) }}</h3>
                </div>
            </div>

            @if ($application->status != 'distributed' && $application->status != 'rejected')
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold">Tindak Lanjut</div>
                    <div class="card-body">
                        <form action="{{ route('admin.application.process', $application->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="small text-muted mb-1">Catatan Petugas</label>
                                <textarea name="catatan" class="form-control" rows="3" required placeholder="Tulis catatan..."></textarea>
                            </div>
                            <div class="d-grid gap-2">
                                @if (auth()->user()->role == 'kadis' && $application->status == 'verified')
                                    <button type="submit" name="action" value="approve"
                                        class="btn btn-success fw-bold">SETUJUI (ACC)</button>
                                    <button type="submit" name="action" value="reject"
                                        class="btn btn-danger">TOLAK</button>
                                @elseif(in_array(auth()->user()->role, ['admin', 'operator']) && $application->status == 'pending')
                                    <button type="submit" name="action" value="verify"
                                        class="btn btn-info text-white fw-bold">VERIFIKASI</button>
                                    <button type="submit" name="action" value="reject"
                                        class="btn btn-danger">TOLAK</button>
                                @elseif($application->status == 'approved')
                                    <a href="{{ route('admin.application.print', $application->id) }}" target="_blank"
                                        class="btn btn-dark">CETAK SURAT</a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <a href="{{ route('admin.application.index') }}"
                class="btn btn-link text-decoration-none w-100 mt-3 text-muted">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
        </div>
    </div>
@endsection
