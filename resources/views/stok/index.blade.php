@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-gradient-dark fw-bold">
            <h6 class="mb-0" style="color: white">Daftar Stok Produk</h6>
        </div>

        <div class="card-body">
            @if (Auth::user()->role === 'super_admin')
                <div class="px-3 py-2 mb-0">
                    <button class="btn btn-sm" style="background-color: white; border: 1px solid #a20f0f; color: #a20f0f;" data-bs-toggle="modal" data-bs-target="#modalCetakStok">
                        <i class="bi bi-printer me-1" style="color: #a20f0f; font-size: 0.9rem;"></i>
                        Laporan Stok
                    </button>
                </div>
                {{-- modal cetak --}}
                <div class="modal fade" id="modalCetakStok" tabindex="-1" aria-labelledby="modalCetakStokLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content p-3">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCetakStokLabel">Pilih Jenis Laporan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <div class="d-grid gap-3">
                                    <!-- Section: Cetak Stok Hari Ini -->
                                    <div>
                                        <button id="btnShowCetakStok" class="btn btn-outline-dark w-100" type="button" onclick="showCetakStok()">
                                            <i class="bi bi-printer me-1"></i> Laporan Stok Hari Ini
                                        </button>

                                        <div id="cetakStokWrapper" class="text-center mt-2" style="display: none;">
                                            <a href="{{ route('stok.cetak') }}" target="_blank" class="btn btn-dark">
                                                <i class="bi bi-printer me-1"></i> Cetak Sekarang
                                            </a>
                                        </div>
                                    </div>
                                    <div>
                                        <button id="btnShowMutasi" class="btn btn-outline-dark w-100" type="button" onclick="showFormMutasi()">
                                            <i class="bi bi-calendar-range me-1"></i> Laporan Mutasi Bulanan
                                        </button>
                                        <!-- Form cetak mutasi bulanan -->
                                        <form id="formMutasi" action="{{ route('stok.cetak.mutasi') }}" method="GET" target="_blank" style="display: none;" class="mt-3">
                                            <div class="mb-3">
                                                <label for="periode" class="form-label">Periode</label>
                                                <input type="month" class="form-control" id="periode" name="periode" required>
                                                {{-- format: 2025-08 --}}
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bi bi-printer me-1"></i> Cetak Mutasi
                                                </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="table-responsive">
                <table id="datatable" class="table table-hover align-items-center mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produkStok as $index => $stok)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $stok->nama_produk }}</td>
                            <td class="text-center">{{ $stok->total_stok }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('stok.show', $stok->produk_id) }}"
                                        class="btn btn-info btn-sm d-flex align-items-center px-2 py-1"
                                        title="Detail">
                                        <i class="material-icons-round text-white me-1" style="font-size: 16px;">info</i>
                                        <span class="text-white fw-semibold small">Detail</span>
                                    </a>

                                    @if ($stok->ada_ukuran_kosong)
                                        <span class="ms-2 text-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Ada Stok Kosong">
                                            <i class="bi bi-exclamation-circle-fill" style="font-size: 1.2rem; color: red;"></i>
                                        </span>
                                        <script>
                                            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                                            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                                                new bootstrap.Tooltip(tooltipTriggerEl)
                                            })
                                        </script>
                                    @endif
                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
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
    function showCetakStok() {
        document.getElementById('cetakStokWrapper').style.display = 'block';
        document.getElementById('formMutasi').style.display = 'none';
    }

    function showFormMutasi() {
        document.getElementById('formMutasi').style.display = 'block';
        document.getElementById('cetakStokWrapper').style.display = 'none';
    }
</script>
@endpush

