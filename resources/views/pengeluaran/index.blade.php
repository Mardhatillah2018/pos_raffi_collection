@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
       <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Daftar Pengeluaran</h5>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#modalCetak">
                    <i class="bi bi-printer me-1" style="font-size: 0.9rem;"></i>
                    Cetak
                </button>

                <a href="{{ route('kategori-pengeluaran.index') }}" class="btn btn-primary btn-sm">
                    Kategori Pengeluaran
                </a>

                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalPengeluaran">
                    + Tambah Pengeluaran
                </button>
            </div>
        </div>

        <!-- Modal Cetak -->
        <div class="modal fade" id="modalCetak" tabindex="-1" aria-labelledby="modalCetakLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('pengeluaran.cetak') }}" method="GET" target="_blank" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCetakLabel">Cetak Laporan Pengeluaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                    </div>
                    <div class="mb-3">
                    <label for="tanggal_sampai" class="form-label">Tanggal Sampai</label>
                    <input type="date" class="form-control" id="tanggal_sampai" name="tanggal_sampai" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                    <i class="bi bi-printer me-1"></i> Cetak PDF
                    </button>
                </div>
                </form>
            </div>
        </div>


        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-hover align-items-center mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Total</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengeluarans as $index => $pengeluaran)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ $pengeluaran->tanggal }}</td>
                                <td>{{ $pengeluaran->kategori->nama_kategori }}</td>
                                <td class="text-end">Rp {{ number_format($pengeluaran->total_pengeluaran, 0, ',', '.') }}</td>
                                <td>{{ $pengeluaran->keterangan }}</td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <button
                                            class="btn btn-warning btn-sm d-flex align-items-center px-2 py-1"
                                            title="Edit"
                                            style="line-height: 1;"
                                            onclick='openEditPengeluaranModal(@json($pengeluaran))'>
                                            <i class="material-icons-round text-white me-1" style="font-size: 16px;">edit</i>
                                            <span class="text-white fw-semibold small">Edit</span>
                                        </button>

                                        <form action="#" method="POST" class="m-0 p-0 d-inline-block"
                                            onsubmit="return confirm('Yakin ingin menghapus pengeluaran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="button"
                                                onclick="openDeletePengeluaranModal({{ $pengeluaran->id }})"
                                                class="btn btn-danger btn-sm d-flex align-items-center px-2 py-1"
                                                title="Hapus"
                                                style="line-height: 1;">
                                                <i class="material-icons-round text-white me-1" style="font-size: 16px;">delete</i>
                                                <span class="text-white fw-semibold small">Hapus</span>
                                            </button>
                                        </form>
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
    @include('pengeluaran.modal-create')
    @include('pengeluaran.modal-edit')
    @include('pengeluaran.modal-delete')
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
