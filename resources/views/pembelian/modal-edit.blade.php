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
              <label for="tanggal_pembelian" class="form-label">Tanggal Pembelian</label>
              <input type="date" name="tanggal_pembelian" class="form-control" value="{{ $pembelian->tanggal_pembelian }}" required>
            </div>
            <div class="col-md-4">
              <label for="total_biaya" class="form-label">Total Biaya Pembelian (Rp)</label>
              <input type="number" name="total_biaya" class="form-control" value="{{ $pembelian->total_biaya }}" required min="0">
            </div>
            <div class="col-md-4">
              <label for="keterangan" class="form-label">Keterangan</label>
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

<!-- Script untuk tambah dan hapus baris -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const table = document.querySelector('#tableEditPembelian{{ $pembelian->id }} tbody');
    const tambahBtn = document.querySelector('#tambahBarisEdit{{ $pembelian->id }}');

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
