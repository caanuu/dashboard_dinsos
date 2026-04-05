<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Permohonan SIKASOS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
        }
        
        .header h2 {
            margin: 5px 0;
            color: #667eea;
        }
        
        .header p {
            margin: 3px 0;
            color: #666;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th {
            background-color: #667eea;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: bold;
        }
        
        td {
            padding: 6px 8px;
            border-bottom: 1px solid #ddd;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .badge-warning { background-color: #ffc107; color: #000; }
        .badge-info { background-color: #17a2b8; color: #fff; }
        .badge-success { background-color: #28a745; color: #fff; }
        .badge-danger { background-color: #dc3545; color: #fff; }
        
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN PERMOHONAN BANTUAN SOSIAL</h2>
        <h3>SIKASOS - Dinas Sosial Kota Tebing Tinggi</h3>
        <p>Tanggal Cetak: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Nomor Tiket</th>
                <th width="20%">Nama Pemohon</th>
                <th width="15%">NIK</th>
                <th width="20%">Jenis Layanan</th>
                <th width="10%">Status</th>
                <th width="15%">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $index => $app)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $app->nomor_tiket }}</td>
                    <td>{{ $app->resident->nama_lengkap }}</td>
                    <td>{{ $app->resident->nik }}</td>
                    <td>{{ $app->serviceType->nama_layanan }}</td>
                    <td>
                        @if($app->status == 'pending')
                            <span class="badge badge-warning">PENDING</span>
                        @elseif($app->status == 'verified')
                            <span class="badge badge-info">VERIFIED</span>
                        @elseif($app->status == 'approved')
                            <span class="badge badge-success">APPROVED</span>
                        @elseif($app->status == 'rejected')
                            <span class="badge badge-danger">REJECTED</span>
                        @endif
                    </td>
                    <td>{{ $app->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">
                        Tidak ada data permohonan
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Total Permohonan: <strong>{{ $applications->count() }}</strong></p>
        <p>Dicetak oleh: {{ Auth::user()->name }}</p>
    </div>
</body>
</html>
