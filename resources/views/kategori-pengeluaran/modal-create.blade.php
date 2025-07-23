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
            <div class="col-md-6">
              <label for="nama_kategori" class="form-label">Nama Kategori Pengeluaran</label>
              <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required>
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
