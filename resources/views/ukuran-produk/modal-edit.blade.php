<div class="modal fade" id="modalEditUkuran" tabindex="-1" aria-labelledby="modalEditUkuranLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-2">
      <form id="formEditUkuran" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalEditUkuranLabel">Edit Ukuran Produk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="edit_kode_ukuran" class="form-label" style="color: black; font-weight: bold;">Kode Ukuran</label>
              <input type="text" name="kode_ukuran" id="edit_kode_ukuran" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label for="edit_nama_ukuran" class="form-label" style="color: black; font-weight: bold;">Nama Ukuran</label>
              <input type="text" name="nama_ukuran" id="edit_nama_ukuran" class="form-control" required>
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
  function openEditUkuranModal(ukuran) {
    const modal = new bootstrap.Modal(document.getElementById('modalEditUkuran'));

    // Set nilai input
    document.getElementById('edit_kode_ukuran').value = ukuran.kode_ukuran;
    document.getElementById('edit_nama_ukuran').value = ukuran.nama_ukuran;

    // Set action form
    const form = document.getElementById('formEditUkuran');
    form.action = `/ukuran-produk/${ukuran.id}`;

    modal.show();
  }
</script>
