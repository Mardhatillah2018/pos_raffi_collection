<!-- Modal Create User -->
<div class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="modalCreateUserLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-2">
      <form action="{{ route('user.store') }}" method="POST">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalCreateUserLabel">Tambah User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="create_nama" class="form-label">Nama Lengkap</label>
              <input type="text" name="nama" id="create_nama" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label for="create_email" class="form-label">Email</label>
              <input type="email" name="email" id="create_email" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label for="create_password" class="form-label">Password</label>
              <input type="password" name="password" id="create_password" class="form-control" required>
            </div>
            
            <div class="col-md-6">
                <label for="create_password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="create_password_confirmation" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label for="create_role" class="form-label">Role</label>
              <select name="role" id="create_role" class="form-select" required>
                <option value="">-- Pilih Role --</option>
                <option value="super_admin">Super Admin</option>
                <option value="admin_cabang">Admin Cabang</option>
              </select>
            </div>

            <div class="col-md-12" id="create_kodeCabangContainer" style="display: none;">
              <label for="create_kode_cabang" class="form-label">Cabang</label>
              <select name="kode_cabang" id="create_kode_cabang" class="form-select">
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
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  const createRoleSelect = document.getElementById('create_role');
  const createCabangContainer = document.getElementById('create_kodeCabangContainer');

  createRoleSelect.addEventListener('change', function () {
    createCabangContainer.style.display = this.value === 'admin_cabang' ? 'block' : 'none';
  });
</script>
