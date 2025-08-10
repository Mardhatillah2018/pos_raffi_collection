@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-gradient-dark fw-bold">
            <h6 class="mb-0" style="color: white">Daftar Gaji Karyawan</h6>
        </div>

        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center px-3 py-2 mb-0">
                <div>
                    <button class="btn btn-sm" style="background-color: white; border: 1px solid #a20f0f; color: #a20f0f;" data-bs-toggle="modal" data-bs-target="#modalCetakGaji">
                        <i class="bi bi-printer me-1" style="color: #a20f0f; font-size: 0.9rem;"></i>
                        Laporan Gaji
                    </button>
                </div>
                <div>
                    <a href="{{ route('gaji.create') }}" class="btn btn-success btn-sm">
                        + Tambah Gaji
                    </a>
                </div>
            </div>
            {{-- modal cetak gaji --}}
            <div class="modal fade" id="modalCetakGaji" tabindex="-1" aria-labelledby="modalCetakGajiLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-3">
                    <form action="{{ route('gaji.cetak') }}" method="GET" target="_blank">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCetakGajiLabel">Pilih Periode Gaji</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="periode" class="form-label">Periode</label>
                                    <input type="month" class="form-control" id="periode" name="periode" required>
                                {{-- format: 2025-08 --}}
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
            </div>
            <div class="table-responsive">
                <table id="datatable" class="table table-hover align-items-center mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Periode</th>
                            <th>Tanggal Dibayar</th>
                            <th>Jumlah Dibayar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($gajis as $gaji)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $gaji->karyawan->nama ?? '-' }}</td>
                                <td>{{ \Illuminate\Support\Carbon::parse($gaji->periode)->locale('id')->translatedFormat('F Y') }}</td>
                                <td>{{ $gaji->tanggal_dibayar ?? 'Belum Dibayar' }}</td>
                                <td>Rp {{ number_format($gaji->jumlah_dibayar, 0, ',', '.') }}</td>
                                <td>
                                    @if ($gaji->status == 'dibayar')
                                        <span class="badge bg-success">{{ ucfirst($gaji->status) }}</span>
                                    @else
                                        <style>
                                            .badge-hover:hover {
                                                background-color: #fd0d0d !important; /* Bootstrap primary */
                                                color: white !important;
                                            }
                                        </style>

                                        <button class="badge bg-warning border-0 text-dark badge-hover"
                                            data-bs-toggle="modal"
                                            data-bs-target="#bayarModal{{ $gaji->id }}"
                                            style="cursor: pointer;">
                                            {{ ucfirst($gaji->status) }}
                                        </button>

                                    @endif
                                </td>

                                {{-- modal ubah status gaji --}}
                                <div class="modal fade" id="bayarModal{{ $gaji->id }}" tabindex="-1" aria-labelledby="bayarModalLabel{{ $gaji->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content p-3">
                                            <form action="{{ route('gaji.bayar', $gaji->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Bayar Gaji - {{ $gaji->karyawan->nama }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="tanggal_dibayar{{ $gaji->id }}" class="form-label">Tanggal Dibayar</label>
                                                        <input type="date" name="tanggal_dibayar" class="form-control" id="tanggal_dibayar{{ $gaji->id }}" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Bayar Sekarang</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button"
                                            class="btn btn-info btn-sm d-flex align-items-center px-2 py-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $gaji->id }}"
                                            title="Detail"
                                            style="line-height: 1;">
                                            <i class="material-icons-round text-white me-1" style="font-size: 16px;">info</i>
                                            <span class="text-white fw-semibold small">Detail</span>
                                        </button>

                                        {{-- <button
                                            class="btn btn-warning btn-sm d-flex align-items-center px-2 py-1">
                                            <i class="material-icons-round text-white me-1" style="font-size: 16px;">edit</i>
                                            <span class="text-white fw-semibold small">Edit</span>
                                        </button> --}}
                                        {{-- <button
                                            type="button"
                                            class="btn btn-danger btn-sm d-flex align-items-center px-2 py-1"
                                            title="Hapus">
                                            <i class="material-icons-round text-white me-1" style="font-size: 16px;">delete</i>
                                            <span class="text-white fw-semibold small">Hapus</span>
                                        </button> --}}
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
    @include('gaji.modal-detail')
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
