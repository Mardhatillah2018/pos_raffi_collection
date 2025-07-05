<!-- Modal Delete Cabang -->
<div class="modal fade" id="modalDeleteCabang" tabindex="-1" aria-labelledby="modalDeleteCabangLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="modalDeleteCabangLabel">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p>Apakah Anda yakin ingin menghapus cabang ini?</p>
      </div>
      <div class="modal-footer">
        <form id="deleteCabangForm" method="POST">
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
  function openDeleteCabangModal(cabangId) {
    const form = document.getElementById('deleteCabangForm');
    form.action = `/cabang/${cabangId}`; // Sesuaikan dengan route destroy
    new bootstrap.Modal(document.getElementById('modalDeleteCabang')).show();
  }
</script>
