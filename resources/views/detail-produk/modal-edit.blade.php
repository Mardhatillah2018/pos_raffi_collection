@foreach ($produk->detailProduks as $detail)
<!-- Modal Edit Detail Produk -->
<div class="modal fade" id="modalEditDetailProduk{{ $detail->id }}" tabindex="-1" aria-labelledby="modalEditDetailProdukLabel{{ $detail->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-2">
      <form action="{{ route('detail-produk.update', $detail->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="produk_id" value="{{ $detail->produk_id }}">

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalEditDetailProdukLabel{{ $detail->id }}">Edit Detail Produk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Ukuran</label>
                <input type="hidden" name="ukuran_id" value="{{ $detail->ukuran_id }}">
                <input type="text" class="form-control" value="{{ $detail->ukuran->kode_ukuran }}" disabled>
            </div>


            <div class="col-md-6">
              <label for="harga_modal{{ $detail->id }}" class="form-label">Harga Modal</label>
              <input type="number" name="harga_modal" id="harga_modal{{ $detail->id }}" class="form-control" min="0" value="{{ $detail->harga_modal }}" required>
            </div>

            <div class="col-md-6">
              <label for="harga_jual{{ $detail->id }}" class="form-label">Harga Jual</label>
              <input type="number" name="harga_jual" id="harga_jual{{ $detail->id }}" class="form-control" min="0" value="{{ $detail->harga_jual }}" required>
            </div>
          </div>
        </div>

        <div class="modal-footer mt-3">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

<script>
    function openEditDetailModal(detail) {
    const modalId = '#modalEditDetailProduk' + detail.id;
    const modal = new bootstrap.Modal(document.querySelector(modalId));
    modal.show();
    }
    document.addEventListener('DOMContentLoaded', function () {
    $('.select2').each(function () {
      const modal = $(this).closest('.modal');
      $(this).select2({
        dropdownParent: modal,
        placeholder: "-- Pilih Ukuran --",
        width: '100%'
      });
    });
  });
</script>
