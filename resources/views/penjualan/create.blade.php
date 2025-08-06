@extends('layouts.main')

@section('content')
<div class="container mt-4">
    @php
        $reviewData = session('reviewData');
    @endphp

    <form action="{{ route('penjualan.review') }}" method="POST">
        @csrf

        <div class="card shadow mb-4">
            <div class="card-header bg-dark text-white fw-bold">
                <i class="bi bi-cart-plus-fill me-2"></i>Form Penjualan
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">No Faktur</label>
                        <input type="text" name="no_faktur" class="form-control" value="{{ $reviewData['no_faktur'] ?? $noFaktur }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tanggal Penjualan</label>
                        <div class="form-control bg-light border-0">{{ date('d-m-Y') }}</div>
                        <input type="hidden" name="tanggal_penjualan" value="{{ $reviewData['tanggal_penjualan'] ?? date('Y-m-d') }}">
                    </div>
                </div>

                <h5 class="fw-bold mb-3 text-info"><i class="bi bi-box-seam me-2"></i>Detail Produk</h5>

                <div class="table-responsive mb-3">
                    <table class="table table-bordered align-middle" id="produkTable">
                        <thead class="table-light text-center">
                            <tr>
                                <th style="width: 40%">Produk</th>
                                <th style="width: 15%">Qty</th>
                                <th style="width: 20%">Harga Satuan</th>
                                <th style="width: 20%">Subtotal</th>
                                <th style="width: 5%"></th>
                            </tr>
                        </thead>
                        <tbody id="produkBody">
                            @if($reviewData && isset($reviewData['produkDetails']))
                                @foreach($reviewData['produkDetails'] as $index => $detail)
                                <tr>
                                    <td>
                                        <select name="detail_produk_id[]" class="produk-select" required style="width: 100%">
                                            <option value="">-- Pilih Produk --</option>
                                            @foreach ($detailProduks as $dp)
                                                @php
                                                    $stok = $dp->stokCabang->stok ?? 0;
                                                    $selected = $dp->id == $detail['detail_produk_id'] ? 'selected' : '';
                                                @endphp
                                                <option value="{{ $dp->id }}"
                                                        data-harga="{{ $dp->harga_jual }}"
                                                        data-stok="{{ $stok }}"
                                                        {{ $stok < 1 ? 'disabled class=text-danger' : '' }}
                                                        {{ $selected }}>
                                                    {{ $dp->produk->nama_produk }} - {{ $dp->ukuran->kode_ukuran }}
                                                    {{ $stok < 1 ? '(Stok Habis)' : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="number" name="qty[]" class="form-control qty text-end" min="1" value="{{ $detail['qty'] }}" required></td>
                                    <td><input type="number" name="harga_satuan[]" class="form-control harga text-end" readonly value="{{ $detail['harga'] }}"></td>
                                    <td><input type="text" class="form-control subtotal text-end bg-light" readonly value="{{ $detail['subtotal'] }}"></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-danger btn-remove">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                {{-- Baris default jika belum ada review --}}
                                <tr>
                                    <td>
                                        <select name="detail_produk_id[]" class="produk-select" required style="width: 100%">
                                            <option value="">-- Pilih Produk --</option>
                                            @foreach ($detailProduks as $dp)
                                                @php $stok = $dp->stokCabang->stok ?? 0; @endphp
                                                <option value="{{ $dp->id }}" data-harga="{{ $dp->harga_jual }}"
                                                    data-stok="{{ $stok }}"
                                                    {{ $stok < 1 ? 'disabled class=text-danger' : '' }}>
                                                    {{ $dp->produk->nama_produk }} - {{ $dp->ukuran->kode_ukuran }}
                                                    {{ $stok < 1 ? '(Stok Habis)' : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="number" name="qty[]" class="form-control qty text-end" min="1" value="1" required></td>
                                    <td><input type="number" name="harga_satuan[]" class="form-control harga text-end" readonly></td>
                                    <td><input type="text" class="form-control subtotal text-end bg-light" readonly></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-danger btn-remove">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-outline-info btn-sm" id="btnAddRow">
                        <i class="bi bi-plus-circle me-1"></i>Tambah Baris
                    </button>

                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="keterangan" class="form-label fw-semibold">Keterangan (Opsional)</label>
                        <textarea name="keterangan" rows="2" class="form-control" placeholder="Masukkan keterangan penjualan jika ada"></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <div class="text-end">
                        <label class="fw-bold fs-5 text-success">Total Harga</label>
                        <input type="text" id="totalHarga" name="total_harga"
                            class="form-control fw-bold text-end fs-5 bg-light border-0"
                            readonly value="{{ $reviewData['total_harga'] ?? '' }}">
                    </div>
                </div>
            </div>

            <div class="card-footer text-end bg-light">
                <button type="submit" class="btn btn-success"><i class="bi bi-save me-1"></i>Review</button>
                <a href="{{ route('penjualan.index') }}" class="btn btn-secondary ms-2"><i class="bi bi-x-circle me-1"></i>Batal</a>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function updateSubtotal(row) {
        const qty = parseFloat(row.find('.qty').val()) || 0;
        const harga = parseFloat(row.find('.harga').val()) || 0;
        const subtotal = qty * harga;
        row.find('.subtotal').val(subtotal.toFixed(2));
        updateTotal();
    }

    function updateTotal() {
        let total = 0;
        $('.subtotal').each(function () {
            total += parseFloat($(this).val()) || 0;
        });
        $('#totalHarga').val(total.toFixed(2));
    }

    function initSelect2() {
        $('.produk-select').select2({
            placeholder: "-- Pilih Produk --",
            width: '100%'
        });
    }

    function getSelectedProdukIds() {
        const ids = [];
        $('.produk-select').each(function () {
            const val = $(this).val();
            if (val) {
                ids.push(val);
            }
        });
        return ids;
    }

    function updateProdukOptions() {
        const selectedIds = getSelectedProdukIds();

        $('.produk-select').each(function () {
            const currentSelect = $(this);
            const currentValue = currentSelect.val();

            currentSelect.find('option').each(function () {
                const optionVal = $(this).attr('value');
                if (!optionVal) return;

                if (selectedIds.includes(optionVal) && optionVal !== currentValue) {
                    $(this).attr('disabled', true);
                } else {
                    $(this).attr('disabled', false);
                }
            });
        });
    }

    $(document).on('input', '.qty, .harga', function () {
        const row = $(this).closest('tr');
        const qtyInput = row.find('.qty');
        const max = parseInt(qtyInput.attr('max')) || Infinity;
        const currentVal = parseInt(qtyInput.val()) || 0;

        if (currentVal > max) {
            Swal.fire({
                icon: 'warning',
                title: 'Stok Tidak Cukup',
                text: 'Qty melebihi stok yang tersedia (' + max + ')',
                timer: 2000,
                showConfirmButton: false
            });
            qtyInput.val(max);
        }

        updateSubtotal(row);
    });

    $('#btnAddRow').on('click', function () {
        const firstRow = $('#produkBody tr:first');

        // Destroy Select2 sebelum clone
        firstRow.find('.produk-select').select2('destroy');

        // Clone dan bersihkan
        const newRow = firstRow.clone();
        newRow.find('select').val('').trigger('change');
        newRow.find('.qty').val('1').removeAttr('max');
        newRow.find('.harga').val('');
        newRow.find('.subtotal').val('0.00');

        $('#produkBody').append(newRow);

        // Re-init Select2
        initSelect2();

        updateProdukOptions();
    });


    $(document).on('click', '.btn-remove', function () {
        if ($('#produkBody tr').length > 1) {
            $(this).closest('tr').remove();
            updateTotal();
            updateProdukOptions();
        }
    });

    $(document).on('change', '.produk-select', function () {
        const selected = $(this).find('option:selected');
        const harga = selected.data('harga') || 0;
        const stok = selected.data('stok') || 0;

        const row = $(this).closest('tr');
        row.find('.harga').val(harga);
        row.find('.qty').attr('max', stok).val(1);
        updateSubtotal(row);
        updateProdukOptions();
    });


    $(document).ready(function () {
        updateSubtotal($('#produkBody tr:first'));
        initSelect2();
        updateProdukOptions();
    });
</script>
@if(session('reviewData'))
        @include('penjualan.modal-review', session('reviewData'))

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var reviewModal = new bootstrap.Modal(document.getElementById('modalReviewPenjualan'));
                reviewModal.show();
            });
        </script>
    @endif
@endpush
