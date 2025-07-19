@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Daftar Karyawan</h5>
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalKaryawan">
                + Tambah Karyawan
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-hover align-items-center mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">No HP</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Kode Cabang</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($karyawans as $karyawan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $karyawan->nama }}</td>
                                <td>{{ $karyawan->no_hp }}</td>
                                <td>{{ $karyawan->alamat }}</td>
                                <td>{{ $karyawan->cabang->kode_cabang ?? '-' }}</td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button
                                            class="btn btn-warning btn-sm d-flex align-items-center px-2 py-1"
                                            title="Edit"
                                            onclick='openEditModal(@json($karyawan))'
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEditKaryawan">
                                            <i class="material-icons-round text-white me-1" style="font-size: 16px;">edit</i>
                                            <span class="text-white fw-semibold small">Edit</span>
                                        </button>
                                        <button
                                            type="button"
                                            onclick="openDeleteKaryawanModal({{ $karyawan->id }})"
                                            class="btn btn-danger btn-sm d-flex align-items-center px-2 py-1"
                                            title="Hapus">
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
    @include('karyawan.modal-create')
    @include('karyawan.modal-edit')
    @include('karyawan.modal-delete')
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
