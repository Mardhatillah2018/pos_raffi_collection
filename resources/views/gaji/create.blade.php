@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <form action="{{ route('gaji.store') }}" method="POST">
        @csrf
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient bg-success text-white fw-bold">
                <i class="bi bi-cash-coin me-2"></i> Tambah Data Gaji Karyawan
            </div>

            <div class="card-body">
                <div class="row g-3">

                    {{-- Bagian 1: Data Karyawan --}}
                    <h6 class="fw-bold text-success border-bottom pb-2 mb-3">
                        <i class="bi bi-person-badge me-1"></i> Data Karyawan
                    </h6>

                    <div class="col-md-6">
                        <label for="karyawan_id" class="form-label fw-semibold" style="color: black; font-weight: semibold;">
                            <i class="bi bi-person-fill me-1"></i>Nama Karyawan
                            <span class="text-danger">*</span>
                        </label>
                        <select name="karyawan_id" id="karyawan_id" class="form-select select2" required>
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach ($karyawans as $karyawan)
                                <option value="{{ $karyawan->id }}">{{ $karyawan->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="periode" class="form-label fw-semibold" style="color: black; font-weight: semibold;">
                            <i class="bi bi-calendar3 me-1"></i>Periode
                            <span class="text-danger">*</span>
                        </label>
                        <input type="month" name="periode" id="periode" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label for="tanggal_dibayar" class="form-label fw-semibold" style="color: black; font-weight: semibold;">
                            <i class="bi bi-calendar-check me-1"></i>Tanggal Dibayar
                        </label>
                        <input type="text" name="tanggal_dibayar" id="tanggal_dibayar"
                               class="form-control" placeholder="Pilih Tanggal" disabled>
                    </div>

                    {{-- Bagian 2: Komponen Gaji --}}
                    <h6 class="fw-bold text-success border-bottom pb-2 mt-4 mb-3" style="color: black; font-weight: semibold;">
                        <i class="bi bi-wallet2 me-1"></i> Komponen Gaji
                    </h6>

                    <div class="col-md-4">
                        <label for="jenis_gaji" class="form-label fw-semibold" style="color: black; font-weight: semibold;">Jenis Gaji</label>
                        <span class="text-danger">*</span>
                        <select name="jenis_gaji" id="jenis_gaji" class="form-select" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="bulanan">Bulanan</option>
                            <option value="mingguan">Mingguan</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="gaji_pokok" class="form-label fw-semibold" style="color: black; font-weight: semibold;">Gaji Pokok (Rp)</label>
                        <span class="text-danger">*</span>
                        <input type="number" name="gaji_pokok" id="gaji_pokok"
                               class="form-control text-end" placeholder="0.00" min="0" step="0.01" required>
                    </div>

                    <div class="col-md-4">
                        <label for="bonus" class="form-label fw-semibold" style="color: black; font-weight: semibold;">Bonus (Rp)</label>
                        <input type="number" name="bonus" id="bonus"
                               class="form-control text-end" placeholder="0.00" min="0" step="0.01">
                    </div>

                    {{-- Bagian 3: Ringkasan Pembayaran --}}
                    <h6 class="fw-bold text-success border-bottom pb-2 mt-4 mb-3">
                        <i class="bi bi-receipt me-1"></i> Ringkasan Pembayaran
                    </h6>

                    <div class="col-md-6">
                        <label for="jumlah_dibayar" class="form-label fw-semibold" style="color: black; font-weight: semibold;">Jumlah Dibayar (Rp)</label>
                        <input type="number" name="jumlah_dibayar" id="jumlah_dibayar"
                               class="form-control text-end bg-light fw-bold" step="0.01" value="0.00" readonly>
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label fw-semibold" style="color: black; font-weight: semibold;">Status Pembayaran</label>
                        <span class="text-danger">*</span>
                        <select name="status" id="status" class="form-select" required>
                            <option value="pending">Pending</option>
                            <option value="dibayar">Dibayar</option>
                        </select>
                    </div>

                    {{-- Keterangan --}}
                    <div class="col-12">
                        <label for="keterangan" class="form-label fw-semibold" style="color: black; font-weight: semibold;">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control"
                                  rows="2" placeholder="Tulis keterangan jika ada..."></textarea>
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <a href="{{ route('gaji.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save me-1"></i>Simpan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(document).ready(function () {
        $('#karyawan_id').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih Karyawan',
            allowClear: true
        });

        // Inisialisasi total gaji
        hitungTotal();
        toggleTanggalDibayar();

        // Inisialisasi Flatpickr
        flatpickr("#tanggal_dibayar", {
            dateFormat: "Y-m-d",
            allowInput: true
        });
    });

    const gajiPokok = document.getElementById('gaji_pokok');
    const bonus = document.getElementById('bonus');
    const total = document.getElementById('jumlah_dibayar');
    const status = document.getElementById('status');
    const tanggalDibayar = document.getElementById('tanggal_dibayar');

    function hitungTotal() {
        const pokok = parseFloat(gajiPokok.value) || 0;
        const tambahan = parseFloat(bonus.value) || 0;
        total.value = (pokok + tambahan).toFixed(2);
    }

    function toggleTanggalDibayar() {
        if (status.value === 'dibayar') {
            tanggalDibayar.disabled = false;
            tanggalDibayar.required = true;
        } else {
            tanggalDibayar.value = '';
            tanggalDibayar.disabled = true;
            tanggalDibayar.required = false;
        }
    }

    gajiPokok.addEventListener('input', hitungTotal);
    bonus.addEventListener('input', hitungTotal);
    status.addEventListener('change', toggleTanggalDibayar);

    // review
    document.addEventListener('DOMContentLoaded', function () {
        const formGaji = document.querySelector('form[action="{{ route('gaji.store') }}"]');
        // Pastikan form ada
        if (!formGaji) return;

        formGaji.addEventListener('submit', function (e) {
            e.preventDefault();

            const karyawan = document.querySelector('#karyawan_id option:checked').textContent.trim();
            const periode = document.querySelector('#periode').value;
            const tanggalDibayarVal = tanggalDibayar.value || '-';
            const jenisGaji = document.querySelector('#jenis_gaji option:checked').textContent.trim();
            const gajiVal = parseFloat(gajiPokok.value || 0);
            const bonusVal = parseFloat(bonus.value || 0);
            const totalVal = gajiVal + bonusVal;

            Swal.fire({
                title: 'Review Data Gaji',
                html: `
                    <table class="table table-bordered text-start">
                        <tr><th>Nama Karyawan</th><td>${karyawan}</td></tr>
                        <tr><th>Periode</th><td>${periode}</td></tr>
                        <tr><th>Tanggal Dibayar</th><td>${tanggalDibayarVal}</td></tr>
                        <tr><th>Jenis Gaji</th><td>${jenisGaji}</td></tr>
                        <tr><th>Gaji Pokok</th><td>Rp ${gajiVal.toLocaleString()}</td></tr>
                        <tr><th>Bonus</th><td>Rp ${bonusVal.toLocaleString()}</td></tr>
                        <tr><th>Total Diterima</th><td><strong>Rp ${totalVal.toLocaleString()}</strong></td></tr>
                    </table>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal',
                width: '600px'
            }).then((result) => {
                if (result.isConfirmed) {
                    formGaji.submit();
                }
            });
        });
    });
</script>
@endpush
