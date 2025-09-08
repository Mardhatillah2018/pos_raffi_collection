@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-gradient-dark fw-bold">
            <h6 class="mb-0" style="color: white">Kas Harian</h6>
        </div>

        <div class="card-body">
            @if (Auth::user()->role === 'admin_cabang')
                <div class="px-3 py-2 mb-0 d-flex justify-content-end">
                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalKasHarian">
                        + Tambah Setoran
                    </button>
                </div>
            @endif

            <div class="table-responsive">
                <table id="datatable" class="table table-hover align-items-center mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Setor</th>
                            <th>Saldo Akhir</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kasHarians as $index => $kas)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($kas->tanggal)->format('d-m-Y') }}</td>
                                <td class="text-end">Rp {{ number_format($kas->setor, 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($kas->saldo_akhir, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if ($kas->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif ($kas->status == 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        {{-- Tombol Detail --}}
                                        <button
                                            class="btn btn-info btn-sm d-flex align-items-center px-2 py-1"
                                            title="Detail"
                                            style="line-height: 1;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detailKas{{ $kas->id }}">
                                            <i class="material-icons-round text-white me-1" style="font-size: 16px;">info</i>
                                            <span class="text-white fw-semibold small">Detail</span>
                                        </button>

                                        @if (Auth::user()->role === 'super_admin')
                                        {{-- Tombol Proses (hanya kalau status pending) --}}
                                            @if($kas->status == 'pending')
                                                <button
                                                    class="btn btn-primary btn-sm d-flex align-items-center px-2 py-1"
                                                    title="Proses Kas Harian"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalProsesKas{{ $kas->id }}"
                                                    style="line-height: 1;"
                                                >
                                                    <i class="fas fa-cogs me-1" style="font-size: 16px;"></i>
                                                    <span class="text-white fw-semibold small">Proses</span>
                                                </button>
                                            @else
                                                <button class="btn btn-secondary btn-sm d-flex align-items-center px-2 py-1" disabled style="line-height: 1;">
                                                    <i class="fas fa-cogs me-1" style="font-size: 16px;"></i>
                                                    <span class="text-white fw-semibold small">Proses</span>
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                                {{-- modal --}}
                                <div class="modal fade" id="modalProsesKas{{ $kas->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-md modal-dialog-centered">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-gradient-danger text-white">
                                                <h5 class="modal-title fw-semibold text-white">
                                                    <i class="fas fa-cogs me-2"></i> Proses Kas Harian
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('kas-harian.proses', $kas->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-body">
                                                    <p class="mb-0">
                                                        Apakah Anda ingin <strong>menyetujui</strong> setoran kas tanggal
                                                        <strong>{{ \Carbon\Carbon::parse($kas->tanggal)->format('d-m-Y') }}</strong>
                                                        dengan jumlah setor <strong>Rp {{ number_format($kas->setor, 0, ',', '.') }}</strong>?
                                                    </p>
                                                </div>

                                                <div class="modal-footer bg-light">
                                                    <button type="submit" name="status" value="approved" class="btn btn-success">
                                                        <i class="fas fa-check me-1"></i> Approve
                                                    </button>
                                                    <button type="submit" name="status" value="rejected" class="btn btn-danger">
                                                        <i class="fas fa-times me-1"></i> Reject
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


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
    @include('kas-harian.modal-create')
    @include('kas-harian.modal-detail')
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
