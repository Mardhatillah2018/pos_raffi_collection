<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Mutasi Stok</title>
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
            background-color: #eee;
        }

        .text-end {
            text-align: right;
        }
    </style>
</head>
<body>
    <h2>LAPORAN MUTASI STOK</h2>
    <h4>Cabang: {{ $namaCabang }}</h4>

    <div class="info">
        <table>
            <tr>
                <td>Bulan</td>
                <td>: {{ \Carbon\Carbon::createFromDate(null, (int)$bulan)->locale('id')->monthName }}
 {{ $tahun }}</td>
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
        <th>Nama Produk</th>
        <th>Ukuran</th>
        <th>Stok Masuk</th>
        <th>Stok Keluar</th>
        <th>Stok Akhir</th>
    </tr>
</thead>
<tbody>
    @forelse ($dataMutasi as $i => $item)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $item->nama_produk }}</td>
            <td>{{ $item->ukuran }}</td>
            <td>{{ $item->masuk }}</td>
            <td>{{ $item->keluar }}</td>
            <td>{{ $item->stok_akhir }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="5">Tidak ada data mutasi stok</td>
        </tr>
    @endforelse
</tbody>

    </table>
</body>
</html>
