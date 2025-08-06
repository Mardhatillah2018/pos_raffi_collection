<!-- Modal Edit Cabang -->
<div class="modal fade" id="modalEditCabang" tabindex="-1" aria-labelledby="modalEditCabangLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-2">
      <form id="editCabangForm" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalEditCabangLabel">Edit Cabang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="edit_kode_cabang_display" class="form-label" style="color: black; font-weight: bold;">Kode Cabang</label>
              <input type="text" id="edit_kode_cabang_display" class="form-control" readonly>
              <input type="hidden" name="kode_cabang" id="edit_kode_cabang">
            </div>

            <div class="col-md-6">
              <label for="edit_nama_cabang" class="form-label" style="color: black; font-weight: bold;">Nama Cabang</label>
              <input type="text" name="nama_cabang" id="edit_nama_cabang" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label for="edit_jam_buka" class="form-label" style="color: black; font-weight: bold;">Jam Buka</label>
              <input type="time" name="jam_buka" id="edit_jam_buka" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label for="edit_jam_tutup" class="form-label" style="color: black; font-weight: bold;">Jam Tutup</label>
              <input type="time" name="jam_tutup" id="edit_jam_tutup" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label for="edit_no_hp" class="form-label" style="color: black; font-weight: bold;">No HP</label>
              <input type="text" name="no_hp" id="edit_no_hp" class="form-control" required>
            </div>

            <div class="col-md-12">
              <label for="edit_alamat" class="form-label" style="color: black; font-weight: bold;">Alamat</label>
              <textarea name="alamat" id="edit_alamat" class="form-control" rows="3" required></textarea>
            </div>
          </div>
        </div>

        <div class="modal-footer mt-3">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Perbarui</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function openEditCabangModal(cabang) {
  const jamBuka = cabang.jam_buka?.slice(0, 5);
  const jamTutup = cabang.jam_tutup?.slice(0, 5);

  document.getElementById('edit_kode_cabang_display').value = cabang.kode_cabang;
  document.getElementById('edit_kode_cabang').value = cabang.kode_cabang;

  document.getElementById('edit_nama_cabang').value = cabang.nama_cabang;
  document.getElementById('edit_jam_buka').value = jamBuka;
  document.getElementById('edit_jam_tutup').value = jamTutup;
    document.getElementById('edit_no_hp').value = cabang.no_hp;
  document.getElementById('edit_alamat').value = cabang.alamat;

  document.getElementById('editCabangForm').action = `/cabang/${cabang.id}`;
  new bootstrap.Modal(document.getElementById('modalEditCabang')).show();
}

</script>
