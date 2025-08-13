@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-gradient-dark fw-bold">
            <h6 class="mb-0" style="color: white">Laporan Mutasi Stok</h6>
        </div>

        <div class="card-body">
            <div class="px-3 py-2 mb-3">
                <button class="btn btn-sm" style="background-color: white; border: 1px solid #a20f0f; color: #a20f0f;" data-bs-toggle="modal" data-bs-target="#modalCetakMutasi">
                    <i class="bi bi-printer me-1" style="color: #a20f0f; font-size: 0.9rem;"></i>
                    Cetak Laporan Mutasi Stok
                </button>
            </div>

            <!-- Modal Pilih Periode -->
            <div class="modal fade" id="modalCetakMutasi" tabindex="-1" aria-labelledby="modalCetakMutasiLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content p-3">
                    <form action="{{ route('mutasi-stok.cetak') }}" method="GET" target="_blank">
                        <input type="hidden" name="filter" id="filterTypeMutasi" value="bulan">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCetakMutasiLabel">Cetak Laporan Mutasi Stok</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <ul class="nav nav-tabs mb-3" id="filterTabMutasi" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="bulan-mutasi-tab" data-bs-toggle="tab" data-bs-target="#bulan-mutasi" type="button" role="tab" aria-controls="bulan-mutasi" aria-selected="true">
                                            Per Bulan
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="tanggal-mutasi-tab" data-bs-toggle="tab" data-bs-target="#tanggal-mutasi" type="button" role="tab" aria-controls="tanggal-mutasi" aria-selected="false">
                                            Per Rentang Tanggal
                                        </button>
                                    </li>
                                </ul>

                                <div class="tab-content" id="filterTabContentMutasi">
                                    <div class="tab-pane fade show active" id="bulan-mutasi" role="tabpanel" aria-labelledby="bulan-mutasi-tab">
                                        <div class="mb-3">
                                            <label class="form-label" style="color: black; font-weight: semibold;">Pilih Bulan</label>
                                            <input type="month" name="bulan" class="form-control">
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="tanggal-mutasi" role="tabpanel" aria-labelledby="tanggal-mutasi-tab">
                                        <div class="mb-3">
                                            <label class="form-label" style="color: black; font-weight: semibold;">Dari Tanggal</label>
                                            <input type="text" id="fromMutasi" name="from" class="form-control" placeholder="dari tanggal ...">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" style="color: black; font-weight: semibold;">Sampai Tanggal</label>
                                            <input type="text" id="toMutasi" name="to" class="form-control" placeholder="sampai tanggal ...">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-printer me-1"></i> Cetak
                                </button>
                            </div>
                    </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table id="datatable"  class="table table-hover text-center">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Bulan</th>
                            <th>Jumlah Produk</th>
                            <th>Stok Awal</th>
                            <th>Stok Masuk</th>
                            <th>Stok Keluar</th>
                            <th>Stok Akhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($periodeList as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->nama_bulan }}</td>
                                <td>{{ $item->jumlah_produk }}</td>
                                <td>{{ $item->stok_awal }}</td>
                                <td>{{ $item->stok_masuk }}</td>
                                <td>{{ $item->stok_keluar }}</td>
                                <td>{{ $item->stok_akhir }}</td>
                                <td>
                                    <a href="{{ route('mutasi-stok.show', [$item->bulan, $item->tahun]) }}"
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
                                <td class="text-center">-</td>
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
    const bulanInputMutasi = document.querySelector('input[name="bulan"]');
    const fromInputMutasi = document.querySelector('input[name="from"]');
    const toInputMutasi = document.querySelector('input[name="to"]');
    const filterTypeMutasiInput = document.getElementById('filterTypeMutasi');

    const bulanTabBtnMutasi = document.getElementById('bulan-mutasi-tab');
    const tanggalTabBtnMutasi = document.getElementById('tanggal-mutasi-tab');
    const formCetakMutasi = document.querySelector('#modalCetakMutasi form');

    let activeTabMutasi = 'bulan'; // default

    function setRequiredMutasi(tab) {
        if (tab === 'bulan') {
            bulanInputMutasi.required = true;
            fromInputMutasi.required = false;
            toInputMutasi.required = false;

            fromInputMutasi.value = '';
            toInputMutasi.value = '';

            filterTypeMutasiInput.value = 'bulan';
            activeTabMutasi = 'bulan';
        } else {
            bulanInputMutasi.required = false;
            fromInputMutasi.required = true;
            toInputMutasi.required = true;

            bulanInputMutasi.value = '';

            filterTypeMutasiInput.value = 'tanggal';
            activeTabMutasi = 'tanggal';
        }
    }

    // Default saat modal dibuka
    setRequiredMutasi('bulan');

    // Event saat tab diklik
    bulanTabBtnMutasi.addEventListener('click', () => setRequiredMutasi('bulan'));
    tanggalTabBtnMutasi.addEventListener('click', () => setRequiredMutasi('tanggal'));

    // Flatpickr
    const modalCetakMutasi = document.getElementById('modalCetakMutasi');
    modalCetakMutasi.addEventListener('shown.bs.modal', function () {
        const toPickerMutasi = flatpickr("#toMutasi", {
            dateFormat: "Y-m-d",
            maxDate: "today"
        });

        const fromPickerMutasi = flatpickr("#fromMutasi", {
            dateFormat: "Y-m-d",
            maxDate: "today",
            onChange: function (selectedDates) {
                if (selectedDates.length > 0) {
                    let minToDate = new Date(selectedDates[0]);
                    minToDate.setDate(minToDate.getDate() + 1);
                    toPickerMutasi.set('minDate', minToDate);
                }
            }
        });
    });

    // Validasi submit
    formCetakMutasi.addEventListener('submit', function(e) {
        if (activeTabMutasi === 'tanggal') {
            let valid = true;

            if (!fromInputMutasi.value) {
                fromInputMutasi.classList.add('is-invalid');
                fromInputMutasi.nextElementSibling.textContent = 'Tanggal awal wajib diisi';
                valid = false;
            } else {
                fromInputMutasi.classList.remove('is-invalid');
            }

            if (!toInputMutasi.value) {
                toInputMutasi.classList.add('is-invalid');
                toInputMutasi.nextElementSibling.textContent = 'Tanggal akhir wajib diisi';
                valid = false;
            } else {
                toInputMutasi.classList.remove('is-invalid');
            }

            if (!valid) {
                e.preventDefault();
                e.stopPropagation();
            }
        }
    });
</script>
@endpush
