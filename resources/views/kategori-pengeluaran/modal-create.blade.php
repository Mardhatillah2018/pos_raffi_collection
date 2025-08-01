<div class="modal fade" id="modalKategoriPengeluaran" tabindex="-1" aria-labelledby="modalKategoriPengeluaranLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-2">
      <form action="{{ route('kategori-pengeluaran.store') }}" method="POST">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalKategoriPengeluaranLabel">Tambah Kategori Pengeluaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-12">
              <label for="nama_kategori" class="form-label">Nama Kategori Pengeluaran</label>
              <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required>
            </div>

            <div class="col-md-12 mt-2">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="is_modal_produk" name="is_modal_produk" value="1">
                <label class="form-check-label" for="is_modal_produk">
                  Termasuk Modal Produk
                </label>
              </div>
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
