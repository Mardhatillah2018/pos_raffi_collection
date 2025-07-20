<!-- Modal Delete Detail Produk -->
<div class="modal fade" id="modalDeleteDetailProduk" tabindex="-1" aria-labelledby="modalDeleteDetailProdukLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="modalDeleteDetailProdukLabel">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p>Apakah Anda yakin ingin menghapus detail produk ini?</p>
      </div>
      <div class="modal-footer">
        <form id="deleteDetailProdukForm" method="POST">
          @csrf
          @method('DELETE')
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
          <button type="submit" class="btn btn-danger">Ya, Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function openDeleteDetailProdukModal(id) {
    const form = document.getElementById('deleteDetailProdukForm');
    form.action = `/detail-produk/${id}`; 
    new bootstrap.Modal(document.getElementById('modalDeleteDetailProduk')).show();
  }
</script>
