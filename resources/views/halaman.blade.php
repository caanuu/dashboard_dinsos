@extends('layouts.admin')

@section('title', 'Halaman Warga')

@section('content')
    <div class="row">
        {{-- BAGIAN 1: PROFIL PENGGUNA (AKUN & PENDUDUK) --}}
        <div class="col-md-12 mb-4">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold m-0 text-primary"><i class="fas fa-id-card me-2"></i>Profil Saya</h6>
                </div>
                <div class="card-body p-0">
                    <div class="row g-0">
                        {{-- Sisi Kiri: Foto & Info Akun --}}
                        <div class="col-md-3 bg-light text-center p-4 border-end">
                            <div class="mb-3">
                                <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=0d6efd&color=fff&size=128"
                                    class="rounded-circle shadow-sm" alt="Profile">
                            </div>
                            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                            <div class="badge bg-primary mb-2">{{ strtoupper($user->role) }}</div>
                            <p class="text-muted small mb-1"><i class="fas fa-envelope me-1"></i> {{ $user->email }}</p>
                            <p class="text-muted small"><i class="fas fa-phone me-1"></i> {{ $user->no_hp ?? '-' }}</p>
                        </div>

                        {{-- Sisi Kanan: Detail Data Penduduk --}}
                        <div class="col-md-9 p-4">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3 border-bottom pb-2">Data Kependudukan
                            </h6>

                            @if ($resident)
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label class="small text-muted d-block">NIK</label>
                                        <span class="fw-bold font-monospace fs-5">{{ $resident->nik }}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="small text-muted d-block">Nomor Kartu Keluarga (KK)</label>
                                        <span class="fw-bold font-monospace fs-5">{{ $resident->no_kk }}</span>
                                    </div>
                                    <div class="col-12">
                                        <label class="small text-muted d-block">Alamat Lengkap</label>
                                        <span class="fw-bold">{{ $resident->alamat }}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="small text-muted d-block">Pekerjaan</label>
                                        <span class="fw-bold">{{ $resident->pekerjaan }}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="small text-muted d-block">Status DTKS</label>
                                        @if ($resident->is_dtks)
                                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>
                                                Terdaftar DTKS</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Terdaftar</span>
                                        @endif
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="small text-muted d-block">Penghasilan</label>
                                        <span class="fw-bold">Rp
                                            {{ number_format($resident->penghasilan, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="small text-muted d-block">Jumlah Tanggungan</label>
                                        <span class="fw-bold">{{ $resident->jumlah_tanggungan }} Orang</span>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning mb-0">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Data kependudukan belum lengkap. Data akan tersimpan otomatis saat Anda mengajukan
                                    permohonan pertama kali.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BAGIAN 2: STATISTIK & TOMBOL --}}
        <div class="col-md-8 mb-4">
            <div class="d-flex gap-2">
                <a href="{{ route('warga.application.create') }}" class="btn btn-primary shadow-sm fw-bold px-4">
                    <i class="fas fa-plus-circle me-2"></i> Ajukan Permohonan Baru
                </a>
                {{-- TOMBOL EDIT PROFIL DIAKTIFKAN --}}
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-edit me-1"></i> Edit Profil
                </a>
            </div>
        </div>
        <div class="col-md-4 mb-4 text-end">
            <div class="d-inline-block text-center border rounded p-2 px-3 bg-white shadow-sm me-2">
                <div class="h4 fw-bold text-primary m-0">{{ $stats['total'] }}</div>
                <small class="text-muted" style="font-size: 10px;">TOTAL</small>
            </div>
            <div class="d-inline-block text-center border rounded p-2 px-3 bg-white shadow-sm me-2">
                <div class="h4 fw-bold text-warning m-0">{{ $stats['pending'] }}</div>
                <small class="text-muted" style="font-size: 10px;">PROSES</small>
            </div>
            <div class="d-inline-block text-center border rounded p-2 px-3 bg-white shadow-sm">
                <div class="h4 fw-bold text-success m-0">{{ $stats['approved'] }}</div>
                <small class="text-muted" style="font-size: 10px;">SELESAI</small>
            </div>
        </div>

        {{-- BAGIAN 3: RIWAYAT PERMOHONAN --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="fas fa-history me-2 text-secondary"></i> Riwayat Permohonan Anda
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light small text-muted text-uppercase">
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
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fas fa-folder-open fa-2x mb-3 d-block opacity-25"></i>
                                        Belum ada riwayat permohonan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
