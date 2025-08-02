@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Data Gaji Karyawan</h5>
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalGaji">
                + Tambah Gaji
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-hover align-items-center mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Periode</th>
                            <th>Jenis Gaji</th>
                            <th>Tanggal Dibayar</th>
                            <th>Gaji Pokok</th>
                            <th>Bonus</th>
                            <th>Jumlah Dibayar</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Kode Cabang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($gajis as $gaji)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $gaji->karyawan->nama ?? '-' }}</td>
                                <td>{{ $gaji->periode }}</td>
                                <td>{{ $gaji->jenis_gaji }}</td>
                                <td>{{ $gaji->tanggal_dibayar }}</td>
                                <td>Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($gaji->bonus, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($gaji->jumlah_dibayar, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $gaji->status == 'lunas' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($gaji->status) }}
                                    </span>
                                </td>
                                <td>{{ $gaji->keterangan ?? '-' }}</td>
                                <td>{{ $gaji->cabang->kode_cabang ?? '-' }}</td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button
                                            class="btn btn-warning btn-sm d-flex align-items-center px-2 py-1">
                                            <i class="material-icons-round text-white me-1" style="font-size: 16px;">edit</i>
                                            <span class="text-white fw-semibold small">Edit</span>
                                        </button>
                                        <button
                                            type="button"
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
                                <td colspan="12" class="text-center">Data belum tersedia</td>
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
    @include('gaji.modal-create')
    @include('gaji.modal-edit')
    @include('gaji.modal-delete')
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
