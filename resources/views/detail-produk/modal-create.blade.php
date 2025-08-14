<!-- Modal Tambah Detail Produk -->
<div class="modal fade" id="modalTambahDetailProduk" tabindex="-1" aria-labelledby="modalTambahDetailProdukLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-2">
      <form action="{{ route('detail-produk.store') }}" method="POST">
        @csrf
        <input type="hidden" name="produk_id" value="{{ $produk->id }}">

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalTambahDetailProdukLabel">Tambah Detail Produk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="ukuran_id" class="form-label" style="color: black; font-weight: bold;">Ukuran</label>
              <select name="ukuran_id" id="ukuran_id" class="form-select select2" required>
                <option value="">-- Pilih Ukuran --</option>
                @foreach ($ukuranList as $ukuran)
                  <option value="{{ $ukuran->id }}">{{ $ukuran->kode_ukuran }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label for="harga_modal" class="form-label" style="color: black; font-weight: bold;">Harga Modal</label>
              <input type="number" name="harga_modal" id="harga_modal" class="form-control" min="0" placeholder="Masukkan Harga Modal" required>
            </div>

            <div class="col-md-6">
                <label for="harga_jual" class="form-label" style="color: black; font-weight: bold;">Harga Jual</label>
                <input type="number" name="harga_jual" id="harga_jual" class="form-control bg-light" min="0" placeholder="Harga Jual" readonly>
            </div>

          </div>
        </div>

        <div class="modal-footer mt-3">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    $('.select2').select2({
        dropdownParent: $('#modalTambahDetailProduk'),
        placeholder: "-- Pilih Ukuran --",
        width: '100%'
    });

    const hargaModalInput = document.getElementById('harga_modal');
    const hargaJualInput = document.getElementById('harga_jual');

    hargaModalInput.addEventListener('input', function () {
        const modalValue = parseFloat(this.value) || 0;
        const hargaJual = Math.ceil(modalValue * 1.5 / 1000) * 1000; // bulat ke atas 1000
        hargaJualInput.value = hargaJual;
    });
});
</script>



