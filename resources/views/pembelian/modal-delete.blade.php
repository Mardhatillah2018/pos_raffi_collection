<!-- Modal Delete Pembelian -->
<div class="modal fade" id="modalDeletePembelian" tabindex="-1" aria-labelledby="modalDeletePembelianLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="modalDeletePembelianLabel">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p>Apakah Anda yakin ingin menghapus data pembelian ini?</p>
        <span style="color: red; font-size: 0.8rem;">*Jika menghapus data pembelian ini, semua data terkait akan hilang.</span>
      </div>
      <div class="modal-footer">
        <form id="deletePembelianForm" method="POST">
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
  function openDeletePembelianModal(pembelianId) {
    const form = document.getElementById('deletePembelianForm');
    form.action = `/pembelian/${pembelianId}`;
    new bootstrap.Modal(document.getElementById('modalDeletePembelian')).show();
  }
</script>
