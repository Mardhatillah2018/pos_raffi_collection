<!-- Modal Review Penjualan -->
<div class="modal fade" id="modalReviewPenjualan" tabindex="-1" aria-labelledby="modalReviewLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('penjualan.konfirmasi') }}" method="POST">
        @csrf
        <input type="hidden" name="no_struk" value="{{ $no_struk }}">
        <input type="hidden" name="tanggal_penjualan" value="{{ $tanggal_penjualan }}">
        <input type="hidden" name="total_harga" value="{{ $total_harga }}">

        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalReviewLabel" style="color: white"><i class="bi bi-receipt-cutoff me-2" style="color: white"></i>Review Penjualan</h5>
          <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <p><strong>No Struk:</strong> {{ $no_struk }}</p>
          <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($tanggal_penjualan)->format('d-m-Y') }}</p>

          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Produk</th>
                <th>Ukuran</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
              @foreach($produkDetails as $detail)
              <tr>
                <td>{{ $detail['produk'] }}</td>
                <td>{{ $detail['ukuran'] }}</td>
                <td>
                  {{ $detail['qty'] }}
                  <input type="hidden" name="detail_produk_id[]" value="{{ $detail['detail_produk_id'] }}">
                  <input type="hidden" name="qty[]" value="{{ $detail['qty'] }}">
                  <input type="hidden" name="harga_satuan[]" value="{{ $detail['harga'] }}">
                </td>
                <td>Rp {{ number_format($detail['harga'], 0, ',', '.') }}</td>
                <td>Rp {{ number_format($detail['subtotal'], 0, ',', '.') }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>

          <div class="text-end">
            <h5>Total: <strong class="text-success">Rp {{ number_format($total_harga, 0, ',', '.') }}</strong></h5>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i> Batal
          </button>
          <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle me-1"></i> Konfirmasi & Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
