<!-- Modal Edit Produksi -->
<div class="modal fade" id="modalEditProduksi{{ $produksi->id }}" tabindex="-1" aria-labelledby="modalEditProduksiLabel{{ $produksi->id }}" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content p-2">
      <form action="{{ route('produksi.update', $produksi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title fw-bold">Edit Produksi - {{ $produksi->tanggal_produksi }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>

        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label">Tanggal Produksi</label>
              <input type="date" name="tanggal_produksi" class="form-control" value="{{ $produksi->tanggal_produksi }}" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Total Biaya Produksi (Rp)</label>
              <input type="number" name="total_biaya" class="form-control" value="{{ $produksi->total_biaya }}" required min="0">
            </div>
            <div class="col-md-4">
              <label class="form-label">Keterangan</label>
              <input type="text" name="keterangan" class="form-control" value="{{ $produksi->keterangan }}">
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-bordered align-middle" id="tableEditProduksi{{ $produksi->id }}">
              <thead class="table-light text-center">
                <tr>
                  <th>Produk</th>
                  <th>Qty</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($produksi->detailProduksis as $detail)
                  @php
                      $produk = $detail->detailProduk;
                      $namaProduk = $produk
                          ? ($produk->produk->nama_produk ?? '-') . ' - ' . ($produk->ukuran->kode_ukuran ?? '-')
                          : 'Produk tidak ditemukan (sudah dihapus)';
                  @endphp
                  <tr>
                    <td>
                      <input type="hidden" name="detail_produk_id[]" value="{{ $detail->detail_produk_id }}">
                      <input type="text" class="form-control-plaintext" readonly value="{{ $namaProduk }}">
                    </td>
                    <td>
                      <input type="number" name="qty[]" class="form-control" value="{{ $detail->qty }}" required min="1">
                    </td>
                    <td class="text-center">
                      <button type="button" class="btn btn-sm btn-danger hapusBaris">-</button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <button type="button" class="btn btn-sm btn-primary mt-2" id="tambahBarisEdit{{ $produksi->id }}">+ Tambah Baris</button>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan Perubahan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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
    const table = document.querySelector('#tableEditProduksi{{ $produksi->id }} tbody');
    const tambahBtn = document.querySelector('#tambahBarisEdit{{ $produksi->id }}');

    function initSelect2(el) {
      $(el).select2({
        dropdownParent: $('#modalEditProduksi{{ $produksi->id }}'),
        width: '100%'
      });
    }

    function getSelectedProdukIDs() {
      const hiddenInputs = table.querySelectorAll('input[name="detail_produk_id[]"][type="hidden"]');
      const selectInputs = table.querySelectorAll('select[name="detail_produk_id[]"]');
      const ids = [];

      hiddenInputs.forEach(input => ids.push(input.value));
      selectInputs.forEach(select => {
        if (select.value) ids.push(select.value);
      });

      return ids;
    }

    function refreshSelectOptions() {
      const allSelects = table.querySelectorAll('select[name="detail_produk_id[]"]');
      const selectedIds = getSelectedProdukIDs();

      allSelects.forEach(select => {
        const currentVal = select.value;
        select.innerHTML = '<option value="">-- Pilih Produk --</option>';

        window.detailProduks.forEach(produk => {
          const id = produk.id.toString();
          const nama = (produk.produk?.nama_produk ?? 'Nama Kosong') + ' - ' + (produk.ukuran?.kode_ukuran ?? 'Ukuran Kosong');
          const isUsed = selectedIds.includes(id) && id !== currentVal;

          if (!isUsed) {
            const opt = document.createElement('option');
            opt.value = id;
            opt.textContent = nama;
            if (id === currentVal) opt.selected = true;
            select.appendChild(opt);
          }
        });

        $(select).trigger('change.select2');
      });
    }

    tambahBtn.addEventListener('click', function () {
      const tr = document.createElement('tr');
      tr.innerHTML = `
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
      table.appendChild(tr);
      const newSelect = tr.querySelector('select');
      initSelect2(newSelect);
      refreshSelectOptions();
    });

    table.addEventListener('click', function (e) {
      if (e.target.classList.contains('hapusBaris')) {
        const tr = e.target.closest('tr');
        tr.remove();
        refreshSelectOptions();
      }
    });

    table.addEventListener('change', function (e) {
      if (e.target.classList.contains('select-produk')) {
        refreshSelectOptions();
      }
    });
  });
</script>
