@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Daftar Pengurangan Stok</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-hover align-items-center mb-0 align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Produk</th>
                            <th>Qty</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            @if (Auth::user()->role === 'super_admin')
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logStoks as $index => $log)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ $log->created_at->format('d-m-Y') }}</td>
                                <td>{{ $log->detailProduk->produk->nama_produk ?? '-' }} - {{ $log->detailProduk->ukuran->nama_ukuran ?? '-' }}</td>
                                <td class="text-center">{{ $log->qty }}</td>
                                <td>{{ $log->keterangan ?? '-' }}</td>
                                <td class="text-center">
                                    @if ($log->status == 'menunggu')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif ($log->status == 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif ($log->status == 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                @if (Auth::user()->role === 'super_admin')
                                    <td class="text-center">
                                        @if($log->status == 'menunggu')
                                            <span
                                                class="badge bg-primary text-white"
                                                style="cursor: pointer;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalKonfirmasi{{ $log->id }}"
                                                title="Proses Pengurangan"
                                            >
                                                <i class="fas fa-cogs me-1"></i> Proses
                                            </span>
                                        @else
                                            <span class="badge bg-secondary"><i class="fas fa-cogs me-1"></i> Proses</span>
                                        @endif
                                    </td>

                                    {{-- modal konfirmasi --}}
                                    <div class="modal fade" id="modalKonfirmasi{{ $log->id }}" tabindex="-1" aria-labelledby="modalKonfirmasiLabel{{ $log->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                            <div class="modal-header" style="background-color: #8B0000; color: white;">
                                                <h5 class="modal-title" id="modalKonfirmasiLabel{{ $log->id }}" style="color: white;">
                                                    <i class="fas fa-exclamation-circle me-2"></i>Konfirmasi Pengurangan Stok
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="mb-3 fs-6 text-dark fw-bold">Anda yakin ingin memproses pengurangan stok berikut?</p>

                                                <div class="border rounded p-3 bg-light text-dark text-sm">
                                                    <div class="row mb-2">
                                                        <div class="col-4 fw-bold">Produk</div>
                                                        <div class="col-8">
                                                            {{ $log->detailProduk->produk->nama_produk ?? '-' }} - {{ $log->detailProduk->ukuran->nama_ukuran ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-4 fw-bold">Qty</div>
                                                        <div class="col-8">{{ $log->qty }}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4 fw-bold">Keterangan</div>
                                                        <div class="col-8">{{ $log->keterangan ?? '-' }}</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <form action="{{ route('pengurangan.ubah-status', $log->id) }}" method="POST" id="formUbahStatus-{{ $log->id }}">
                                                    @csrf
                                                    <input type="hidden" name="status" id="statusInput-{{ $log->id }}">

                                                    <button type="button" class="btn btn-success" onclick="submitStatus('{{ $log->id }}', 'disetujui')">
                                                        <i class="fas fa-check me-1"></i>Setujui
                                                    </button>
                                                    <button type="button" class="btn btn-danger" onclick="submitStatus('{{ $log->id }}', 'ditolak')">
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

@push('scripts')
<script>
    function submitStatus(id, status) {
        document.getElementById('statusInput-' + id).value = status;
        document.getElementById('formUbahStatus-' + id).submit();
    }

    @if (session('status_pengurangan'))
        Swal.fire({
            icon: '{{ session("status_pengurangan")["tipe"] }}',
            title: '{{ session("status_pengurangan")["judul"] }}',
            text: '{{ session("status_pengurangan")["pesan"] }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        });
    @endif

    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('modalKurangiStok');
        if (modal) {
            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const produkId = button.getAttribute('data-id');
                const namaProduk = button.getAttribute('data-nama');
                modal.querySelector('#kurangDetailProdukId').value = produkId;
                modal.querySelector('#kurangNamaProduk').value = namaProduk;
            });
        }
    });

</script>
@endpush



