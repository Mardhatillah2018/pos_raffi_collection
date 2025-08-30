@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-gradient-dark fw-bold">
            <h6 class="mb-0" style="color: white">Daftar Pengajuan Pengeluaran</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-hover align-items-center mb-0 align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Total</th>
                            <th>Keterangan</th>
                            <th>Diajukan Oleh</th>
                            <th>Status</th>
                            @if (Auth::user()->role === 'super_admin')
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengeluarans as $index => $p)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}</td>
                                <td>{{ $p->kategori->nama_kategori ?? '-' }}</td>
                                <td class="text-end">Rp {{ number_format($p->total_pengeluaran, 0, ',', '.') }}</td>
                                <td style="max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"
    title="{{ $p->keterangan }}">
    {{ Str::limit($p->keterangan, 30, '...') }}
</td>

                                <td>{{ $p->user->nama }}</td>
                                <td class="text-center">
                                    @if ($p->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif ($p->status == 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif ($p->status == 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>

                                @if (Auth::user()->role === 'super_admin')
                                    <td class="text-center">
                                        @if($p->status == 'pending')
                                            <span
                                                class="badge bg-primary text-white"
                                                style="cursor: pointer;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalKonfirmasi{{ $p->id }}"
                                                title="Proses Pengeluaran"
                                            >
                                                <i class="fas fa-cogs me-1"></i> Proses
                                            </span>
                                        @else
                                            <span class="badge bg-secondary"><i class="fas fa-cogs me-1"></i> Proses</span>
                                        @endif
                                    </td>

                                    {{-- modal konfirmasi --}}
                                    <div class="modal fade" id="modalKonfirmasi{{ $p->id }}" tabindex="-1" aria-labelledby="modalKonfirmasiLabel{{ $p->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header" style="background-color: #b03939; color: white;">
                                                    <h5 class="modal-title" id="modalKonfirmasiLabel{{ $p->id }}" style="color: white;">
                                                        <i class="fas fa-exclamation-circle me-2"></i>Konfirmasi Pengeluaran
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="mb-3 fs-6 text-dark fw-bold">Anda yakin ingin memproses pengeluaran berikut?</p>

                                                    <div class="border rounded p-3 bg-light text-dark text-sm">
                                                        <div class="row mb-2">
                                                            <div class="col-4 fw-bold">Tanggal</div>
                                                            <div class="col-8">{{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-4 fw-bold">Kategori</div>
                                                            <div class="col-8">{{ $p->kategori->nama_kategori ?? '-' }}</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-4 fw-bold">Total</div>
                                                            <div class="col-8">Rp {{ number_format($p->total_pengeluaran, 0, ',', '.') }}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-4 fw-bold">Keterangan</div>
                                                            <div class="col-8">{{ $p->keterangan ?? '-' }}</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <form action="{{ route('pengeluaran.ubah-status', $p->id) }}" method="POST" id="formUbahStatus-{{ $p->id }}">
                                                        @csrf
                                                        @method('PUT') {{-- kalau route pakai PUT --}}
                                                        <input type="hidden" name="status" id="statusInput-{{ $p->id }}">

                                                        <button type="button" class="btn btn-success" onclick="submitStatus('{{ $p->id }}', 'approved')">
                                                            <i class="fas fa-check me-1"></i>Setujui
                                                        </button>
                                                        <button type="button" class="btn btn-danger" onclick="submitStatus('{{ $p->id }}', 'rejected')">
                                                            <i class="fas fa-times me-1"></i>Tolak
                                                        </button>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </tr>
                        @empty
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            @if (Auth::user()->role === 'super_admin')
                                <td class="text-center">-</td>
                            @endif
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function submitStatus(id, status) {
        document.getElementById('statusInput-' + id).value = status;
        document.getElementById('formUbahStatus-' + id).submit();
    }

    @if (session('status_pengeluaran'))
        Swal.fire({
            icon: '{{ session("status_pengeluaran")["tipe"] }}',
            title: '{{ session("status_pengeluaran")["judul"] }}',
            text: '{{ session("status_pengeluaran")["pesan"] }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
</script>
@endpush
