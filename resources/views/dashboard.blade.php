@extends('layouts.admin')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark m-0">Dashboard Overview</h3>
            <p class="text-muted m-0">Monitoring data pelayanan real-time hari ini.</p>
        </div>
        <div class="bg-white p-2 rounded shadow-sm border">
            <i class="fas fa-calendar-alt text-primary me-2"></i> {{ date('d F Y') }}
        </div>
    </div>

    {{-- BARIS 1: STATISTIK PERMOHONAN --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(45deg, #4e73df, #224abe);">
                <div class="card-body text-white position-relative overflow-hidden">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 text-uppercase fw-bold text-white-50" style="font-size: 0.8rem;">Total Permohonan
                            </p>
                            <h2 class="mb-0 fw-bold">{{ $stats['total'] }}</h2>
                        </div>
                        <i class="fas fa-folder-open fa-2x opacity-25"></i>
                    </div>
                    <small class="text-white-50 mt-3 d-block">Data kumulatif</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 bg-white border-start border-4 border-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">Perlu Tindakan</p>
                            <h2 class="mb-0 fw-bold text-dark">{{ $stats['pending'] }}</h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning">
                            <i class="fas fa-clock fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 bg-white border-start border-4 border-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">Siap Disalurkan
                            </p>
                            <h2 class="mb-0 fw-bold text-dark">{{ $stats['approved'] }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                            <i class="fas fa-check-double fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 bg-white border-start border-4 border-danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">Ditolak</p>
                            <h2 class="mb-0 fw-bold text-dark">{{ $stats['rejected'] }}</h2>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle text-danger">
                            <i class="fas fa-times-circle fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BARIS 2: PENGADUAN MASYARAKAT (BARU) --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-dark text-white"
                style="background: linear-gradient(45deg, #1cc88a, #13855c);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold mb-1"><i class="fas fa-bullhorn me-2"></i>Layanan Pengaduan Masyarakat</h5>
                            <p class="mb-0 text-white-50">Memantau keluhan dan masukan warga secara real-time.</p>
                        </div>
                        <div class="text-end">
                            <h2 class="fw-bold mb-0">{{ $stats['total_aduan'] }}</h2>
                            <span class="badge bg-white text-success">
                                {{ $stats['aduan_baru'] }} Baru Masuk
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BARIS 3: GRAFIK & AKTIVITAS --}}
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-chart-line me-2"></i>Tren Permohonan
                        ({{ date('Y') }})</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 320px;">
                        <canvas id="trenChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-2">
                    <ul class="nav nav-pills card-header-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active btn-sm" id="pills-logs-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-logs" type="button">Log Sistem</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link btn-sm position-relative" id="pills-aduan-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-aduan" type="button">
                                Pengaduan
                                @if ($stats['aduan_baru'] > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                                @endif
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-0">
                    <div class="tab-content" id="pills-tabContent">

                        {{-- TAB 1: LOG APLIKASI --}}
                        <div class="tab-pane fade show active" id="pills-logs" role="tabpanel">
                            <div class="list-group list-group-flush">
                                @forelse($stats['recent_logs'] as $log)
                                    <div class="list-group-item px-3 py-3">
                                        <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                            <small class="fw-bold text-dark">{{ $log->user->name ?? 'Sistem' }}</small>
                                            <small class="text-muted"
                                                style="font-size: 0.7rem;">{{ $log->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-1 small text-muted lh-sm">{{ $log->action }} - Tiket:
                                            {{ $log->application->nomor_tiket ?? '-' }}</p>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-muted small">Belum ada aktivitas.</div>
                                @endforelse
                            </div>
                        </div>

                        {{-- TAB 2: PENGADUAN TERBARU --}}
                        <div class="tab-pane fade" id="pills-aduan" role="tabpanel">
                            <div class="list-group list-group-flush">
                                @forelse($stats['recent_complaints'] as $aduan)
                                    <div class="list-group-item px-3 py-3">
                                        <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                            <small class="fw-bold text-danger">{{ $aduan->nama_pelapor }}</small>
                                            <span
                                                class="badge bg-{{ $aduan->status == 'masuk' ? 'danger' : 'success' }} scale-75">{{ strtoupper($aduan->status) }}</span>
                                        </div>
                                        <p class="mb-1 small text-dark fst-italic">
                                            "{{ Str::limit($aduan->isi_aduan, 50) }}"</p>
                                        <small class="text-muted" style="font-size: 0.7rem;">Tiket:
                                            {{ $aduan->tiket_pengaduan }}</small>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-muted small">Belum ada pengaduan masuk.</div>
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const ctxTren = document.getElementById('trenChart').getContext('2d');
        let gradient = ctxTren.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(78, 115, 223, 0.5)');
        gradient.addColorStop(1, 'rgba(78, 115, 223, 0.0)');

        new Chart(ctxTren, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Jumlah Permohonan',
                    data: {{ json_encode(array_values($chartData)) }},
                    borderColor: '#4e73df',
                    backgroundColor: gradient,
                    borderWidth: 2,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#4e73df',
                    pointRadius: 4,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [2, 2]
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
@endsection
