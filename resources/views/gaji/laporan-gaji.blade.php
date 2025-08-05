<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Gaji</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        h2, p { margin: 0; padding: 0; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <h2 class="text-center">Laporan Gaji Karyawan</h2>
    <p class="text-center">Periode: {{ $periode }}</p>
    <p class="text-center">Cabang: {{ $namaCabang }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Jenis Gaji</th>
                <th>Tanggal Dibayar</th>
                <th>Gaji Pokok</th>
                <th>Bonus</th>
                <th>Total Dibayar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($gajis as $index => $gaji)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $gaji->karyawan->nama ?? '-' }}</td>
                    <td>{{ ucfirst($gaji->jenis_gaji) }}</td>
                    <td>{{ \Carbon\Carbon::parse($gaji->tanggal_dibayar)->format('d-m-Y') }}</td>
                    <td>Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($gaji->bonus, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($gaji->jumlah_dibayar, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($gaji->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Data gaji tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
