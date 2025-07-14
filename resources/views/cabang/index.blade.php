@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Daftar Cabang</h5>
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalCabang">
                + Tambah Cabang
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
                <table id="datatable" class="table table-hover align-items-center mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Kode Cabang</th>
                            <th scope="col">Nama Cabang</th>
                            {{-- <th scope="col">Jam Buka</th>
                            <th scope="col">Jam Tutup</th> --}}
                            <th scope="col">Alamat</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cabangs as $index => $cabang)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-uppercase fw-semibold">{{ $cabang->kode_cabang }}</td>
                                <td>{{ $cabang->nama_cabang }}</td>
                                {{-- <td>{{ \Carbon\Carbon::parse($cabang->jam_buka)->format('H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($cabang->jam_tutup)->format('H:i') }}</td> --}}
                                <td>{{ Str::limit($cabang->alamat, 15, '...') }}</td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <button
                                            class="btn btn-info btn-sm d-flex align-items-center px-2 py-1"
                                            title="Detail"
                                            style="line-height: 1;"
                                            onclick='openDetailCabangModal(@json($cabang))'>
                                            <i class="material-icons-round text-white me-1" style="font-size: 16px;">info</i>
                                            <span class="text-white fw-semibold small">Detail</span>
                                        </button>
                                        <button
                                            class="btn btn-warning btn-sm d-flex align-items-center px-2 py-1"
                                            title="Edit"
                                            style="line-height: 1;"
                                            onclick='openEditCabangModal(@json($cabang))'>
                                            <i class="material-icons-round text-white me-1" style="font-size: 16px;">edit</i>
                                            <span class="text-white fw-semibold small">Edit</span>
                                        </button>

                                        <form action="#" method="POST" class="m-0 p-0 d-inline-block"
                                            onsubmit="return confirm('Yakin ingin menghapus cabang ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="button"
                                                onclick="openDeleteCabangModal({{ $cabang->id }})"
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
                                <td colspan="7" class="text-center text-muted">Belum ada cabang</td>
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
    @include('cabang.modal-create')
    @include('cabang.modal-edit')
    @include('cabang.modal-delete')
    @include('cabang.modal-detail')
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

    {{-- @if ($errors->any())
        <script>
            let errorMessages = '';
            @foreach ($errors->all() as $error)
                errorMessages += '• {{ $error }}\n';
            @endforeach

            Swal.fire({
                icon: 'error',
                title: 'Gagal menyimpan!',
                text: errorMessages,
                customClass: {
                    popup: 'text-start'
                }
            });

            const modalTambah = new bootstrap.Modal(document.getElementById('modalCabang'));
            modalTambah.show();
        </script>
    @endif --}}

@endpush
