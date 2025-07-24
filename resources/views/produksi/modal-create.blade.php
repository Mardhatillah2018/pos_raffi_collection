<div class="modal fade" id="modalProduksi" tabindex="-1" aria-labelledby="modalProduksiLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content p-2">
      <form action="{{ route('produksi.store') }}" method="POST">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalProduksiLabel">Tambah Produksi</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="tanggal_produksi" class="form-label fw-bold">Tanggal Produksi</label>
              <input type="date" name="tanggal_produksi" id="tanggal_produksi" class="form-control" required>
            </div>

            <input type="hidden" name="kode_cabang" value="{{ Auth::user()->kode_cabang }}">

            <div class="col-md-6">
              <label for="total_biaya" class="form-label fw-bold">Total Biaya Produksi</label>
              <input type="number" name="total_biaya" id="total_biaya" class="form-control" step="0.01" required>
            </div>

            <div class="col-md-12">
              <label for="keterangan" class="form-label fw-bold">Keterangan (Opsional)</label>
              <textarea name="keterangan" id="keterangan" rows="3" class="form-control" placeholder="Contoh: Produksi kaos ukuran L, bahan cotton combed 30s, dll."></textarea>
            </div>

            <div class="col-md-12 mt-4">
              <label class="form-label fw-bold">Detail Produk yang Diproduksi</label>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th style="width: 60%">Produk</th>
                    <th style="width: 25%">Qty</th>
                    <th style="width: 15%">
                      <button type="button" class="btn btn-sm btn-primary py-1 px-2" id="tambahBaris">+</button>

                    </th>
                  </tr>
                </thead>
                <tbody id="detailProdukWrapper">
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
                      <input type="number" name="qty[]" class="form-control" required min="1">
                    </td>
                    <td class="text-center">
                      <button type="button" class="btn btn-sm btn-danger hapusBaris">-</button>
                    </td>
                  </tr>
                </tbody>
              </table>
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
  $(document).ready(function () {
    // Tambah baris detail produk
    $('#tambahBaris').click(function () {
      var baris = `
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
            <input type="number" name="qty[]" class="form-control" required min="1">
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger hapusBaris">-</button>
          </td>
        </tr>
      `;
      $('#detailProdukWrapper').append(baris);
    });

    // Hapus baris detail produk
    $(document).on('click', '.hapusBaris', function () {
      $(this).closest('tr').remove();
    });
  });
</script>

