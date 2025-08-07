@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-gradient-dark fw-bold">
            <h6 class="mb-0" style="color: white">Keuntungan Per Bulan</h6>
        </div>

        <div class="card-body">
            <div class="px-3 py-2 mb-0">
                <button class="btn btn-sm" style="background-color: white; border: 1px solid #a20f0f; color: #a20f0f;" data-bs-toggle="modal" data-bs-target="#modalCetakKeuntungan">
                    <i class="bi bi-printer me-1" style="color: #a20f0f; font-size: 0.9rem;"></i>
                    Laporan Keuntungan
                </button>
            </div>
            <!-- Modal Pilih Rentang Waktu -->
            <div class="modal fade" id="modalCetakKeuntungan" tabindex="-1" aria-labelledby="modalCetakKeuntunganLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content p-3">
                    <form action="{{ route('keuntungan.cetak') }}" method="GET" target="_blank">
                        <input type="hidden" name="filter" id="filterType" value="bulan">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCetakKeuntunganLabel">Cetak Laporan Keuntungan</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                            <!-- Nav Tabs -->
                                <ul class="nav nav-tabs mb-3" id="filterTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="bulan-tab" data-bs-toggle="tab" data-bs-target="#bulan" type="button" role="tab" aria-controls="bulan" aria-selected="true">
                                        Per Bulan
                                    </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tanggal-tab" data-bs-toggle="tab" data-bs-target="#tanggal" type="button" role="tab" aria-controls="tanggal" aria-selected="false">
                                        Per Rentang Tanggal
                                    </button>
                                    </li>
                                </ul>

                                <!-- Tab Panes -->
                                <div class="tab-content" id="filterTabContent">
                                    <!-- Tab Bulan -->
                                    <div class="tab-pane fade show active" id="bulan" role="tabpanel" aria-labelledby="bulan-tab">
                                        <div class="mb-3">
                                            <label class="form-label" style="color: black; font-weight: semibold;">Pilih Bulan</label>
                                            <input type="month" name="bulan" class="form-control">
                                        </div>
                                    </div>

                                    <!-- Tab Rentang Tanggal -->
                                    <div class="tab-pane fade" id="tanggal" role="tabpanel" aria-labelledby="tanggal-tab">
                                        <div class="mb-3">
                                            <label class="form-label" style="color: black; font-weight: semibold;">Dari Tanggal</label>
                                            <input type="text" id="from" name="from" class="form-control" placeholder="dari tanggal ...">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" style="color: black; font-weight: semibold;">Sampai Tanggal</label>
                                            <input type="text" id="to" name="to" class="form-control" placeholder="sampai tanggal ...">
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
                <table id="datatable" class="table table-hover text-center">
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
    const bulanInput = document.querySelector('input[name="bulan"]');
    const fromInput = document.querySelector('input[name="from"]');
    const toInput = document.querySelector('input[name="to"]');
    const filterTypeInput = document.getElementById('filterType');
    const form = document.querySelector('#modalCetakKeuntungan form');

    const bulanTabBtn = document.getElementById('bulan-tab');
    const tanggalTabBtn = document.getElementById('tanggal-tab');

    let activeTab = 'bulan'; // default

    function setRequired(tab) {
        if (tab === 'bulan') {
            bulanInput.required = true;
            fromInput.required = false;
            toInput.required = false;
            activeTab = 'bulan';
            filterTypeInput.value = 'bulan';
        } else {
            bulanInput.required = false;
            fromInput.required = true;
            toInput.required = true;
            activeTab = 'tanggal';
            filterTypeInput.value = 'tanggal';
        }
    }

    // Default saat modal dibuka
    setRequired('bulan');

    // Event saat tab diklik
    bulanTabBtn.addEventListener('click', () => setRequired('bulan'));
    tanggalTabBtn.addEventListener('click', () => setRequired('tanggal'));

    // Flatpickr
    const toPicker = flatpickr("#to", {
        dateFormat: "Y-m-d"
    });

    const fromPicker = flatpickr("#from", {
        dateFormat: "Y-m-d",
        onChange: function(selectedDates) {
            if (selectedDates.length > 0) {
                let minToDate = new Date(selectedDates[0]);
                minToDate.setDate(minToDate.getDate() + 1);
                toPicker.set('minDate', minToDate);
            }
        }
    });

    // Saat submit, kosongkan input yang tidak dipakai
    form.addEventListener('submit', function () {
        if (activeTab === 'bulan') {
            fromInput.value = '';
            toInput.value = '';
        } else {
            bulanInput.value = '';
        }
    });
</script>
@endpush

