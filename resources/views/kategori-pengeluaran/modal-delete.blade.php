<div class="modal fade" id="modalDeleteKategoriPengeluaran" tabindex="-1" aria-labelledby="modalDeleteKategoriPengeluaranLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="modalDeleteKategoriPengeluaranLabel">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p>Apakah Anda yakin ingin menghapus kategori pengeluaran ini?</p>
      </div>
      <div class="modal-footer">
        <form id="deleteKategoriPengeluaranForm" method="POST">
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
  function openDeleteKategoriPengeluaranModal(id) {
    const form = document.getElementById('deleteKategoriPengeluaranForm');
    form.action = `/kategori-pengeluaran/${id}`;
    new bootstrap.Modal(document.getElementById('modalDeleteKategoriPengeluaran')).show();
  }
</script>
