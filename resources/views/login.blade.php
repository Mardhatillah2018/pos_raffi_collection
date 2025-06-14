<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - POS Raffi Collection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <form action="#" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-theme w-100">Masuk</button>
            </form>
            <p class="text-center text-muted mt-4 small">&copy; {{ date('Y') }} Raffi Collection</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
