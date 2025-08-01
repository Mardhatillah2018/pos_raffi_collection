@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-info text-white fw-bold">
            <i class="bi bi-receipt me-2"></i>Detail Penjualan
        </div>
        <div class="card-body">
            <p><strong>No Faktur:</strong> {{ $penjualan->no_faktur }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($penjualan->tanggal_penjualan)->format('d-m-Y') }}</p>

            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Produk</th>
                        <th>Ukuran</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualan->detailPenjualans as $detail)
                        <tr>
                            <td>{{ $detail->detailProduk->produk->nama_produk ?? '-' }}</td>
                            <td>{{ $detail->detailProduk->ukuran->nama_ukuran ?? '-' }}</td>
                            <td>{{ $detail->qty }}</td>
                            <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($detail->harga_satuan * $detail->qty, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-end mt-3">
                <h5>Total: <strong class="text-success">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</strong></h5>
            </div>
        </div>

        <div class="card-footer text-end">
            <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
