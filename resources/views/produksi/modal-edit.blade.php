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
              <label for="tanggal_produksi" class="form-label">Tanggal Produksi</label>
              <input type="date" name="tanggal_produksi" class="form-control" value="{{ $produksi->tanggal_produksi }}" required>
            </div>
            <div class="col-md-4">
              <label for="total_biaya" class="form-label">Total Biaya Produksi (Rp)</label>
              <input type="number" name="total_biaya" class="form-control" value="{{ $produksi->total_biaya }}" required min="0">
            </div>
            <div class="col-md-4">
              <label for="keterangan" class="form-label">Keterangan</label>
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
                        $namaProduk = $detail->detailProduk
                            ? ($detail->detailProduk->produk->nama_produk ?? '-') . ' - ' . ($detail->detailProduk->ukuran->nama_ukuran ?? '-')
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

<!-- Script untuk tambah dan hapus baris -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const table = document.querySelector('#tableEditProduksi{{ $produksi->id }} tbody');
    const tambahBtn = document.querySelector('#tambahBarisEdit{{ $produksi->id }}');

    tambahBtn.addEventListener('click', function () {
      const baris = document.createElement('tr');
      baris.innerHTML = `
        <td>
          <select name="detail_produk_id[]" class="form-select" required>
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
      `;
      table.appendChild(baris);
    });

    table.addEventListener('click', function (e) {
      if (e.target.classList.contains('hapusBaris')) {
        e.target.closest('tr').remove();
      }
    });
  });
</script>
