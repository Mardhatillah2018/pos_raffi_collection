<div class="modal fade" id="modalDeletePengeluaran" tabindex="-1" aria-labelledby="modalDeletePengeluaranLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="modalDeletePengeluaranLabel">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p>Apakah Anda yakin ingin menghapus data pengeluaran ini?</p>
      </div>
      <div class="modal-footer">
        <form id="deletePengeluaranForm" method="POST">
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
  function openDeletePengeluaranModal(id) {
    const form = document.getElementById('deletePengeluaranForm');
    form.action = `/pengeluaran/${id}`; 
    new bootstrap.Modal(document.getElementById('modalDeletePengeluaran')).show();
  }
</script>
