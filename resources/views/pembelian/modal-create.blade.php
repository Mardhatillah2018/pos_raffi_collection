<!-- Modal Tambah Pembelian -->
<div class="modal fade" id="modalPembelian" tabindex="-1" aria-labelledby="modalPembelianLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content p-2">
      <form action="{{ route('pembelian.store') }}" method="POST">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalPembelianLabel">Tambah Pembelian</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>

        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-6">
                <label for="tanggal_pembelian" class="form-label" style="color: black; font-weight: bold;">Tanggal Pembelian</label>
                <div class="input-group">
                    <input type="text" id="tanggal_pembelian" name="tanggal_pembelian" class="form-control" placeholder="YYYY-MM-DD" required>
                    <span class="input-group-text" id="btn-tanggal-pembelian">
                        <span class="material-symbols-rounded">calendar_today</span>
                    </span>
                </div>
            </div>

            <div class="col-md-6">
              <label for="total_biaya" class="form-label" style="color: black; font-weight: bold;">Total Biaya Pembelian (Rp)</label>
              <input type="number" name="total_biaya" class="form-control" required min="0" placeholder="Masukkan total biaya (Rp)">
            </div>
            <input type="hidden" name="kode_cabang" value="{{ Auth::user()->kode_cabang }}">
          </div>

          <div class="table-responsive mb-3">
            <table class="table table-bordered align-middle" id="tableCreatePembelian">
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
                          {{ $produk->produk->nama_produk ?? 'Nama Kosong' }} - {{ $produk->ukuran->kode_ukuran ?? 'Ukuran Kosong' }}
                        </option>
                      @endforeach
                    </select>
                  </td>
                  <td>
                    <input type="number" name="qty[]" class="form-control" required min="1" value="1">
                  </td>
                  <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger hapusBaris">
                            <span class="material-icons-round text-white" style="font-size: 18px;">delete</span>
                        </button>
                    </td>
                </tr>
              </tbody>
            </table>
            <button type="button" class="btn btn-sm btn-primary mt-2" id="tambahBarisCreate">+ Tambah Baris</button>
          </div>

          <div class="mb-3">
            <label for="keterangan" class="form-label" style="color: black; font-weight: bold;">Keterangan</label>
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
    // Kirim semua produk
    window.detailProduks = @json($detailProduks);

    document.addEventListener('DOMContentLoaded', function () {
        const tableCreate = document.querySelector('#tableCreatePembelian tbody');
        const tambahBtnCreate = document.querySelector('#tambahBarisCreate');

        function initSelect2(el) {
        $(el).select2({
            dropdownParent: $('#modalPembelian'),
            width: '100%'
        });
        }

        // produk ga bisa dipilih lebih dari 1 kali
        function refreshSelectOptions() {
            const allSelects = document.querySelectorAll('.select-produk');
            const selectedValues = Array.from(allSelects)
                .map(sel => sel.value)
                .filter(val => val !== '');

            allSelects.forEach(select => {
                const currentValue = select.value;

                // kosongkan opsi select
                select.innerHTML = '';
                const placeholder = document.createElement('option');
                placeholder.value = '';
                placeholder.textContent = '-- Pilih Produk --';
                select.appendChild(placeholder);

                // Tambahkan opsi produk yang belum dipilih
                window.detailProduks.forEach(produk => {
                const id = produk.id.toString();
                const nama = (produk.produk?.nama_produk ?? 'Nama Kosong') + ' - ' + (produk.ukuran?.kode_ukuran ?? 'Ukuran Kosong');
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

        // inisialisasi select yang sudah ada
        document.querySelectorAll('.select-produk').forEach(select => {
            initSelect2(select);
            });
        refreshSelectOptions();

        // Tambah baris
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
                <button type="button" class="btn btn-sm btn-danger hapusBaris">
                        <span class="material-icons-round text-white" style="font-size: 18px;">delete</span>
                    </button>
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

        // saat produk berubah, perbarui semua select lainnya
        tableCreate.addEventListener('change', function (e) {
            if (e.target.classList.contains('select-produk')) {
                refreshSelectOptions();
            }
        });
    });

    // pilih tanggal
    document.addEventListener("DOMContentLoaded", function () {
        const fp = flatpickr("#tanggal_pembelian", {
            dateFormat: "Y-m-d",
            allowInput: true,
            defaultDate: "today",
            maxDate: "today"
        });

        document.getElementById('btn-tanggal-pembelian').addEventListener('click', function () {
            fp.open();
        });
    });

    // review
    document.addEventListener('DOMContentLoaded', function () {
        const formPembelian = document.querySelector('#modalPembelian form');

        formPembelian.addEventListener('submit', function (e) {
            e.preventDefault(); // jangan submit langsung

            const tanggal = document.querySelector('#tanggal_pembelian').value;
            const totalBiaya = document.querySelector('input[name="total_biaya"]').value;
            const keterangan = document.querySelector('input[name="keterangan"]').value || '-';

            let produkRows = '';
            document.querySelectorAll('#tableCreatePembelian tbody tr').forEach(row => {
                const produk = row.querySelector('.select-produk option:checked').textContent;
                const qty = row.querySelector('input[name="qty[]"]').value;
                produkRows += `
                    <tr>
                        <td>${produk}</td>
                        <td class="text-center">${qty}</td>
                    </tr>
                `;
            });

            Swal.fire({
                title: 'Konfirmasi Simpan Data Pembelian',
                html: `
                    <table class="table table-bordered">
                        <tr>
                            <th>Tanggal</th>
                            <td>${tanggal}</td>
                        </tr>
                        <tr>
                            <th>Total Biaya</th>
                            <td>Rp ${parseFloat(totalBiaya).toLocaleString()}</td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>${keterangan}</td>
                        </tr>
                    </table>
                    <strong>Produk:</strong>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th class="text-center">Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${produkRows}
                        </tbody>
                    </table>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    formPembelian.submit();
                }
            });
        });
    });

</script>
