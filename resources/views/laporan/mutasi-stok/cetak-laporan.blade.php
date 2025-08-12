<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Mutasi Stok</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
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

        .text-right {
            text-align: right;
        }

        .total-row td {
            font-weight: bold;
            background-color: #f9f9f9;
            border-top: 2px solid #000;
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
        <h2>Laporan Mutasi Stok</h2>
        <h4 style="margin-bottom: 6px">{{ $namaCabang }}</h4>
        <div style="border-bottom: 2px solid #000; width: 100%; margin: 0 auto 10px;"></div>
        <div class="tanggal-cetak">
            {{-- Tanggal Cetak: {{ \Carbon\Carbon::parse($tanggalCetak)->format('d M Y') }} --}}
            Tanggal Cetak: {{ $tanggalCetak }}
        </div>
    </header>

    <div class="periode">
        <strong>Periode:</strong>
        @if($filterType === 'bulan')
            {{ $periodeLabel }}
        @elseif($filterType === 'tanggal')
            {{ $periodeLabel }}
        @endif
    </div>


    @if(count($dataMutasi) > 0)
    <table>
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th style="width: 25%;">Nama Produk</th>
            <th style="width: 10%;">Ukuran</th>
            <th style="width: 10%;">Harga Modal</th>
            <th style="width: 10%;">Harga Jual</th>
            <th style="width: 8%;">Stok Awal</th>
            <th style="width: 8%;">Stok Masuk</th>
            <th style="width: 8%;">Stok Keluar</th>
            <th style="width: 8%;">Stok Akhir</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataMutasi as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td style="text-align: left;">{{ $item->nama_produk }}</td>
                <td>{{ $item->ukuran }}</td>
                <td class="text-right">{{ number_format($item->harga_modal, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                <td>{{ $item->stok_awal }}</td>
                <td>{{ $item->masuk }}</td>
                <td>{{ $item->keluar }}</td>
                <td>{{ $item->stok_akhir }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


@php
    $totalModal = $dataMutasi->sum(function($item) {
        return $item->harga_modal * $item->stok_akhir;
    });
    $totalJual = $dataMutasi->sum(function($item) {
        return $item->harga_jual * $item->stok_akhir;
    });
@endphp

<div style="margin-top: 15px; text-align: right; font-weight: bold; font-size: 14px;">
    Total Nilai Modal: Rp {{ number_format($totalModal, 0, ',', '.') }} <br>
    Total Nilai Jual: Rp {{ number_format($totalJual, 0, ',', '.') }}
</div>

    @else
        <div class="no-data">Tidak ada data mutasi stok untuk periode ini.</div>
    @endif

</body>
</html>
