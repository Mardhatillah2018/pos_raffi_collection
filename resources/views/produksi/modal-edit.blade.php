<div class="modal fade" id="modalEditProduksi{{ $produksi->id }}" tabindex="-1" aria-labelledby="modalEditProduksiLabel{{ $produksi->id }}" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content p-2">
      <form action="{{ route('produksi.update', $produksi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalEditProduksiLabel{{ $produksi->id }}">Edit Produksi</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="tanggal_produksi" class="form-label fw-bold">Tanggal Produksi</label>
              <input type="date" name="tanggal_produksi" class="form-control" value="{{ $produksi->tanggal_produksi }}" required>
            </div>

            <input type="hidden" name="kode_cabang" value="{{ $produksi->kode_cabang }}">

            <div class="col-md-6">
              <label for="total_biaya" class="form-label fw-bold">Total Biaya Produksi</label>
              <input type="number" name="total_biaya" class="form-control" step="0.01" value="{{ $produksi->total_biaya }}" required>
            </div>

            <div class="col-md-12">
              <label for="keterangan" class="form-label fw-bold">Keterangan (Opsional)</label>
              <textarea name="keterangan" rows="3" class="form-control">{{ $produksi->keterangan }}</textarea>
            </div>

            <div class="col-md-12 mt-4">
              <label class="form-label fw-bold">Detail Produk yang Diproduksi</label>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th style="width: 60%">Produk</th>
                    <th style="width: 25%">Qty</th>
                    <th style="width: 15%">
                      <button type="button" class="btn btn-sm btn-primary py-1 px-2 tambahBarisEdit">+</button>
                    </th>
                  </tr>
                </thead>
                <tbody class="editDetailWrapper">
                  @foreach ($produksi->detailProduksis as $detail)
                  <tr>
                    <td>
                      <select name="detail_produk_id[]" class="form-select select-produk" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach ($detailProduks as $produk)
                          <option value="{{ $produk->id }}" {{ $produk->id == $detail->detail_produk_id ? 'selected' : '' }}>
                            {{ $produk->produk->nama_produk ?? 'Nama Kosong' }} - {{ $produk->ukuran->nama_ukuran ?? 'Ukuran Kosong' }}
                          </option>
                        @endforeach
                      </select>
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
            </div>
          </div>
        </div>

        <div class="modal-footer mt-3">
          <button type="submit" class="btn btn-success">Update</button>
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  $(document).on('click', '.tambahBarisEdit', function () {
    const row = `
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
    $(this).closest('.modal-body').find('.editDetailWrapper').append(row);
  });

  $(document).on('click', '.hapusBaris', function () {
    $(this).closest('tr').remove();
  });
</script>
