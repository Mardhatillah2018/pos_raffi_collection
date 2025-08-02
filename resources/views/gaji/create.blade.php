@extends('layouts.main')

@section('content')
<div class="container mt-4">
  <form action="{{ route('gaji.store') }}" method="POST">
    @csrf
    <div class="card">
      <div class="card-header bg-dark text-white fw-bold">
        Tambah Data Gaji Karyawan
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-6">
            <label for="karyawan_id" class="form-label">Nama Karyawan</label>
            <select name="karyawan_id" id="karyawan_id" class="form-select" required>
              <option value="">-- Pilih Karyawan --</option>
              @foreach ($karyawans as $karyawan)
                <option value="{{ $karyawan->id }}">{{ $karyawan->nama }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-3">
            <label for="periode" class="form-label">Periode</label>
            <input type="month" name="periode" id="periode" class="form-control" required>
          </div>

          <div class="col-md-3">
            <label for="tanggal_dibayar" class="form-label">Tanggal Dibayar</label>
            <input type="date" name="tanggal_dibayar" id="tanggal_dibayar" class="form-control" required>
          </div>

          <div class="col-md-4">
            <label for="jenis_gaji" class="form-label">Jenis Gaji</label>
            <select name="jenis_gaji" id="jenis_gaji" class="form-select" required>
              <option value="Bulanan">Bulanan</option>
              <option value="Harian">Harian</option>
            </select>
          </div>

          <div class="col-md-4">
            <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
            <input type="number" name="gaji_pokok" id="gaji_pokok" class="form-control" required>
          </div>

          <div class="col-md-4">
            <label for="bonus" class="form-label">Bonus</label>
            <input type="number" name="bonus" id="bonus" class="form-control" value="0">
          </div>

          <div class="col-md-6">
            <label for="jumlah_dibayar" class="form-label">Jumlah Dibayar</label>
            <input type="number" name="jumlah_dibayar" id="jumlah_dibayar" class="form-control" readonly>
          </div>

          <div class="col-md-6">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
              <option value="Lunas">Lunas</option>
              <option value="Belum Lunas">Belum Lunas</option>
            </select>
          </div>

          <div class="col-md-12">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control" rows="2"></textarea>
          </div>
        </div>
      </div>
      <div class="card-footer text-end">
        <a href="{{ route('gaji.index') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-success">Simpan</button>
      </div>
    </div>
  </form>
</div>

<script>
  const gajiPokok = document.getElementById('gaji_pokok');
  const bonus = document.getElementById('bonus');
  const total = document.getElementById('jumlah_dibayar');

  function hitungTotal() {
    const pokok = parseFloat(gajiPokok.value) || 0;
    const tambahan = parseFloat(bonus.value) || 0;
    total.value = pokok + tambahan;
  }

  gajiPokok.addEventListener('input', hitungTotal);
  bonus.addEventListener('input', hitungTotal);
</script>
@endsection
