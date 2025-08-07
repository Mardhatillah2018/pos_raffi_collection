<!-- Modal Kurangi Stok -->
<div class="modal fade" id="modalKurangiStok" tabindex="-1" aria-labelledby="kurangiStokLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('pengurangan.ajukan') }}" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="kurangiStokLabel">Kurangi Stok</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="detail_produk_id" id="kurangDetailProdukId">
        <div class="mb-3">
          <label for="namaProduk" class="form-label" style="color: black; font-weight: semibold;">Nama Produk</label>
          <input type="text" id="kurangNamaProduk" class="form-control" readonly>
        </div>
        <div class="mb-3">
          <label for="qty" class="form-label" style="color: black; font-weight: semibold;">Jumlah Pengurangan</label>
          <input type="number" name="qty" class="form-control" required min="1" placeholder="Masukkan Jumlah Pengurangan">
        </div>
        <div class="mb-3">
          <label for="keterangan" class="form-label" style="color: black; font-weight: semibold;">Keterangan</label>
          <textarea name="keterangan" class="form-control" rows="2" placeholder="Masukkan Keterangan"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger">Kurangi</button>
      </div>
    </form>
  </div>
</div>
