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
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">No Faktur</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 15%;">Total Qty</th>
                <th style="width: 25%;">Total Harga</th>
                <th style="width: 25%;">Dibuat Oleh</th>
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
                    <td colspan="6" class="no-data">Tidak ada data penjualan untuk periode ini.</td>
                </tr>
            @endforelse

            @if(count($penjualans) > 0)
                {{-- Hitung total seluruh qty dan total harga --}}
                @php
                    $totalQty = $penjualans->sum(function($p) {
                        return $p->detailPenjualans->sum('qty');
                    });
                    $totalHarga = $penjualans->sum('total_harga');
                @endphp

                <tr>
                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                    <td><strong>{{ $totalQty }}</strong></td>
                    <td class="text-end"><strong>Rp {{ number_format($totalHarga, 0, ',', '.') }}</strong></td>
                    <td></td>
                </tr>
            @endif
        </tbody>

    </table>

</body>
</html>
