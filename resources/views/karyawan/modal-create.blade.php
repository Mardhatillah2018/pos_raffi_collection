<!-- Modal Tambah Karyawan -->
<div class="modal fade" id="modalKaryawan" tabindex="-1" aria-labelledby="modalKaryawanLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-2">
      <form action="{{ route('karyawan.store') }}" method="POST">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalKaryawanLabel">Tambah Karyawan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="nama" class="form-label" style="color: black; font-weight: bold;">Nama Lengkap</label>
              <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama Lengkap" required>
            </div>

            <div class="col-md-6">
              <label for="no_hp" class="form-label" style="color: black; font-weight: bold;">Nomor HP</label>
              <input type="text" name="no_hp" id="no_hp" class="form-control" placeholder="Masukkan Nomor HP" required>
            </div>

            <div class="col-12">
              <label for="alamat" class="form-label" style="color: black; font-weight: bold;">Alamat</label>
              <textarea name="alamat" id="alamat" class="form-control" rows="2" placeholder="Masukkan Alamat" required></textarea>
            </div>

            <div class="col-12">
              <label for="kode_cabang" class="form-label" style="color: black; font-weight: bold;">Cabang</label>
              <select name="kode_cabang" id="kode_cabang" class="form-select select2" required>
                <option value="">-- Pilih Cabang --</option>
                    @foreach ($cabangs as $cabang)
                        <option value="{{ $cabang->kode_cabang }}">
                        {{ $cabang->nama_cabang }} ({{ $cabang->kode_cabang }})
                        </option>
                    @endforeach
                </select>

            </div>
          </div>
        </div>

        <div class="modal-footer mt-3">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#kode_cabang').select2({
      dropdownParent: $('#modalKaryawan'),
      placeholder: "-- Pilih Cabang --",
      width: '100%'
    });
  });
</script>

