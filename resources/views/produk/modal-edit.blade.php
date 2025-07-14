<div class="modal fade" id="modalEditProduk" tabindex="-1" aria-labelledby="modalEditProdukLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-2">
      <form id="formEditProduk" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalEditProdukLabel">Edit Produk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="edit_nama_produk" class="form-label">Nama Produk</label>
              <input type="text" name="nama_produk" id="edit_nama_produk" class="form-control" required>
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
  function openEditProdukModal(produk) {
    const modal = new bootstrap.Modal(document.getElementById('modalEditProduk'));

    // Set nilai input
    document.getElementById('edit_nama_produk').value = produk.nama_produk;

    // Set action form
    const form = document.getElementById('formEditProduk');
    form.action = `/produk/${produk.id}`;

    modal.show();
  }
</script>
