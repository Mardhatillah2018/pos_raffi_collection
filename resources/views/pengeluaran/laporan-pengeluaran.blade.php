<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengeluaran</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 6px; border: 1px solid #000; text-align: left; }
        h2, h4 { margin: 0; padding: 0; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2>LAPORAN PENGELUARAN</h2>
    <h4>Cabang: {{ $namaCabang }}</h4>
    <h4>Periode: {{ \Carbon\Carbon::parse($periode['mulai'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($periode['sampai'])->format('d M Y') }}</h4>
    <h4>Tanggal Cetak: {{ \Carbon\Carbon::parse($tanggalCetak)->format('d M Y') }}</h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th class="text-right">Total Pengeluaran</th>
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
            <tr>
                <th colspan="4" class="text-right">Total</th>
                <th class="text-right">Rp {{ number_format($total, 0, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>
</body>
</html>
