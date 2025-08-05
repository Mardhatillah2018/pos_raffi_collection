<!-- Modal Edit Pembelian -->
<div class="modal fade" id="modalEditPembelian{{ $pembelian->id }}" tabindex="-1" aria-labelledby="modalEditPembelianLabel{{ $pembelian->id }}" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content p-2">
      <form action="{{ route('pembelian.update', $pembelian->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title fw-bold">Edit Pembelian - {{ $pembelian->tanggal_pembelian }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>

        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-4">
                <label for="tanggal_pembelian" class="form-label" style="color: black; font-weight: bold;">Tanggal Pembelian</label>
                <div class="input-group">
                    <input type="text" id="tanggal_pembelian" name="tanggal_pembelian" class="form-control"
                        placeholder="YYYY-MM-DD" value="{{ $pembelian->tanggal_pembelian }}" required>
                    <span class="input-group-text" id="btn-tanggal-pembelian">
                        <span class="material-symbols-rounded">calendar_today</span>
                    </span>
                </div>
            </div>

            <div class="col-md-4">
              <label class="form-label" style="color: black; font-weight: bold;">Total Biaya Pembelian (Rp)</label>
              <input type="number" name="total_biaya" class="form-control" value="{{ $pembelian->total_biaya }}" required min="0">
            </div>
            <div class="col-md-4">
              <label class="form-label" style="color: black; font-weight: bold;">Keterangan</label>
              <input type="text" name="keterangan" class="form-control" value="{{ $pembelian->keterangan }}">
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-bordered align-middle" id="tableEditPembelian{{ $pembelian->id }}">
              <thead class="table-light text-center">
                <tr>
                  <th>Produk</th>
                  <th>Qty</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($pembelian->detailPembelian as $detail)
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
                        <button type="button" class="btn btn-sm btn-danger hapusBaris">
                            <span class="material-icons-round text-white" style="font-size: 18px;">delete</span>
                        </button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <button type="button" class="btn btn-sm btn-primary mt-2" id="tambahBarisEdit{{ $pembelian->id }}">+ Tambah Baris</button>
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
    const table = document.querySelector('#tableEditPembelian{{ $pembelian->id }} tbody');
    const tambahBtn = document.querySelector('#tambahBarisEdit{{ $pembelian->id }}');

    function initSelect2(el) {
      $(el).select2({
        dropdownParent: $('#modalEditPembelian{{ $pembelian->id }}'),
        width: '100%'
      });
    }

    function getSelectedProdukIDs() {
      const ids = [];

      table.querySelectorAll('input[name="detail_produk_id[]"]').forEach(input => {
        if (input.type === 'hidden') ids.push(input.value);
      });

      table.querySelectorAll('select[name="detail_produk_id[]"]').forEach(select => {
        if (select.value) ids.push(select.value);
      });

      return ids;
    }

    function refreshSelectOptions() {
      const selected = getSelectedProdukIDs();
      const selects = table.querySelectorAll('select[name="detail_produk_id[]"]');

      selects.forEach(select => {
        const currentVal = select.value;
        select.innerHTML = '<option value="">-- Pilih Produk --</option>';

        window.detailProduks.forEach(produk => {
          const id = produk.id.toString();
          const nama = (produk.produk?.nama_produk ?? 'Nama Kosong') + ' - ' + (produk.ukuran?.kode_ukuran ?? 'Ukuran Kosong');
          const isUsed = selected.includes(id) && id !== currentVal;

          if (!isUsed) {
            const option = document.createElement('option');
            option.value = id;
            option.textContent = nama;
            if (id === currentVal) option.selected = true;
            select.appendChild(option);
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
      const select = tr.querySelector('select');
      initSelect2(select);
      refreshSelectOptions();
    });

    table.addEventListener('click', function (e) {
      if (e.target.classList.contains('hapusBaris')) {
        e.target.closest('tr').remove();
        refreshSelectOptions();
      }
    });

    table.addEventListener('change', function (e) {
      if (e.target.classList.contains('select-produk')) {
        refreshSelectOptions();
      }
    });
  });
  flatpickr("#tanggal_pembelian", {
        dateFormat: "Y-m-d",
        allowInput: true,
    });

    document.getElementById('btn-tanggal-pembelian').addEventListener('click', function () {
        document.getElementById('tanggal_pembelian').focus();
    });
</script>
