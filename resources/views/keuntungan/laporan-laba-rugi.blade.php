<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuntungan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2, h4 { text-align: center; margin: 0; }
        .info { margin: 5px 0 20px; font-size: 13px; text-align: center; }
        .section-title { font-weight: bold; margin-top: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-end { text-align: right; }
        .no-data { margin-top: 20px; text-align: center; font-style: italic; color: #888; }
        hr { margin: 30px 0; }
    </style>
</head>
<body>

    <header>
        <h2>Laporan Keuntungan</h2>
        <h4 style="margin-bottom: 6px">{{ $namaCabang }}</h4>
        <div style="border-bottom: 2px solid #000; width: 100%; margin: 0 auto 10px;"></div>
        <div class="info">
            Tanggal Cetak: {{ $tanggalCetak }}
        </div>
    </header>

    @if(count($rekap) > 0)
        @foreach ($rekap as $data)
            <div class="section-title">Periode: {{ $data['bulan'] }}</div>

            <table>
                <tr>
                    <th colspan="2">Pendapatan</th>
                </tr>
                <tr>
                    <td>Penjualan</td>
                    <td class="text-end">Rp {{ number_format($data['total_penjualan'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Harga Modal</td>
                    <td class="text-end">Rp {{ number_format($data['total_modal'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td><strong>Laba Kotor</strong></td>
                    <td class="text-end"><strong>Rp {{ number_format($data['laba_kotor'], 0, ',', '.') }}</strong></td>
                </tr>
            </table>

            @if (count($data['beban']) > 0)
                <table>
                    <tr>
                        <th colspan="2">Beban</th>
                    </tr>
                    @foreach ($data['beban'] as $beban)
                        <tr>
                            <td>{{ $beban['kategori'] }}</td>
                            <td class="text-end">Rp {{ number_format($beban['jumlah'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td><strong>Total Beban</strong></td>
                        <td class="text-end"><strong>Rp {{ number_format($data['total_beban'], 0, ',', '.') }}</strong></td>
                    </tr>
                </table>
            @endif

            <table>
                <tr>
                    <td><strong>Laba Bersih</strong></td>
                    <td class="text-end"><strong>Rp {{ number_format($data['laba_bersih'], 0, ',', '.') }}</strong></td>
                </tr>
            </table>
            <hr>
        @endforeach
    @else
        <div class="no-data">Tidak ada data untuk periode yang dipilih.</div>
    @endif

</body>
</html>
