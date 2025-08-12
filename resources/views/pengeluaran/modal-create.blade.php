<div class="modal fade" id="modalPengeluaran" tabindex="-1" aria-labelledby="modalPengeluaranLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-2">
      <form action="{{ route('pengeluaran.store') }}" method="POST">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalPengeluaranLabel">Tambah Pengeluaran</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="tanggal" class="form-label fw-bold" style="color: black; font-weight: bold;">Tanggal</label>
              <input type="text" name="tanggal" id="tanggal" class="form-control flatpickr" placeholder="Pilih tanggal" required>
            </div>

            <div class="col-md-6">
              <label for="kategori_pengeluaran_id" class="form-label fw-bold" style="color: black; font-weight: bold;">Kategori Pengeluaran</label>
              @php
                    $allowedKategori = [1, 2, 6, 9];
                @endphp

                <select name="kategori_pengeluaran_id" id="kategori_pengeluaran_id" class="form-select select2" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategori_pengeluarans as $kategori)
                    @if (Auth::user()->role !== 'admin_cabang' || in_array($kategori->id, $allowedKategori))
                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                    @endif
                @endforeach
                </select>

            </div>

            <div class="col-md-6">
              <label for="total_pengeluaran" class="form-label fw-bold" style="color: black; font-weight: bold;">Total Pengeluaran</label>
              <input type="number" name="total_pengeluaran" id="total_pengeluaran" class="form-control" step="0.01" placeholder="Masukkan Total Pengeluaran" required>
            </div>

            <div class="col-md-12">
              <label for="keterangan" class="form-label fw-bold" style="color: black; font-weight: bold;">Keterangan (Opsional)</label>
              <textarea name="keterangan" id="keterangan" rows="3" class="form-control" placeholder="Contoh: Bayar listrik, pembelian alat, dll."></textarea>
            </div>
          </div>
        </div>

        <div class="modal-footer mt-3">
          <button type="submit" class="btn btn-success">Simpan</button>
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#kategori_pengeluaran_id').select2({
      dropdownParent: $('#modalPengeluaran'),
      width: '100%'
    });
  });

  document.addEventListener("DOMContentLoaded", function () {
        flatpickr(".flatpickr", {
            dateFormat: "Y-m-d",
            defaultDate: "today",
            maxDate: "today"
        });
    });
</script>
