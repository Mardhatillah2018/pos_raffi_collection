@extends('layouts.main')

@section('content')
<div class="container mt-4">
  <form action="{{ route('gaji.store') }}" method="POST">
    @csrf
    <div class="card shadow-sm">
      <div class="card-header bg-dark text-white fw-bold">
        <i class="bi bi-cash-coin me-2"></i>Tambah Data Gaji Karyawan
      </div>

      <div class="card-body">
        <div class="row g-3">

          {{-- Bagian 1: Data Karyawan --}}
          <div class="col-md-6">
            <label for="karyawan_id" class="form-label fw-bold"><i class="bi bi-person-fill me-1"></i>Nama Karyawan</label>
            <select name="karyawan_id" id="karyawan_id" class="form-select select2" required>
              <option value="">-- Pilih Karyawan --</option>
              @foreach ($karyawans as $karyawan)
              <option value="{{ $karyawan->id }}">{{ $karyawan->nama }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-3">
            <label for="periode" class="form-label fw-bold"><i class="bi bi-calendar3 me-1"></i>Periode</label>
            <input type="month" name="periode" id="periode" class="form-control" required>
          </div>

          <div class="col-md-3">
            <label for="tanggal_dibayar" class="form-label fw-bold"><i class="bi bi-calendar-check me-1"></i>Tanggal Dibayar</label>
            <input type="date" name="tanggal_dibayar" id="tanggal_dibayar" class="form-control" disabled>
          </div>

          {{-- Bagian 2: Komponen Gaji --}}
          <hr class="mt-4 mb-0">
          <div class="fw-bold text-dark mb-2">Komponen Gaji</div>


          <div class="col-md-4">
            <label for="jenis_gaji" class="form-label fw-bold">Jenis Gaji</label>
            <select name="jenis_gaji" id="jenis_gaji" class="form-select" required>
              <option value="">-- Pilih Jenis --</option>
              <option value="bulanan">Bulanan</option>
              <option value="mingguan">Mingguan</option>
            </select>
          </div>

          <div class="col-md-4">
            <label for="gaji_pokok" class="form-label fw-bold">Gaji Pokok (Rp)</label>
            <input type="number" name="gaji_pokok" id="gaji_pokok" class="form-control text-end" placeholder="0.00" min="0" step="0.01" required>
          </div>

          <div class="col-md-4">
            <label for="bonus" class="form-label fw-bold">Bonus (Rp)</label>
            <input type="number" name="bonus" id="bonus" class="form-control text-end" placeholder="0.00" min="0" step="0.01">
          </div>

          {{-- Bagian 3: Ringkasan Pembayaran --}}
          <hr class="mt-4 mb-0">
          <div class="fw-bold text-dark mb-2">Ringkasan Pembayaran</div>

          <div class="col-md-6">
            <label for="jumlah_dibayar" class="form-label fw-bold">Jumlah Dibayar (Rp)</label>
            <input type="number" name="jumlah_dibayar" id="jumlah_dibayar" class="form-control text-end bg-light" step="0.01" value="0.00" readonly>
          </div>

          <div class="col-md-6">
            <label for="status" class="form-label fw-bold">Status Pembayaran</label>
            <select name="status" id="status" class="form-select" required>
              <option value="pending">Pending</option>
              <option value="dibayar">Dibayar</option>
            </select>
          </div>

          {{-- Keterangan --}}
          <div class="col-md-12">
            <label for="keterangan" class="form-label fw-bold">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control" rows="2" placeholder="Tulis keterangan jika ada..."></textarea>
          </div>
        </div>
      </div>

      <div class="card-footer text-end">
        <a href="{{ route('gaji.index') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-success">
          <i class="bi bi-save me-1"></i>Simpan
        </button>
      </div>
    </div>
  </form>
</div>
@endsection

@push('scripts')
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
</script>
@endpush
