@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Daftar Stok Produk</h5>

            <div class="d-flex justify-content-end mb-3">
                <!-- Tombol Cetak Stok Hari Ini -->
                <a href="{{ route('stok.cetak') }}" target="_blank" class="btn btn-sm btn-dark me-2">
                    <i class="bi bi-printer me-1" style="font-size: 0.9rem;"></i> Cetak Stok Hari Ini
                </a>

                <!-- Tombol Cetak Mutasi Bulanan (Trigger Modal) -->
                <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#modalMutasi">
                    <i class="bi bi-printer me-1" style="font-size: 0.9rem;"></i> Cetak Mutasi Bulanan
                </button>
            </div>

            <div class="modal fade" id="modalMutasi" tabindex="-1" aria-labelledby="modalMutasiLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-3">
                    <form action="{{ route('stok.cetak.mutasi') }}" method="GET" target="_blank">
                        <div class="modal-header">
                        <h5 class="modal-title" id="modalMutasiLabel">Cetak Mutasi Stok Bulanan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                        <div class="mb-3">
                            <label for="bulan" class="form-label">Bulan</label>
                            <select class="form-select" name="bulan" id="bulan" required>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->locale('id')->monthName }}</option>
                            @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <select class="form-select" name="tahun" id="tahun" required>
                            @for ($y = now()->year; $y >= now()->year - 5; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                            </select>
                        </div>
                        </div>
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-printer me-1"></i> Cetak</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>

        </div>

        <div class="card-body">
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
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <a href="{{ route('stok.show', $stok->produk_id) }}"
                                        class="btn btn-info btn-sm d-flex align-items-center px-2 py-1"
                                        title="Detail">
                                            <i class="material-icons-round text-white me-1" style="font-size: 16px;">info</i>
                                            <span class="text-white fw-semibold small">Detail</span>
                                    </a>
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
