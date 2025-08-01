<!-- Modal Tambah Produksi -->
<div class="modal fade" id="modalProduksi" tabindex="-1" aria-labelledby="modalProduksiLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content p-2">
      <form action="{{ route('produksi.store') }}" method="POST">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalProduksiLabel">Tambah Produksi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>

        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="tanggal_produksi" class="form-label">Tanggal Produksi</label>
              <input type="date" name="tanggal_produksi" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="total_biaya" class="form-label">Total Biaya Produksi (Rp)</label>
              <input type="number" name="total_biaya" class="form-control" required min="0">
            </div>
            <input type="hidden" name="kode_cabang" value="{{ Auth::user()->kode_cabang }}">
          </div>

          <div class="table-responsive mb-3">
            <table class="table table-bordered align-middle" id="tableCreateProduksi">
              <thead class="table-light text-center">
                <tr>
                  <th>Produk</th>
                  <th>Qty</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <select name="detail_produk_id[]" class="form-select select-produk" required>
                      <option value="">-- Pilih Produk --</option>
                      @foreach ($detailProduks as $produk)
                        <option value="{{ $produk->id }}">
                          {{ $produk->produk->nama_produk ?? 'Nama Kosong' }} - {{ $produk->ukuran->nama_ukuran ?? 'Ukuran Kosong' }}
                        </option>
                      @endforeach
                    </select>
                  </td>
                  <td>
                    <input type="number" name="qty[]" class="form-control" required min="1" value="1">
                  </td>
                  <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger hapusBaris">-</button>
                  </td>
                </tr>
              </tbody>
            </table>
            <button type="button" class="btn btn-sm btn-primary mt-2" id="tambahBarisCreate">+ Tambah Baris</button>
          </div>

          <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" placeholder="Opsional">
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan</button>
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  window.detailProduks = @json($detailProduks);
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const tableCreate = document.querySelector('#tableCreateProduksi tbody');
    const tambahBtnCreate = document.querySelector('#tambahBarisCreate');

    // Inisialisasi Select2 (gunakan dropdownParent agar tidak tertutup modal)
    function initSelect2(el) {
      $(el).select2({
        dropdownParent: $('#modalProduksi'),
        width: '100%'
      });
    }

    // Fungsi untuk refresh opsi select agar produk tidak bisa dipilih lebih dari satu kali
    function refreshSelectOptions() {
      const allSelects = document.querySelectorAll('.select-produk');
      const selectedValues = Array.from(allSelects)
        .map(sel => sel.value)
        .filter(val => val !== '');

      allSelects.forEach(select => {
        const currentValue = select.value;

        // Kosongkan select
        select.innerHTML = '';
        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = '-- Pilih Produk --';
        select.appendChild(placeholder);

        // Tambahkan ulang opsi yang belum dipilih di select lain
        window.detailProduks.forEach(produk => {
          const id = produk.id.toString();
          const nama = (produk.produk?.nama_produk ?? 'Nama Kosong') + ' - ' + (produk.ukuran?.nama_ukuran ?? 'Ukuran Kosong');
          const isUsed = selectedValues.includes(id) && id !== currentValue;

          if (!isUsed) {
            const opt = document.createElement('option');
            opt.value = id;
            opt.textContent = nama;
            if (id === currentValue) opt.selected = true;
            select.appendChild(opt);
          }
        });

        $(select).trigger('change.select2');
      });
    }

    // Inisialisasi select yang sudah ada
    document.querySelectorAll('.select-produk').forEach(select => {
      initSelect2(select);
    });
    refreshSelectOptions();

    // Tambah baris baru
    tambahBtnCreate.addEventListener('click', function () {
      const newRow = document.createElement('tr');
      newRow.innerHTML = `
        <td>
          <select name="detail_produk_id[]" class="form-select select-produk" required>
            <option value="">-- Pilih Produk --</option>
          </select>
        </td>
        <td>
          <input type="number" name="qty[]" class="form-control" required min="1" value="1">
        </td>
        <td class="text-center">
          <button type="button" class="btn btn-sm btn-danger hapusBaris">-</button>
        </td>
      `;
      tableCreate.appendChild(newRow);

      const newSelect = newRow.querySelector('.select-produk');
      initSelect2(newSelect);
      refreshSelectOptions();
    });

    // Hapus baris
    tableCreate.addEventListener('click', function (e) {
      if (e.target.classList.contains('hapusBaris')) {
        e.target.closest('tr').remove();
        refreshSelectOptions();
      }
    });

    // Saat produk berubah, perbarui semua select lainnya
    tableCreate.addEventListener('change', function (e) {
      if (e.target.classList.contains('select-produk')) {
        refreshSelectOptions();
      }
    });
  });
</script>


