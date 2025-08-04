<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuntungan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2, h4 {
            text-align: center;
            margin: 0;
        }

        .info {
            margin: 20px 0;
            font-size: 13px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-start {
            text-align: left;
        }

        .text-end {
            text-align: right;
        }
    </style>
</head>
<body>

    <h2>Laporan Keuntungan</h2>
    <h4>{{ $namaCabang }}</h4>

    <div class="info">
        <strong>Tanggal Cetak:</strong> {{ $tanggalCetak }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Bulan</th>
                <th>Total Produk Terjual</th>
                <th>Total Penjualan</th>
                <th>Laba Kotor</th>
                <th>Pengeluaran</th>
                <th>Laba Bersih</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekap as $index => $item)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $item['bulan'] }}</td>
        <td>{{ $item['total_produk'] }}</td>
        <td>Rp {{ number_format($item['total_penjualan'], 0, ',', '.') }}</td>
        <td>Rp {{ number_format($item['laba_kotor'], 0, ',', '.') }}</td>
        <td>Rp {{ number_format($item['pengeluaran'], 0, ',', '.') }}</td>
        <td>Rp {{ number_format($item['laba_bersih'], 0, ',', '.') }}</td>
    </tr>
@endforeach

        </tbody>
    </table>

</body>
</html>
