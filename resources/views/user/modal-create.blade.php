<!-- Tambahkan style untuk pesan error -->
<style>
  .text-error {
    font-size: 0.85rem;
    color: red;
    margin-top: 2px;
  }
</style>

<!-- Modal Create User -->
<div class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="modalCreateUserLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-2 shadow-sm border-0 rounded-3">
      <form action="{{ route('user.store') }}" method="POST" id="formCreateUser">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalCreateUserLabel">Tambah User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="create_nama" class="form-label" style="color: black; font-weight: semibold;">Nama Lengkap</label>
              <input type="text" name="nama" id="create_nama" class="form-control" placeholder="Masukkan Nama Lengkap" required>
            </div>

            <div class="col-md-6">
              <label for="create_email" class="form-label" style="color: black; font-weight: semibold;">Email</label>
              <input type="email" name="email" id="create_email" class="form-control" placeholder="Masukkan Email" required>
              <div id="emailError" class="text-error" style="display:none;">Email sudah digunakan</div>
            </div>

            <div class="col-md-6">
              <label for="create_password" class="form-label" style="color: black; font-weight: semibold;">Password</label>
              <div class="input-group">
                <input type="password" name="password" id="create_password" class="form-control" placeholder="Masukkan Password" required>
                <button type="button" class="btn btn-outline-secondary" id="toggleCreatePassword">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
            </div>

            <div class="col-md-6">
              <label for="create_password_confirmation" class="form-label" style="color: black; font-weight: semibold;">Konfirmasi Password</label>
              <div class="input-group">
                <input type="password" name="password_confirmation" id="create_password_confirmation" class="form-control" placeholder="Masukkan Konfirmasi Password" required>
                <button type="button" class="btn btn-outline-secondary" id="toggleCreatePasswordConfirm">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
              <div id="passwordError" class="text-error" style="display:none;">Password tidak sesuai</div>
            </div>

            <div class="col-md-6">
              <label for="create_role" class="form-label" style="color: black; font-weight: semibold;">Role</label>
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
          <button type="submit" class="btn btn-primary" id="btnSubmit">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Script -->
<script>
  // Tampilkan cabang hanya jika role admin_cabang
  document.getElementById('create_role').addEventListener('change', function () {
    document.getElementById('create_kodeCabangContainer').style.display =
      this.value === 'admin_cabang' ? 'block' : 'none';
  });

  // Toggle password visibility
  function togglePassword(inputId, iconId) {
    const pwdField = document.getElementById(inputId);
    const icon = document.querySelector(`#${iconId} i`);
    if (pwdField.type === 'password') {
      pwdField.type = 'text';
      icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
      pwdField.type = 'password';
      icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
  }
  document.getElementById('toggleCreatePassword').addEventListener('click', function () {
    togglePassword('create_password', 'toggleCreatePassword');
  });
  document.getElementById('toggleCreatePasswordConfirm').addEventListener('click', function () {
    togglePassword('create_password_confirmation', 'toggleCreatePasswordConfirm');
  });

  // Cek konfirmasi password
  const password = document.getElementById('create_password');
  const passwordConfirm = document.getElementById('create_password_confirmation');
  const passwordError = document.getElementById('passwordError');

  function checkPasswordMatch() {
    if (passwordConfirm.value && passwordConfirm.value !== password.value) {
      passwordError.style.display = 'block';
    } else {
      passwordError.style.display = 'none';
    }
  }
  password.addEventListener('input', checkPasswordMatch);
  passwordConfirm.addEventListener('input', checkPasswordMatch);

  // Cek email duplikat via AJAX
  const emailField = document.getElementById('create_email');
  const emailError = document.getElementById('emailError');

  emailField.addEventListener('blur', function () {
    const email = emailField.value;
    if (!email) return;

    fetch(`/check-email?email=${encodeURIComponent(email)}`)
      .then(res => res.json())
      .then(data => {
        if (data.exists) {
          emailError.style.display = 'block';
        } else {
          emailError.style.display = 'none';
        }
      })
      .catch(err => console.error(err));
  });

  // Cegah submit kalau ada error
  document.getElementById('formCreateUser').addEventListener('submit', function (e) {
    if (emailError.style.display === 'block' || passwordError.style.display === 'block') {
      e.preventDefault();
    }
  });
</script>

