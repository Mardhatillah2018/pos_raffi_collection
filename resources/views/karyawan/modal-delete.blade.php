<!-- Modal Delete Karyawan -->
<div class="modal fade" id="modalDeleteKaryawan" tabindex="-1" aria-labelledby="modalDeleteKaryawanLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="modalDeleteKaryawanLabel">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p>Apakah Anda yakin ingin menghapus data karyawan ini?</p>
      </div>
      <div class="modal-footer">
        <form id="deleteKaryawanForm" method="POST">
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
  function openDeleteKaryawanModal(karyawanId) {
    const form = document.getElementById('deleteKaryawanForm');
    form.action = `/karyawan/${karyawanId}`;
    const modal = new bootstrap.Modal(document.getElementById('modalDeleteKaryawan'));
    modal.show();
  }
</script>
