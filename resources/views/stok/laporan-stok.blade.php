<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }

        h2, h4 {
            text-align: center;
            margin: 0;
        }

        .tanggal-cetak {
            text-align: center;
            font-size: 13px;
            margin-top: 5px;
        }

        .periode {
            margin: 20px 0 10px;
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

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 40px;
            font-size: 11px;
            text-align: center;
            color: #666;
        }

        .no-data {
            margin-top: 20px;
            text-align: center;
            font-style: italic;
            color: #888;
        }
    </style>
</head>
<body>

    <header>
        <h2>Laporan Sisa Stok Produk</h2>
        <h4 style="margin-bottom: 6px"><strong>{{ $namaCabang }}</strong></h4>
        <div style="border-bottom: 2px solid #000; width: 100%; margin: 0 auto 10px;"></div>
        <div class="tanggal-cetak">
            Tanggal Cetak: {{ \Carbon\Carbon::parse($tanggalCetak)->format('d M Y') }}
        </div>
    </header>

    <div class="periode">
        @if(isset($periode))
            <strong>Periode:</strong>
            {{ \Carbon\Carbon::parse($periode['mulai'])->format('d M Y') }}
            -
            {{ \Carbon\Carbon::parse($periode['sampai'])->format('d M Y') }}
        @endif
    </div>

    @if(count($produkStok) > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 50%;">Nama Produk</th>
                    <th style="width: 25%;">Ukuran</th>
                    <th style="width: 20%;">Total Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produkStok as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_produk }}</td>
                        <td>{{ $item->ukuran }}</td>
                        <td>{{ $item->total_stok }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">Tidak ada data stok untuk periode ini.</div>
    @endif

    <div class="footer">
        © {{ date('Y') }} Raffi Collection — Sistem POS Multi Cabang
    </div>

</body>
</html>
