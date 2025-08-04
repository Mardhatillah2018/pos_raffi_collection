@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white fw-bold d-flex justify-content-between align-items-center">
            <span>Laporan Keuntungan Per Bulan</span>
            <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalCetakKeuntungan">
                <i class="bi bi-printer me-1" style="font-size: 0.9rem;"></i>
                Cetak Laporan
            </button>
        </div>

        <!-- Modal Pilih Rentang Waktu -->
        <div class="modal fade" id="modalCetakKeuntungan" tabindex="-1" aria-labelledby="modalCetakKeuntunganLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('keuntungan.cetak') }}" method="GET" target="_blank">
                    <div class="modal-content">
                        <div class="modal-header bg-dark text-white">
                            <h5 class="modal-title" id="modalCetakKeuntunganLabel">Cetak Laporan Keuntungan</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="bulan" class="form-label">Pilih Bulan</label>
                                <input type="month" name="bulan" id="bulan" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-printer me-1"></i> Cetak
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover text-center">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Bulan</th>
                            <th>Total Produk Terjual</th>
                            <th>Total Penjualan</th>
                            <th>Laba Kotor</th>
                            <th>Pengeluaran</th>
                            <th>Laba Bersih</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rekap as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item['bulan'] }}</td>
                                <td>{{ $item['total_produk'] }}</td>
                                <td>Rp {{ number_format($item['total_penjualan'], 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item['laba_kotor'], 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item['pengeluaran'], 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item['laba_bersih'], 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('keuntungan.show', $item['raw_bulan']) }}"
                                    class="btn btn-info btn-sm d-flex align-items-center px-2 py-1"
                                    title="Detail"
                                    style="line-height: 1;">
                                        <i class="material-icons-round text-white me-1" style="font-size: 16px;">info</i>
                                        <span class="text-white fw-semibold small">Detail</span>
                                    </a>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
