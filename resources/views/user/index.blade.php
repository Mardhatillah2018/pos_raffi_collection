@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Daftar User</h5>
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalUser">
                + Tambah User
            </button>
        </div>

        <div class="card-body">
            {{-- @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif --}}

            <div class="table-responsive">
                <table id="datatable" class="table  table-hover align-items-center mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Kode Cabang</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    <h6 class="mb-0 text-sm fw-bold">{{ $user->nama }}</h6>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td class="text-capitalize">{{ $user->role }}</td>
                                <td>{{ $user->kode_cabang ?? '-' }}</td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <button
                                            class="btn btn-warning btn-sm d-flex align-items-center px-2 py-1"
                                            title="Edit"
                                            style="line-height: 1;"
                                            onclick='openEditModal(@json($user))'>
                                            <i class="material-icons-round text-white me-1" style="font-size: 16px;">edit</i>
                                            <span class="text-white fw-semibold small">Edit</span>
                                        </button>

                                        <form action="#" method="POST" class="m-0 p-0 d-inline-block"
                                            onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="button"
                                                onclick="openDeleteModal({{ $user->id }})"
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
                                <td colspan="6" class="text-center text-muted">Belum ada user</td>
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
    @include('user.modal-create')
    @include('user.modal-edit')
    @include('user.modal-delete')
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
