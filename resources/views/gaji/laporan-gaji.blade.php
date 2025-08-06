<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Gaji Karyawan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 30px;
        }
        h2, h4 {
            text-align: center;
            margin: 0;
        }
        .garis-bawah {
            border-bottom: 2px solid #000;
            width: 100%;
            margin: 6px auto 10px;
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
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .printed {
            font-size: 11px;
            margin-top: 10px;
            text-align: right;
        }
    </style>
</head>
<body>

    <header>
        <h2>Laporan Gaji Karyawan</h2>
        <h4 style="margin-bottom: 6px;">{{ $namaCabang }}</h4>
        <div class="garis-bawah"></div>
        <div class="tanggal-cetak">
            Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}
        </div>
    </header>

    <div class="periode">
        <strong>Periode:</strong> {{ $periode }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Jenis Gaji</th>
                <th>Tanggal Dibayar</th>
                <th class="text-right">Gaji Pokok</th>
                <th class="text-right">Bonus</th>
                <th class="text-right">Total Dibayar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalGajiPokok = 0;
                $totalBonus = 0;
                $totalDibayar = 0;
            @endphp

            @forelse ($gajis as $index => $gaji)
                @php
                    $totalGajiPokok += $gaji->gaji_pokok;
                    $totalBonus += $gaji->bonus;
                    $totalDibayar += $gaji->jumlah_dibayar;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $gaji->karyawan->nama ?? '-' }}</td>
                    <td>{{ ucfirst($gaji->jenis_gaji) }}</td>
                    <td>{{ \Carbon\Carbon::parse($gaji->tanggal_dibayar)->format('d-m-Y') }}</td>
                    <td class="text-right">Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($gaji->bonus, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($gaji->jumlah_dibayar, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($gaji->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Data gaji tidak ditemukan</td>
                </tr>
            @endforelse

            @if($gajis->count())
                <tr class="total-row">
                    <td colspan="4" class="text-center">Total</td>
                    <td class="text-right">Rp {{ number_format($totalGajiPokok, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($totalBonus, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($totalDibayar, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            @endif
        </tbody>
    </table>

</body>
</html>
