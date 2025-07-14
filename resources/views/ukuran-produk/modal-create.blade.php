<div class="modal fade" id="modalUkuran" tabindex="-1" aria-labelledby="modalUkuranLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-2">
      <form action="{{ route('ukuran-produk.store') }}" method="POST">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalUkuranLabel">Tambah Ukuran Produk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="kode_ukuran" class="form-label">Kode Ukuran</label>
              <input type="text" name="kode_ukuran" id="kode_ukuran" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label for="nama_ukuran" class="form-label">Nama Ukuran</label>
              <input type="text" name="nama_ukuran" id="nama_ukuran" class="form-control" required>
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
