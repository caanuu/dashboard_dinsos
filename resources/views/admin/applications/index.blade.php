@extends('layouts.admin')
@section('title', 'Permohonan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex gap-2">
            <input type="text" class="form-control form-control-sm" placeholder="Find a request..." style="width: 300px;">
            <button class="btn btn-sm btn-outline-secondary fw-bold">Type: All</button>
        </div>
        @if (auth()->user()->role != 'kadis')
            <a href="{{ route('admin.application.create') }}" class="btn btn-primary btn-sm">
                <i class="far fa-plus-square me-1"></i> New request
            </a>
        @endif
    </div>

    <div class="gh-box">
        <div class="gh-box-header d-flex justify-content-between py-2">
            <div class="d-flex gap-3 small">
                <a href="#" class="text-dark fw-bold text-decoration-none"><i class="far fa-check-circle me-1"></i>
                    Open</a>
                <a href="#" class="text-muted text-decoration-none"><i class="fas fa-check me-1"></i> Closed</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table mb-0 w-100 align-middle" id="appTable">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th width="5%" class="border-bottom-0">#</th>
                        <th class="border-bottom-0">Ticket ID</th>
                        <th class="border-bottom-0">Resident</th>
                        <th class="border-bottom-0">Service</th>
                        <th class="border-bottom-0">Status</th>
                        <th class="border-bottom-0">Score</th>
                        <th class="border-bottom-0 text-end">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#appTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.application.index') }}",
                    // Hilangkan fitur default DataTables agar terlihat custom
                    dom: 't<"d-flex justify-content-between mt-3 px-3"ip>',
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            className: 'text-center text-muted'
                        },
                        {
                            data: 'nomor_tiket',
                            name: 'nomor_tiket',
                            render: function(data) {
                                return `<span class="font-monospace fw-bold text-dark">${data}</span>`;
                            }
                        },
                        {
                            data: 'resident.nama_lengkap',
                            name: 'resident.nama_lengkap',
                            render: function(data, type, row) {
                                let source = row.is_online == 1 ?
                                    '<span class="badge border text-muted ms-1" style="font-size:10px">WEB</span>' :
                                    '';
                                return `<div class="fw-bold">${data}${source}</div><div class="small text-muted">Created ${row.created_at}</div>`;
                            }
                        },
                        {
                            data: 'service_type.nama_layanan',
                            name: 'service_type.nama_layanan'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            render: function(data) {
                                let colors = {
                                    'pending': '#d29922', // Yellow
                                    'verified': '#2088ff', // Blue
                                    'approved': '#2da44e', // Green
                                    'rejected': '#cf222e', // Red
                                    'distributed': '#8250df' // Purple
                                };
                                let color = colors[data] || '#6e7681';
                                return `<span style="background-color: ${color}; color: #fff; padding: 2px 8px; border-radius: 2em; font-size: 11px; font-weight: 600; text-transform: uppercase;">${data}</span>`;
                            }
                        },
                        {
                            data: 'skor_kelayakan',
                            name: 'skor_kelayakan',
                            className: 'text-center fw-bold'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            className: 'text-end',
                            render: function(data, type, row) {
                                // Extract URL from the button string or build it manually
                                return `<a href="/admin/application/${row.id}" class="btn btn-sm btn-outline-secondary" style="font-size:12px;">View</a>`;
                            }
                        },
                    ],
                    order: [
                        [5, 'desc']
                    ]
                });
            });
        </script>
    @endpush
@endsection
