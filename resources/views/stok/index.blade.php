@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Daftar Stok Produk</h5>
            <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahStok">
                + Tambah Stok Manual
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-hover align-items-center mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produkStok as $index => $stok)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $stok->nama_produk }}</td>
                            <td class="text-center">{{ $stok->total_stok }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <a href="{{ route('stok.show', $stok->produk_id) }}"
                                        class="btn btn-info btn-sm d-flex align-items-center px-2 py-1"
                                        title="Detail">
                                            <i class="material-icons-round text-white me-1" style="font-size: 16px;">info</i>
                                            <span class="text-white fw-semibold small">Detail</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modals')
    @include('stok.modal-create')
    @include('stok.modal-tambah-stok')
    @include('stok.modal-kurang-stok')
@endpush
