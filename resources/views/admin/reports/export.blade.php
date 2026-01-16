@extends('layouts.admin')

@section('page-title', 'Export Laporan')

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card-modern">
                <div class="p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="fas fa-download me-2" style="color: #6366f1;"></i>Export Laporan Permohonan
                    </h5>

                    <form id="exportForm" method="GET">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label fw-semibold">Tanggal Mulai</label>
                                <input type="date" class="form-control form-control-lg" id="start_date" name="start_date" 
                                       value="{{ request('start_date', date('Y-m-01')) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label fw-semibold">Tanggal Akhir</label>
                                <input type="date" class="form-control form-control-lg" id="end_date" name="end_date" 
                                       value="{{ request('end_date', date('Y-m-d')) }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label fw-semibold">Filter Status</label>
                            <select class="form-select form-select-lg" id="status" name="status">
                                <option value="all">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Diverifikasi</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>

                        <div class="alert alert-info rounded-4">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Informasi:</strong> Laporan akan berisi data permohonan sesuai dengan filter yang Anda pilih.
                        </div>

                        <div class="d-grid gap-3">
                            <button type="button" onclick="exportPDF()" class="btn btn-danger btn-lg">
                                <i class="fas fa-file-pdf me-2"></i>Export ke PDF
                            </button>
                            <button type="button" onclick="exportExcel()" class="btn btn-success btn-lg">
                                <i class="fas fa-file-excel me-2"></i>Export ke Excel
                            </button>
                            <a href="{{ route('admin.application.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function exportPDF() {
            const form = document.getElementById('exportForm');
            form.action = "{{ route('admin.export.pdf') }}";
            form.submit();
        }

        function exportExcel() {
            const form = document.getElementById('exportForm');
            form.action = "{{ route('admin.export.excel') }}";
            form.submit();
        }
    </script>
@endsection
