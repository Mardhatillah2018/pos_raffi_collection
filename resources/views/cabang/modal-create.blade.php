<div class="modal fade" id="modalCabang" tabindex="-1" aria-labelledby="modalCabangLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-2">
      <form action="{{ route('cabang.store') }}" method="POST">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalCabangLabel">Tambah Cabang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="kode_cabang" class="form-label">Kode Cabang</label>
              <input type="text" name="kode_cabang" id="kode_cabang" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label for="nama_cabang" class="form-label">Nama Cabang</label>
              <input type="text" name="nama_cabang" id="nama_cabang" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label for="jam_buka" class="form-label">Jam Buka</label>
              <input type="time" name="jam_buka" id="jam_buka" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label for="jam_tutup" class="form-label">Jam Tutup</label>
              <input type="time" name="jam_tutup" id="jam_tutup" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label for="no_hp" class="form-label">No HP</label>
              <input type="text" name="no_hp" id="no_hp" class="form-control" required>
            </div>

            <div class="col-md-12">
              <label for="alamat" class="form-label">Alamat</label>
              <textarea name="alamat" id="alamat" class="form-control" rows="3" required></textarea>
            </div>
          </div>
        </div>

        <div class="modal-footer mt-3">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
    // cek kode cabang sudah tersedia atau belum
    document.addEventListener('DOMContentLoaded', function () {
        const kodeInput = document.getElementById('kode_cabang');
        const kodeErrorDiv = document.createElement('div');
        kodeErrorDiv.classList.add('invalid-feedback');
        kodeInput.parentElement.appendChild(kodeErrorDiv);

        kodeInput.addEventListener('blur', function () {
            const kode = kodeInput.value;

            if (kode.length === 0) return;

            fetch("{{ route('cabang.checkKode') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ kode_cabang: kode })
            })
            .then(res => res.json())
            .then(data => {
                if (data.exists) {
                    kodeInput.classList.add('is-invalid');
                    kodeErrorDiv.textContent = 'Kode cabang sudah dipakai.';
                } else {
                    kodeInput.classList.remove('is-invalid');
                    kodeErrorDiv.textContent = '';
                }
            })
            .catch(err => {
                console.error('Error checking kode cabang:', err);
            });
        });
    });
</script>
