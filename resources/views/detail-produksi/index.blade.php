@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                Detail Produksi - Tanggal: {{ $produksi->tanggal_produksi }}
            </h5>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <p><strong>Cabang:</strong> {{ $produksi->cabang->nama_cabang ?? '-' }}</p>
                <p><strong>Dibuat oleh:</strong> {{ $produksi->user->nama ?? '-' }}</p>
                <p><strong>Total Biaya:</strong> Rp{{ number_format($produksi->total_biaya, 0, ',', '.') }}</p>
                <p><strong>Keterangan:</strong> {{ $produksi->keterangan ?? '-' }}</p>
            </div>

            <hr>

            <h6 class="fw-bold">Daftar Produk yang Diproduksi</h6>
            @if ($produksi->detailProduksis->isEmpty())
                <p class="text-muted">Tidak ada data produk yang diproduksi.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered mt-3">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th>Nama Produk</th>
                                <th>Ukuran</th>
                                <th>Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produksi->detailProduksis as $index => $detail)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $detail->detailProduk->produk->nama_produk ?? '-' }}</td>
                                    <td>{{ $detail->detailProduk->ukuran->kode_ukuran ?? '-' }}</td>
                                    <td>{{ $detail->qty }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="card-footer text-end">
            <a href="{{ route('produksi.index') }}" class="btn btn-secondary btn-sm">
                ← Kembali
            </a>
        </div>
    </div>
</div>
@endsection
