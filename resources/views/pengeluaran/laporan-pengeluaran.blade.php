<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengeluaran</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2, h4 { text-align: center; margin: 0; }
        .tanggal-cetak { text-align: center; font-size: 13px; margin-top: 5px; }
        .periode { margin: 20px 0 10px; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .total-row td { font-weight: bold; background-color: #f9f9f9; border-top: 2px solid #000; }
        .no-data { margin-top: 20px; text-align: center; font-style: italic; color: #888; }
    </style>
</head>
<body>

    <header>
        <h2>Laporan Pengeluaran</h2>
        <h4 style="margin-bottom: 6px">{{ $namaCabang }}</h4>
        <div style="border-bottom: 2px solid #000; width: 100%; margin: 0 auto 10px;"></div>
        <div class="tanggal-cetak">
            Tanggal Cetak: {{ \Carbon\Carbon::parse($tanggalCetak)->format('d M Y') }}
        </div>
    </header>

    <div class="periode">
        <strong>Periode:</strong> {{ \Carbon\Carbon::parse($periode['mulai'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($periode['sampai'])->format('d M Y') }}
    </div>

    @if(count($pengeluarans) > 0)
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 25%;">Kategori</th>
                <th style="width: 35%;">Keterangan</th>
                <th style="width: 20%;" class="text-right">Total Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($pengeluarans as $index => $pengeluaran)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($pengeluaran->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $pengeluaran->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $pengeluaran->keterangan }}</td>
                    <td class="text-right">Rp {{ number_format($pengeluaran->total_pengeluaran, 0, ',', '.') }}</td>
                </tr>
                @php $total += $pengeluaran->total_pengeluaran; @endphp
            @endforeach
            <tr class="total-row">
                <td colspan="4" class="text-right">Total</td>
                <td class="text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    @else
        <div class="no-data">Tidak ada data pengeluaran untuk periode ini.</div>
    @endif

</body>
</html>
