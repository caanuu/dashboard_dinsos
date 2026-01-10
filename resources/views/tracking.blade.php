<!DOCTYPE html>
<html lang="id">

<head>
    <title>Cek Status Permohonan - Dinas Sosial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary">Layanan Pelacakan Mandiri</h3>
                    <p class="text-muted">Cek status pengajuan bantuan Anda tanpa perlu login.</p>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <form action="{{ route('tracking') }}" method="GET">
                            <div class="input-group input-group-lg">
                                <input type="text" name="keyword" class="form-control"
                                    placeholder="Masukkan Nomor Tiket (Cth: SKTM-2401-XXXX)"
                                    value="{{ request('keyword') }}" required>
                                <button class="btn btn-primary" type="submit">Cek Status</button>
                            </div>
                        </form>
                    </div>
                </div>

                @if (request()->has('keyword'))
                    @if ($result)
                        <div class="card shadow border-0 border-top border-4 border-{{ $result->status_color }}">
                            <div class="card-body text-center p-5">
                                <h5 class="text-muted mb-3">Nomor Tiket: <strong>{{ $result->nomor_tiket }}</strong>
                                </h5>
                                <h2 class="mb-3 text-{{ $result->status_color }} fw-bold">
                                    {{ strtoupper($result->status) }}</h2>
                                <p class="mb-4">
                                    Halo, <strong>{{ $result->resident->nama_lengkap }}</strong>.<br>
                                    Permohonan layanan <u>{{ $result->serviceType->nama_layanan }}</u> Anda saat ini
                                    sedang dalam tahap:
                                </p>

                                <div class="alert alert-light border">
                                    @if ($result->status == 'pending')
                                        Menunggu verifikasi kelengkapan berkas oleh petugas loket.
                                    @elseif($result->status == 'verified')
                                        Berkas lengkap. Sedang menunggu persetujuan Kepala Dinas.
                                    @elseif($result->status == 'approved')
                                        Permohonan DISETUJUI. Silahkan datang ke kantor untuk mengambil surat.
                                    @elseif($result->status == 'rejected')
                                        Permohonan DITOLAK. <br>Alasan: {{ $result->keterangan_tolak }}
                                    @endif
                                </div>
                                <a href="{{ route('home') }}" class="btn btn-link">Kembali ke Beranda</a>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger text-center">
                            Data permohonan dengan nomor tiket tersebut tidak ditemukan.
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</body>

</html>
