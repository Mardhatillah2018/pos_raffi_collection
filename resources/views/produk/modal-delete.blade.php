<div class="modal fade" id="modalDeleteProduk" tabindex="-1" aria-labelledby="modalDeleteProdukLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="modalDeleteProdukLabel">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p>Apakah Anda yakin ingin menghapus produk ini?</p>
        <span style="color: red; font-size: 0.8rem;">*Jika menghapus produk ini, semua data terkait akan hilang.</span>
      </div>
      <div class="modal-footer">
        <form id="deleteProdukForm" method="POST">
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
  function openDeleteProdukModal(id) {
    const form = document.getElementById('deleteProdukForm');
    form.action = `/produk/${id}`;
    new bootstrap.Modal(document.getElementById('modalDeleteProduk')).show();
  }
</script>
