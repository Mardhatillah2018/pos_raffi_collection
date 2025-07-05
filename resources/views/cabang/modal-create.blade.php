<!-- Modal Tambah Cabang -->
<div class="modal fade" id="modalCabang" tabindex="-1" aria-labelledby="modalCabangLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-2">
      <form action="{{ route('cabang.store') }}" method="POST">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalCabangLabel">Tambah Cabang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="kode_cabang" class="form-label">Kode Cabang</label>
              <input type="text" name="kode_cabang" id="kode_cabang" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label for="nama_cabang" class="form-label">Nama Cabang</label>
              <input type="text" name="nama_cabang" id="nama_cabang" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label for="jam_buka" class="form-label">Jam Buka</label>
              <input type="time" name="jam_buka" id="jam_buka" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label for="jam_tutup" class="form-label">Jam Tutup</label>
              <input type="time" name="jam_tutup" id="jam_tutup" class="form-control" required>
            </div>

            <div class="col-md-12">
              <label for="alamat" class="form-label">Alamat</label>
              <textarea name="alamat" id="alamat" class="form-control" rows="3" required></textarea>
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
