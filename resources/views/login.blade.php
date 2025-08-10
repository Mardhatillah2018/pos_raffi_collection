<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - POS Raffi Collection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    body {
        background: linear-gradient(to bottom, #1c1c1c, #555555);
        min-height: 100vh;
    }
    .card {
        border-radius: 1rem;
    }
    .btn-theme {
        background-color: #1c1c1c; /* hitam abu */
        color: #fff;
    }
    .btn-theme:hover {
        background-color: #1c1c1c;
        opacity: 0.9;
        color: #fff;
    }
    .icon-theme {
        color: #1c1c1c; /* warna icon */
    }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
            <div class="text-center mb-4">
                <i class="bi bi-person-fill icon-theme" style="font-size: 48px;"></i>
                <div style="font-weight: bold; font-size: 16px; color: #1c1c1c;">LOGIN</div>
                <div class="d-flex justify-content-center mt-2">
                    <div style="width: 60px; height: 3px; background-color: #1c1c1c; border-radius: 2px;"></div>
                </div>
            </div>

            <form action="/" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" required>
                        <span class="input-group-text bg-white" style="cursor: pointer;" onclick="togglePassword()">
                            <i id="togglePasswordIcon" class="bi bi-eye-slash icon-theme"></i>
                        </span>
                    </div>
                </div>
                <button type="submit" class="btn btn-theme w-100">Masuk</button>
            </form>

            @if ($errors->any())
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Maaf',
                        text: '{{ $errors->first() }}',
                        confirmButtonColor: '#1c1c1c'
                    });
                </script>
            @endif

            <p class="text-center text-muted mt-4 small">&copy; {{ date('Y') }} Raffi Collection</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('togglePasswordIcon');

        const isHidden = passwordInput.type === 'password';
        passwordInput.type = isHidden ? 'text' : 'password';

        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    }
    </script>
</body>
</html>
