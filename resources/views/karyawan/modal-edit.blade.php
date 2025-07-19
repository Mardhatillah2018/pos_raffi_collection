<!-- Modal Edit Karyawan -->
<div class="modal fade" id="modalEditKaryawan" tabindex="-1" aria-labelledby="modalEditKaryawanLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-2">
      <form id="formEditKaryawan" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalEditKaryawanLabel">Edit Karyawan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="edit_nama" class="form-label">Nama Lengkap</label>
              <input type="text" name="nama" id="edit_nama" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label for="edit_no_hp" class="form-label">Nomor HP</label>
              <input type="text" name="no_hp" id="edit_no_hp" class="form-control" required>
            </div>

            <div class="col-12">
              <label for="edit_alamat" class="form-label">Alamat</label>
              <textarea name="alamat" id="edit_alamat" class="form-control" rows="2" required></textarea>
            </div>

            <div class="col-12">
              <label for="edit_kode_cabang" class="form-label">Cabang</label>
              <select name="kode_cabang" id="edit_kode_cabang" class="form-select" required>
                <option value="">-- Pilih Cabang --</option>
                @foreach ($cabangs as $cabang)
                  <option value="{{ $cabang->kode_cabang }}">{{ $cabang->nama_cabang }} ({{ $cabang->kode_cabang }})</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        <div class="modal-footer mt-3">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  function openEditModal(karyawan) {
    document.getElementById('edit_nama').value = karyawan.nama;
    document.getElementById('edit_no_hp').value = karyawan.no_hp;
    document.getElementById('edit_alamat').value = karyawan.alamat;
    document.getElementById('edit_kode_cabang').value = karyawan.kode_cabang || '';

    // Ubah action form edit
    document.getElementById('formEditKaryawan').action = `/karyawan/${karyawan.id}`;

    // Tampilkan modal
    new bootstrap.Modal(document.getElementById('modalEditKaryawan')).show();
  }
</script>
