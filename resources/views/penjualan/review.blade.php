@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <form action="{{ route('penjualan.konfirmasi') }}" method="POST">
        @csrf
        <input type="hidden" name="no_faktur" value="{{ $no_faktur }}">
        <input type="hidden" name="tanggal_penjualan" value="{{ $tanggal_penjualan }}">
        <input type="hidden" name="total_harga" value="{{ $total_harga }}">

        <div class="card shadow">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="bi bi-receipt-cutoff me-2"></i>Review Penjualan
            </div>
            <div class="card-body">
                <p><strong>No Faktur:</strong> {{ $no_faktur }}</p>
                <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($tanggal_penjualan)->format('d-m-Y') }}</p>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Ukuran</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produkDetails as $detail)
                            <tr>
                                <td>{{ $detail['produk'] }}</td>
                                <td>{{ $detail['ukuran'] }}</td>
                                <td>
                                    {{ $detail['qty'] }}
                                    <input type="hidden" name="detail_produk_id[]" value="{{ $detail['detail_produk_id'] }}">
                                    <input type="hidden" name="qty[]" value="{{ $detail['qty'] }}">
                                    <input type="hidden" name="harga_satuan[]" value="{{ $detail['harga'] }}">
                                </td>
                                <td>Rp {{ number_format($detail['harga'], 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($detail['subtotal'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-end mt-3">
                    <h5>Total: <strong class="text-success">Rp {{ number_format($total_harga, 0, ',', '.') }}</strong></h5>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-between">
                <a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
                <button type="submit" class="btn btn-success"><i class="bi bi-check-circle me-1"></i>Konfirmasi & Simpan</button>
            </div>
        </div>
    </form>
</div>
@endsection
