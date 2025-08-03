<!-- Modal Edit User -->
<div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-2">
      <form id="editUserForm" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalEditUserLabel">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="edit_nama" class="form-label">Nama Lengkap</label>
              <input type="text" name="nama" id="edit_nama" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label for="edit_email" class="form-label">Email</label>
              <input type="email" name="email" id="edit_email" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label for="edit_role" class="form-label">Role</label>
              <select name="role" id="edit_role" class="form-select" required>
                <option value="">-- Pilih Role --</option>
                <option value="super_admin">Super Admin</option>
                <option value="admin_cabang">Admin Cabang</option>
              </select>
            </div>

            <div class="col-md-12" id="edit_kodeCabangContainer" style="display: none;">
              <label for="edit_kode_cabang" class="form-label">Cabang</label>
              <select name="kode_cabang" id="edit_kode_cabang" class="form-select">
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
          <button type="submit" class="btn btn-primary" id="edit-submit">Perbarui</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function openEditModal(user) {
    document.getElementById('edit_nama').value = user.nama;
    document.getElementById('edit_email').value = user.email;
    document.getElementById('edit_role').value = user.role;

    const container = document.getElementById('edit_kodeCabangContainer');
    const kodeCabangSelect = document.getElementById('edit_kode_cabang');

    if (user.role === 'admin_cabang') {
        container.style.display = 'block';
        kodeCabangSelect.value = user.kode_cabang || '';
        kodeCabangSelect.disabled = false;
    } else {
        container.style.display = 'none';
        kodeCabangSelect.value = ''; // Kosongkan kalau bukan admin_cabang
        kodeCabangSelect.disabled = true;
    }

    // Tambahkan listener supaya ketika role berubah, tampilan ikut berubah
    const roleSelect = document.getElementById('edit_role');
    roleSelect.addEventListener('change', function () {
        if (this.value === 'admin_cabang') {
        container.style.display = 'block';
        kodeCabangSelect.disabled = false;
        } else {
        container.style.display = 'none';
        kodeCabangSelect.value = '';
        kodeCabangSelect.disabled = true;
        }
    });

    document.getElementById('editUserForm').action = `/users/${user.id}`;

    new bootstrap.Modal(document.getElementById('modalEditUser')).show();
    }

    document.getElementById('edit_submit').addEventListener('click', function (e) {
    const role = document.getElementById('edit_role').value;
    const kodeCabang = document.getElementById('edit_kode_cabang').value;

    if (role === 'admin_cabang' && !kodeCabang) {
      e.preventDefault(); // cegah form submit
      alert('Admin Cabang wajib memilih cabang!');
      return false;
    }
  });

</script>

