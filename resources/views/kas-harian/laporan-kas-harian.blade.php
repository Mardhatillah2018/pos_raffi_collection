<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kas Harian</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background: #f2f2f2; }
        h2, h4 { margin: 0; text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2>Laporan Kas Harian</h2>
    <h4>Cabang: {{ $cabang }}</h4>
    <h4>Periode: {{ \Carbon\Carbon::parse($tanggal_mulai)->format('d-m-Y') }}
        s/d {{ \Carbon\Carbon::parse($tanggal_sampai)->format('d-m-Y') }}
    </h4>
    <br>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Setor</th>
                <th>Saldo Akhir</th>
            </tr>
        </thead>
        <tbody>
            @php $totalSetor = 0; @endphp
            @forelse($kasHarians as $index => $kas)
                @php $totalSetor += $kas->setor; @endphp
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($kas->tanggal)->format('d-m-Y') }}</td>
                    <td class="text-right">Rp {{ number_format($kas->setor, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($kas->saldo_akhir, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Tidak ada data kas harian pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        @if($kasHarians->count() > 0)
        <tfoot>
            <tr>
                <th colspan="2" class="text-right">Total Setoran</th>
                <th class="text-right">Rp {{ number_format($totalSetor, 0, ',', '.') }}</th>
                <th></th>
            </tr>
        </tfoot>
        @endif
    </table>

</body>
</html>
