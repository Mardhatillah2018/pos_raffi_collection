@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Detail Produk: {{ $produk->nama_produk }}</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahDetailProduk">
                + Tambah Detail
            </button>

        </div>
        <div class="card-body">

            @if ($produk->detailProduks->isEmpty())
                <p class="text-muted">Tidak ada detail produk.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Ukuran</th>
                                <th>Harga Modal</th>
                                <th>Harga Jual</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produk->detailProduks as $index => $detail)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $detail->ukuran->kode_ukuran ?? '-' }}</td>
                                    <td>Rp{{ number_format($detail->harga_modal, 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format($detail->harga_jual, 0, ',', '.') }}</td>
                                    <td class="d-flex gap-1">

                                        <button
                                            type="button"
                                            class="btn btn-warning btn-sm d-flex align-items-center px-2 py-1"
                                            title="Edit"
                                            style="line-height: 1;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEditDetailProduk{{ $detail->id }}">
                                            <i class="material-icons-round text-white me-1" style="font-size: 16px;">edit</i>
                                            <span class="text-white fw-semibold small">Edit</span>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-danger btn-sm d-flex align-items-center px-2 py-1"
                                            title="Hapus"
                                            style="line-height: 1;"
                                            onclick="openDeleteDetailProdukModal({{ $detail->id }})">
                                            <i class="material-icons-round text-white me-1" style="font-size: 16px;">delete</i>
                                            <span class="text-white fw-semibold small">Hapus</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        <div class="card-footer bg-white text-end">
            <a href="{{ route('produk.index') }}" class="btn btn-sm btn-secondary d-inline-flex align-items-center">
                <i class="material-icons-round me-1" style="font-size: 16px;">arrow_back</i>
                Kembali
            </a>
        </div>

    </div>
</div>

@endsection

@push('modals')
    @include('detail-produk.modal-create')
    @include('detail-produk.modal-edit')
    @include('detail-produk.modal-delete')
@endpush

@push('scripts')
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                showConfirmButton: true,
            });
        @elseif (session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: '{{ session('warning') }}',
                showConfirmButton: true,
            });
        @elseif (session('info'))
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: '{{ session('info') }}',
                showConfirmButton: true,
            });
        @endif
    </script>
@endpush
