@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">
                <i class="material-icons-round text-dark me-2">factory</i>
                Detail Pembelian - Tanggal: {{ \Carbon\Carbon::parse($pembelian->tanggal_pembelian)->format('d M Y') }}
            </h5>
        </div>

        <div class="card-body">
            <div class="mb-4">
                <div class="row mb-2 small">
                    <div class="col-md-6 d-flex align-items-center">
                        <i class="material-icons-round text-primary me-2">store</i>
                        <strong class="me-1">Cabang:</strong> {{ $pembelian->cabang->nama_cabang ?? '-' }}
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <i class="material-icons-round text-success me-2">payments</i>
                        <strong class="me-1">Total Biaya:</strong> Rp{{ number_format($pembelian->total_biaya, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <h6 class="fw-bold mb-2 small d-flex align-items-center">
                Daftar Produk yang Dipembelian
            </h6>


            @if ($pembelian->detailPembelian->isEmpty())
                <div class="alert alert-warning small mb-0">Tidak ada data produk yang dipembelian.</div>
            @else
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-hover align-middle mb-4 small">

                        <thead class="table-light text-center">
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th>Nama Produk</th>
                                <th>Ukuran</th>
                                <th>Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembelian->detailPembelian as $index => $detail)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $detail->detailProduk->produk->nama_produk ?? '-' }}</td>
                                    <td class="text-center">{{ $detail->detailProduk->ukuran->kode_ukuran ?? '-' }}</td>
                                    <td class="text-center">{{ $detail->qty }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Bagian Keterangan -->
                <div class="border-top pt-3">
                    <h6 class="fw-bold small text-uppercase mb-2 d-flex align-items-center">
                        <i class="material-icons-round text-secondary me-2">notes</i>
                        Keterangan
                    </h6>
                    <p class="small mb-0">{{ $pembelian->keterangan ?? '-' }}</p>
                </div>
            @endif
        </div>

        <div class="card-footer bg-white text-end">
            <a href="{{ route('pembelian.index') }}" class="btn btn-sm btn-secondary d-inline-flex align-items-center">
                <i class="material-icons-round me-1" style="font-size: 16px;">arrow_back</i>
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
