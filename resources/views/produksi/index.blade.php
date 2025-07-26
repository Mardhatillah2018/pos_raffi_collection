@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Daftar Produksi</h5>
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalProduksi">
                + Tambah Produksi
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-hover align-items-center mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Produksi</th>
                            <th>Total Biaya</th>
                            <th>Total Qty</th>
                            <th>Dibuat Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produksis as $index => $produksi)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ $produksi->tanggal_produksi }}</td>
                                <td class="text-end">Rp {{ number_format($produksi->total_biaya, 0, ',', '.') }}</td>
                                <td>{{ $produksi->detailProduksis->sum('qty') }}</td>

                                <td class="text-center">{{ $produksi->user->nama ?? '-' }}</td>

                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="{{ route('produksi.detail', $produksi->id) }}"
                                            class="btn btn-info btn-sm d-flex align-items-center px-2 py-1"
                                            title="Detail"
                                            style="line-height: 1;">
                                                <i class="material-icons-round text-white me-1" style="font-size: 16px;">info</i>
                                                <span class="text-white fw-semibold small">Detail</span>
                                        </a>

                                        <button
                                            class="btn btn-warning btn-sm d-flex align-items-center gap-1 px-2 py-1"
                                            title="Edit"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEditProduksi{{ $produksi->id }}">
                                            <i class="material-icons-round text-white" style="font-size: 16px;">edit</i>
                                            <span class="text-white fw-semibold small">Edit</span>
                                        </button>
                                        <button
                                            class="btn btn-danger btn-sm d-flex align-items-center px-2 py-1"
                                            title="Hapus"
                                            onclick="openDeleteProduksiModal({{ $produksi->id }})">
                                            <i class="material-icons-round text-white me-1" style="font-size: 16px;">delete</i>
                                            <span class="text-white fw-semibold small">Hapus</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
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
    @include('produksi.modal-create')
    @foreach ($produksis as $produksi)
        @include('produksi.modal-edit', ['produksi' => $produksi])
    @endforeach
    @include('produksi.modal-delete')
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
    @endif
</script>
@endpush
