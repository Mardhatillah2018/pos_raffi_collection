<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - POS Raffi Collection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    body {
        background: linear-gradient(to bottom, #2f2f36, #818187);
        min-height: 100vh;
    }
    .card {
        border-radius: 1rem;
    }
    .btn-theme {
        background-color: #38383F;
        color: #fff;
    }
    .btn-theme:hover {
        background-color: #2e2e34;
        color: #fff;
    }
</style>

</head>
<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
            <h2 class="text-center mb-4" style="color: #38383F;">Login</h2>
            <form action="/login" method="POST">
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
                            <i id="togglePasswordIcon" class="bi bi-eye-slash"></i>
                        </span>
                    </div>
                </div>
                <button type="submit" class="btn btn-theme w-100">Masuk</button>
            </form>
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
