@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white fw-bold">
            Laporan Mutasi Stok - {{ \Carbon\Carbon::createFromDate(null, $bulan)->locale('id')->monthName }} {{ $tahun }}
        </div>
        <div class="card-body">
            <a href="{{ route('mutasi-stok.index') }}" class="btn btn-secondary mb-3">← Kembali</a>
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered text-center">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th style="text-align: left;">Nama Produk</th>
                            <th>Ukuran</th>
                            <th>Harga Modal</th>
                            <th>Harga Jual</th>
                            <th>Stok Awal</th>
                            <th>Stok Masuk</th>
                            <th>Stok Keluar</th>
                            <th>Stok Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dataMutasi as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td style="text-align: left;">{{ $item->nama_produk }}</td>
                                <td>{{ $item->ukuran }}</td>
                                <td>Rp {{ number_format($item->harga_modal, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                                <td>{{ $item->stok_awal }}</td>
                                <td>{{ $item->masuk }}</td>
                                <td>{{ $item->keluar }}</td>
                                <td>{{ $item->stok_akhir }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada data mutasi stok untuk periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
