<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Gaji Karyawan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        h2, h4 {
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .info {
            margin-top: 10px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 6px;
            border: 1px solid #000;
            text-align: left;
        }
        .text-end {
            text-align: right;
        }
    </style>
</head>
<body>
    <h2>LAPORAN GAJI KARYAWAN</h2>
    <h4>Cabang: {{ $cabang }}</h4>

    <div class="info">
        <p>Periode: {{ \Carbon\Carbon::parse($tanggalAwal)->translatedFormat('F Y') }}</p>
        <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Jabatan</th>
                <th>Tanggal</th>
                <th>Total Gaji</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($gajis as $index => $gaji)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $gaji->karyawan->nama }}</td>
                    <td>{{ $gaji->karyawan->jabatan }}</td>
                    <td>{{ \Carbon\Carbon::parse($gaji->tanggal)->translatedFormat('d M Y') }}</td>
                    <td class="text-end">Rp {{ number_format($gaji->total_gaji, 0, ',', '.') }}</td>
                    <td>{{ $gaji->keterangan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data gaji pada bulan ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <br><br>
    <div style="text-align: right;">
        <p>Dicetak oleh: {{ auth()->user()->nama ?? 'Admin' }}</p>
    </div>
</body>
</html>
