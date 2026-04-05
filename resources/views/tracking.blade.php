<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Status - SIKASOS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }

        .tracking-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .tracking-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
        }

        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -2rem;
            top: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #667eea;
        }

        .timeline-item::after {
            content: '';
            position: absolute;
            left: -1.7rem;
            top: 12px;
            width: 2px;
            height: calc(100% - 12px);
            background: #e0e0e0;
        }

        .timeline-item:last-child::after {
            display: none;
        }
    </style>
</head>
<body>
    <div class="tracking-container">
        <div class="text-center mb-4">
            <a href="{{ route('home') }}" class="text-white text-decoration-none">
                <h2 class="text-white fw-bold">
                    <i class="fas fa-hands-helping me-2"></i>SIKASOS
                </h2>
                <p class="text-white-50">Tracking Status Pengajuan</p>
            </a>
        </div>

        <div class="tracking-card">
            <form action="{{ route('tracking') }}" method="GET" class="mb-4">
                <div class="input-group input-group-lg">
                    <input type="text" name="keyword" class="form-control" 
                           placeholder="Masukkan nomor tiket Anda..." 
                           value="{{ request('keyword') }}" required>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Cari
                    </button>
                </div>
                <small class="text-muted">Contoh: BPJS-PBI-2601-1234</small>
            </form>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if($result)
                <div class="border-top pt-4">
                    <h5 class="fw-bold mb-3">Detail Pengajuan</h5>
                    
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Nomor Tiket</th>
                            <td><strong class="text-primary">{{ $result->nomor_tiket }}</strong></td>
                        </tr>
                        <tr>
                            <th>Nama Pemohon</th>
                            <td>{{ $result->resident->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Layanan</th>
                            <td>{{ $result->serviceType->nama_layanan }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Pengajuan</th>
                            <td>{{ $result->created_at->format('d F Y, H:i') }} WIB</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($result->status == 'pending')
                                    <span class="status-badge bg-warning text-dark">
                                        <i class="fas fa-clock me-1"></i>Pending
                                    </span>
                                @elseif($result->status == 'verified')
                                    <span class="status-badge bg-info text-white">
                                        <i class="fas fa-check me-1"></i>Diverifikasi
                                    </span>
                                @elseif($result->status == 'approved')
                                    <span class="status-badge bg-success text-white">
                                        <i class="fas fa-check-circle me-1"></i>Disetujui
                                    </span>
                                @elseif($result->status == 'rejected')
                                    <span class="status-badge bg-danger text-white">
                                        <i class="fas fa-times-circle me-1"></i>Ditolak
                                    </span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    @if($result->logs->count() > 0)
                        <h6 class="fw-bold mt-4 mb-3">Riwayat Status</h6>
                        <div class="timeline">
                            @foreach($result->logs as $log)
                                <div class="timeline-item">
                                    <div class="fw-bold">{{ $log->action }}</div>
                                    <div class="small text-muted">
                                        {{ $log->created_at->format('d M Y, H:i') }}
                                        @if($log->catatan)
                                            <br>{{ $log->catatan }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @elseif(request('keyword'))
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Nomor tiket tidak ditemukan. Pastikan Anda memasukkan nomor yang benar.
                </div>
            @endif
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="text-white">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
