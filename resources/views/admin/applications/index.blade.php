@extends('layouts.admin')

@section('content')
    <div class="card shadow border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary fw-bold">Daftar Permohonan Masuk</h5>
        </div>
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-primary fw-bold">Daftar Permohonan Masuk</h5>
            <a href="{{ route('admin.application.create') }}" class="btn btn-primary btn-sm shadow-sm">
                <i class="fas fa-plus me-1"></i> Input Permohonan Baru
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="appTable">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nomor Tiket</th>
                            <th>Nama Pemohon</th>
                            <th>Layanan</th>
                            <th>Tanggal Masuk</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#appTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.application.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'nomor_tiket',
                            name: 'nomor_tiket'
                        },
                        {
                            data: 'resident.nama_lengkap',
                            name: 'resident.nama_lengkap'
                        },
                        {
                            data: 'service_type.nama_layanan',
                            name: 'service_type.nama_layanan'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            render: function(data) {
                                return new Date(data).toLocaleDateString('id-ID');
                            }
                        },
                        {
                            data: 'status_label',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });
            });
        </script>
    @endpush
@endsection
