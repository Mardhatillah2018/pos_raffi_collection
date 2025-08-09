<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2, h4 { text-align: center; margin: 0; }
        .tanggal-cetak { text-align: center; font-size: 13px; margin-top: 5px; }
        .periode { margin: 20px 0 10px; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: center; }
        th { background-color: #f2f2f2; }
        .text-end { text-align: right; }
        .no-data { margin-top: 20px; text-align: center; font-style: italic; color: #888; }
    </style>
</head>
<body>

    <header>
        <h2>Laporan Penjualan</h2>
        <h4 style="margin-bottom: 6px">{{ $namaCabang ?? '-' }}</h4>
        <div style="border-bottom: 2px solid #000; width: 100%; margin: 0 auto 10px;"></div>
        <div class="tanggal-cetak">
            Tanggal Cetak: {{ \Carbon\Carbon::parse($tanggalCetak)->translatedFormat('d F Y') }}
        </div>
    </header>

    <div class="periode">
        <strong>Periode:</strong> {{ \Carbon\Carbon::parse($periode['mulai'])->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($periode['sampai'])->translatedFormat('d F Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>No Faktur</th>
                <th>Produk</th>
                <th>Ukuran</th>
                <th>Qty</th>
                <th>Total Harga</th>
                @if (Auth::user()->role === 'super_admin')
                    <th>Modal</th>
                    <th>Laba</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($detailPenjualans as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_penjualan)->format('d-m-Y') }}</td>
                    <td>{{ $item->no_faktur }}</td>
                    <td>{{ $item->nama_produk }}</td>
                    <td>{{ $item->nama_ukuran }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                    @if (Auth::user()->role === 'super_admin')
                        <td>Rp {{ number_format($item->total_modal, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->laba, 0, ',', '.') }}</td>
                    @endif
                </tr>
            @empty
                @php
                    $colspan = Auth::user()->role === 'super_admin' ? 8 : 6;
                @endphp
                <tr>
                    <td colspan="{{ $colspan }}" style="text-align:center;">Tidak ada data penjualan</td>
                </tr>
            @endforelse
        </tbody>

        @if ($detailPenjualans->count() > 0)
        <tfoot>
            <tr style="font-weight:bold; background-color:#f9f9f9;">
                <td colspan="4" style="text-align:right;">Total</td>
                <td>{{ $detailPenjualans->sum('qty') }}</td>
                <td>Rp {{ number_format($detailPenjualans->sum('total_harga'), 0, ',', '.') }}</td>
                @if (Auth::user()->role === 'super_admin')
                    <td>Rp {{ number_format($detailPenjualans->sum('total_modal'), 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($detailPenjualans->sum('laba'), 0, ',', '.') }}</td>
                @endif
            </tr>
        </tfoot>
        @endif
    </table>

</body>
</html>

