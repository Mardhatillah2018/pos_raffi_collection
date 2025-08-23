<!-- Modal Kurangi Stok admin cabang -->
<div class="modal fade" id="modalKurangiStok" tabindex="-1" aria-labelledby="kurangiStokLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('pengurangan.ajukan') }}" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="kurangiStokLabel">Kurangi Stok</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">

        <!-- Hidden ID -->
        <input type="hidden" name="detail_produk_id" id="kurangDetailProdukId">

        <input type="hidden" id="stokTersedia">

        <!-- Nama produk -->
        <div class="mb-3">
          <label for="namaProduk" class="form-label" style="color: black; font-weight: semibold;">Nama Produk</label>
          <input type="text" id="kurangNamaProduk" class="form-control" readonly>
        </div>

        <!-- Jumlah -->
        <div class="mb-3">
            <label class="form-label">Jumlah Pengurangan</label>
            <input type="number" name="qty" id="inputQty" class="form-control" required min="1">
            <small class="text-muted" id="infoStok"></small>
        </div>

        <!-- Alasan pengurangan -->
        <div class="mb-3">
          <label class="form-label" style="color: black; font-weight: semibold;">Alasan Pengurangan</label>
          <div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="alasan" id="alasanRusak" value="rusak" checked>
              <label class="form-check-label" for="alasanRusak">Rusak</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="alasan" id="alasanTransfer" value="transfer">
              <label class="form-check-label" for="alasanTransfer">Transfer ke Cabang</label>
            </div>
          </div>
        </div>

        <!-- Pilih cabang tujuan -->
        <div class="mb-3" id="cabangTujuanWrapper" style="display:none;">
          <label for="cabang_tujuan" class="form-label" style="color: black; font-weight: semibold;">Cabang Tujuan</label>
          <select name="cabang_tujuan" id="cabang_tujuan" class="form-select">
            @foreach($cabangs as $cabang)
              <option value="{{ $cabang->kode_cabang }}">{{ $cabang->nama_cabang }}</option>
            @endforeach
          </select>
        </div>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger">Kurangi</button>
      </div>
    </form>
  </div>
</div>

<script>
    document.querySelectorAll('input[name="alasan"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('cabangTujuanWrapper').style.display =
            (this.value === 'transfer') ? 'block' : 'none';
        });
    });

    // Fungsi dipanggil saat buka modal (dari tombol)
    function bukaModalKurangiStok(detailProdukId, namaProduk, stok) {
        document.getElementById('kurangDetailProdukId').value = detailProdukId;
        document.getElementById('kurangNamaProduk').value = namaProduk;
        document.getElementById('stokTersedia').value = stok;
        document.getElementById('inputQty').max = stok;
        document.getElementById('infoStok').innerText = "Stok tersedia: " + stok;
    }

     @if(session('stok_error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '{{ session('stok_error') }}',
            confirmButtonColor: '#d33',
        });
    @endif

</script>
