<div class="modal fade" id="modalEditPengeluaran" tabindex="-1" aria-labelledby="modalEditPengeluaranLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-2">
      <form action="" method="POST" id="formEditPengeluaran">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalEditPengeluaranLabel">Edit Pengeluaran</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="editTanggal" class="form-label fw-bold">Tanggal</label>
              <input type="date" name="tanggal" id="editTanggal" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label for="editKategori" class="form-label fw-bold">Kategori Pengeluaran</label>
              <select name="kategori_id" id="editKategori" class="form-select select2-edit" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategori_pengeluarans as $kategori)
                  <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label for="editTotal" class="form-label fw-bold">Total Pengeluaran</label>
              <input type="number" name="total_pengeluaran" id="editTotal" class="form-control" step="0.01" required>
            </div>

            <div class="col-md-12">
              <label for="editKeterangan" class="form-label fw-bold">Keterangan (Opsional)</label>
              <textarea name="keterangan" id="editKeterangan" rows="3" class="form-control" placeholder="Contoh: Bayar listrik, pembelian alat, dll."></textarea>
            </div>
          </div>
        </div>

        <div class="modal-footer mt-3">
          <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function openEditPengeluaranModal(pengeluaran) {
    const form = document.getElementById('formEditPengeluaran');
    form.action = `/pengeluaran/${pengeluaran.id}`;

    document.getElementById('editTanggal').value = pengeluaran.tanggal;
    document.getElementById('editKategori').value = pengeluaran.kategori_id;
    document.getElementById('editTotal').value = pengeluaran.total_pengeluaran;
    document.getElementById('editKeterangan').value = pengeluaran.keterangan || '';

    const modal = new bootstrap.Modal(document.getElementById('modalEditPengeluaran'));
    modal.show();
  }

  $(document).ready(function() {
    $('#editKategori').select2({
      dropdownParent: $('#modalEditPengeluaran'),
      width: '100%'
    });
  });
</script>
