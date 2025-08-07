@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-gradient-dark fw-bold">
            <h6 class="mb-0 text-white">Detail Stok</h6>
            <hr style="border-top: 1px solid rgba(255, 255, 255, 0.3); margin: 4px 0;">
            <small class="text-white">
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
                        @if(auth()->user()->role == 'admin_cabang')
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailProduks as $detail)
                        @php
                            $stok = $stokList->where('detail_produk_id', $detail->id)->sum('stok');
                        @endphp
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $detail->ukuran->kode_ukuran }}</td>
                            <td>{{ $stok }}</td>
                            @if(auth()->user()->role == 'admin_cabang')
                                <td>
                                    {{-- <button class="btn btn-success btn-sm px-2 py-1"
                                        onclick=""
                                        title="Tambah Stok">
                                        <i class="material-icons-round text-white">add</i>
                                        <span class="text-white fw-semibold small">Tambah</span>
                                    </button> --}}

                                    <button class="btn btn-danger btn-sm px-2 py-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalKurangiStok"
                                        data-id="{{ $detail->id }}"
                                        data-nama="{{ $produk->nama_produk }} - Ukuran {{ $detail->ukuran->kode_ukuran }}"
                                        title="Kurangi Stok">
                                        <i class="material-icons-round text-white">remove</i>
                                        <span class="text-white fw-semibold small">Kurang</span>
                                    </button>
                                </td>
                            @endif
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

@push('modals')
    @include('stok.modal-kurang-stok')
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('modalKurangiStok');
        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const produkId = button.getAttribute('data-id');
            const namaProduk = button.getAttribute('data-nama');
            modal.querySelector('#kurangDetailProdukId').value = produkId;
            modal.querySelector('#kurangNamaProduk').value = namaProduk;
        });
    });
</script>
@endpush
