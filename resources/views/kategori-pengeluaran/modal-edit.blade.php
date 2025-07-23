<div class="modal fade" id="modalEditKategoriPengeluaran" tabindex="-1" aria-labelledby="modalEditKategoriPengeluaranLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-2">
      <form id="formEditKategoriPengeluaran" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalEditKategoriPengeluaranLabel">Edit Kategori Pengeluaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="edit_nama_kategori" class="form-label">Nama Kategori Pengeluaran</label>
              <input type="text" name="nama_kategori" id="edit_nama_kategori" class="form-control" required>
            </div>
          </div>
        </div>

        <div class="modal-footer mt-3">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-warning">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function openEditKategoriPengeluaranModal(kategori) {
    const modal = new bootstrap.Modal(document.getElementById('modalEditKategoriPengeluaran'));

    // Set nilai input
    document.getElementById('edit_nama_kategori').value = kategori.nama_kategori;

    // Set action form
    const form = document.getElementById('formEditKategoriPengeluaran');
    form.action = `/kategori-pengeluaran/${kategori.id}`;

    modal.show();
  }
</script>
