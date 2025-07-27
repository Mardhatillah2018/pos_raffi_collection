@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="fw-bold">Detail Stok Produk</h5>
            <small class="text-muted">
                {{ $produk->nama_produk }}
            </small>
        </div>
        <div class="card-body">
            <table id="datatable" class="table table-hover align-items-center mb-0">
                <thead class="table-light text-centerx">
                    <tr>
                        <th>No</th>
                        <th>Ukuran</th>
                        <th>Total Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailProduks as $detail)
                        @php
                            $stok = $stokList->where('detail_produk_id', $detail->id)->sum('stok');
                        @endphp
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $detail->ukuran->nama_ukuran }}</td>
                            <td>{{ $stok }}</td>
                            <td>
                                <button class="btn btn-success btn-sm px-2 py-1"
                                    onclick=""
                                    title="Tambah Stok">
                                    <i class="material-icons-round text-white">add</i>
                                    <span class="text-white fw-semibold small">Tambah</span>
                                </button>

                                <button class="btn btn-danger btn-sm px-2 py-1"
                                    onclick=""
                                    title="Kurangi Stok">
                                    <i class="material-icons-round text-white">remove</i>
                                    <span class="text-white fw-semibold small">Kurang</span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white text-end">
            <a href="{{ route('stok.index') }}" class="btn btn-sm btn-secondary d-inline-flex align-items-center">
                <i class="material-icons-round me-1" style="font-size: 16px;">arrow_back</i>
                Kembali
            </a>
        </div>

    </div>
</div>
@endsection
