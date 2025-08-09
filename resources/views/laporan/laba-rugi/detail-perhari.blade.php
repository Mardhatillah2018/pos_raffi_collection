@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white fw-bold">
            Laporan Laba Rugi Per Hari - {{ $namaBulan }}
        </div>
        <div class="card-body">
            <a href="{{ route('laba-rugi.index') }}" class="btn btn-secondary mb-3">← Kembali</a>
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered text-center">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Total Produk Terjual</th>
                            <th>Total Penjualan</th>
                            <th>Laba Kotor</th>
                            <th>Pengeluaran</th>
                            <th>Laba Bersih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rekapPerHari as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item['tanggal'] }}</td>
                                <td>{{ $item['total_produk'] }}</td>
                                <td>Rp {{ number_format($item['total_penjualan'], 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item['laba_kotor'], 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item['pengeluaran'], 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item['laba_bersih'], 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
