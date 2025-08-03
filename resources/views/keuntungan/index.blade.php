@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white fw-bold">
            Laporan Keuntungan Per Bulan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover text-center">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Bulan</th>
                            <th>Total Produk Terjual</th>
                            <th>Total Penjualan</th>
                            <th>Laba Kotor</th>
                            <th>Pengeluaran</th>
                            <th>Laba Bersih</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rekap as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item['bulan'] }}</td>
                                <td>{{ $item['total_produk'] }}</td>
                                <td>Rp {{ number_format($item['total_penjualan'], 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item['laba_kotor'], 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item['pengeluaran'], 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item['laba_bersih'], 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('keuntungan.show', $item['raw_bulan']) }}"
                                    class="btn btn-info btn-sm d-flex align-items-center px-2 py-1"
                                    title="Detail"
                                    style="line-height: 1;">
                                        <i class="material-icons-round text-white me-1" style="font-size: 16px;">info</i>
                                        <span class="text-white fw-semibold small">Detail</span>
                                    </a>
                                </td>

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
