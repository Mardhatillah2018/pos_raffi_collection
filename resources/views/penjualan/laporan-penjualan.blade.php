<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        h2, h4 {
            text-align: center;
            margin: 0;
        }

        .info {
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .info table {
            width: 100%;
            font-size: 12px;
        }

        .info td {
            padding: 3px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-end {
            text-align: right;
        }
    </style>
</head>
<body>
    <h2>LAPORAN PENJUALAN</h2>
    <h4>Cabang: {{ $namaCabang ?? '-' }}</h4>

    <div class="info">
        <table>
            <tr>
                <td>Periode</td>
                <td>: {{ \Carbon\Carbon::parse($periode['mulai'])->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($periode['sampai'])->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td>Tanggal Cetak</td>
                <td>: {{ \Carbon\Carbon::parse($tanggalCetak)->translatedFormat('d F Y') }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Faktur</th>
                <th>Tanggal</th>
                <th>Total Qty</th>
                <th>Total Harga</th>
                <th>Dibuat Oleh</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penjualans as $index => $penjualan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $penjualan->no_faktur }}</td>
                    <td>{{ \Carbon\Carbon::parse($penjualan->tanggal_penjualan)->format('d-m-Y') }}</td>
                    <td>{{ $penjualan->detailPenjualans->sum('qty') }}</td>
                    <td class="text-end">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                    <td>{{ $penjualan->user->nama ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Tidak ada data penjualan pada periode ini</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
