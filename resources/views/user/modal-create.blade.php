<!-- Modal Tambah User -->
<div class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="modalUserLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-2">
      <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalUserLabel">Tambah User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="nama" class="form-label">Nama Lengkap</label>
              <input type="text" name="nama" id="nama" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="col-md-6 position-relative">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" id="password" class="form-control" required>
    <i class="bi bi-eye-slash toggle-password" toggle="#password"
       style="position: absolute; top: 38px; right: 15px; cursor: pointer;"></i>
</div>

<div class="col-md-6 position-relative">
    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
    <i class="bi bi-eye-slash toggle-password" toggle="#password_confirmation"
       style="position: absolute; top: 38px; right: 15px; cursor: pointer;"></i>
</div>


            <div class="col-md-6">
              <label for="roleSelect" class="form-label">Role</label>
              <select name="role" id="roleSelect" class="form-select" required>
                <option value="">-- Pilih Role --</option>
                <option value="super_admin">Super Admin</option>
                <option value="admin_cabang">Admin Cabang</option>
              </select>
            </div>

            <div class="col-md-12" id="kodeCabangContainer" style="display: none;">
              <label for="kode_cabang" class="form-label">Cabang</label>
              <select name="kode_cabang" id="kode_cabang" class="form-select">
                <option value="">-- Pilih Cabang --</option>
                @foreach ($cabangs as $cabang)
                  <option value="{{ $cabang->kode_cabang }}">
                    {{ $cabang->nama_cabang }} ({{ $cabang->kode_cabang }})
                  </option>
                @endforeach
              </select>
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
    // kode cabang
  document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('roleSelect');
    const kodeCabangContainer = document.getElementById('kodeCabangContainer');

    function toggleKodeCabang() {
      kodeCabangContainer.style.display = (roleSelect.value === 'admin_cabang') ? 'block' : 'none';
    }

    roleSelect.addEventListener('change', toggleKodeCabang);

    toggleKodeCabang();
  });

  document.querySelectorAll('.toggle-password').forEach(function (el) {
        el.addEventListener('click', function () {
            const target = document.querySelector(this.getAttribute('toggle'));

            if (target.type === 'password') {
                target.type = 'text';
                this.classList.remove('bi-eye-slash');
                this.classList.add('bi-eye');
            } else {
                target.type = 'password';
                this.classList.remove('bi-eye');
                this.classList.add('bi-eye-slash');
            }
        });
    });
</script>
