<!-- Modal Detail Cabang -->
<div class="modal fade" id="modalDetailCabang" tabindex="-1" aria-labelledby="modalDetailCabangLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="modalDetailCabangLabel">Detail Cabang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <dl class="row mb-0">
          <dt class="col-sm-4">Kode Cabang</dt>
          <dd class="col-sm-8" id="detail_kode_cabang"></dd>

          <dt class="col-sm-4">Nama Cabang</dt>
          <dd class="col-sm-8" id="detail_nama_cabang"></dd>

          <dt class="col-sm-4">Jam Buka</dt>
          <dd class="col-sm-8" id="detail_jam_buka"></dd>

          <dt class="col-sm-4">Jam Tutup</dt>
          <dd class="col-sm-8" id="detail_jam_tutup"></dd>

          <dt class="col-sm-4">Alamat</dt>
          <dd class="col-sm-8" id="detail_alamat"></dd>
        </dl>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<script>
    function openDetailCabangModal(cabang) {
  document.getElementById('detail_kode_cabang').innerText = cabang.kode_cabang;
  document.getElementById('detail_nama_cabang').innerText = cabang.nama_cabang;
  document.getElementById('detail_jam_buka').innerText = cabang.jam_buka;
  document.getElementById('detail_jam_tutup').innerText = cabang.jam_tutup;
  document.getElementById('detail_alamat').innerText = cabang.alamat;

  new bootstrap.Modal(document.getElementById('modalDetailCabang')).show();
}

</script>
