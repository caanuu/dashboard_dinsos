<!DOCTYPE html>
<html>

<head>
    <title>Surat Rekomendasi</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            border-bottom: 3px double black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .content {
            margin: 0 50px;
        }

        .ttd {
            float: right;
            margin-top: 50px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <h3 style="margin:0">PEMERINTAH KOTA CONTOH</h3>
        <h2 style="margin:0">DINAS SOSIAL</h2>
        <p style="margin:0">Jl. Pahlawan No. 123, Kota Contoh</p>
    </div>

    <div class="content">
        <center>
            <h4><u>SURAT REKOMENDASI</u></h4>
            <p>Nomor: {{ $app->nomor_tiket }}</p>
        </center>

        <p>Yang bertanda tangan di bawah ini, Kepala Dinas Sosial Kota Contoh menerangkan bahwa:</p>

        <table style="width: 100%">
            <tr>
                <td width="150">Nama</td>
                <td>: {{ $app->resident->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>: {{ $app->resident->nik }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: {{ $app->resident->alamat }}</td>
            </tr>
        </table>

        <p>Adalah benar warga Kota Contoh yang terdaftar dalam Data Terpadu Kesejahteraan Sosial (DTKS) dan layak
            mendapatkan layanan: <strong>{{ $app->serviceType->nama_layanan }}</strong>.</p>

        <p>Demikian surat ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="ttd">
        <p>Ditetapkan di: Kota Contoh<br>Pada Tanggal: {{ date('d F Y') }}</p>
        <br><br><br>
        <strong><u>KEPALA DINAS SOSIAL</u></strong>
    </div>
</body>

</html>
