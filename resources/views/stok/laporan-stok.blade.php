<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Stok</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 30px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
            letter-spacing: 1px;
        }

        .header p {
            margin: 2px 0 0 0;
            font-size: 13px;
        }

        .info {
            text-align: right;
            font-size: 11px;
            margin-top: 5px;
        }

        hr {
            border: 0;
            border-top: 1px solid #999;
            margin: 10px 0 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead {
            background-color: #f0f0f0;
        }

        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 40px;
            font-size: 11px;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>LAPORAN STOK PRODUK</h2>
        <p>Toko Raffi Collection - <strong>{{ $namaCabang }}</strong></p>
    </div>

    <div class="info">
        Dicetak pada: {{ \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s') }}
    </div>

    <hr>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Ukuran</th>
                <th>Total Stok</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($produkStok as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama_produk }}</td>
                <td>{{ $item->ukuran }}</td>
                <td>{{ $item->total_stok }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4">Tidak ada data stok</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        © {{ date('Y') }} Raffi Collection — Sistem POS Multi Cabang
    </div>

</body>
</html>
