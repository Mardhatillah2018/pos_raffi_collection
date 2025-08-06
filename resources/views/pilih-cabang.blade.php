<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pilih Cabang</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #e3e3e3;
            min-height: 100vh;
            color: #1c1c1c;
        }

        .card-hover {
            background-color: #ffffff;
            color: #1c1c1c;
            border: 2px solid #1c1c1c;
            border-radius: 12px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: scale(1.05);
            box-shadow: 0 1rem 2rem rgba(13, 59, 102, 0.25);
            background-color: #1c1c1c;
            color: #ffffff;
        }

        .card-hover:hover small,
        .card-hover:hover h5 {
            color: #ffffff;
        }

        .card-hover:hover .icon-circle {
            background-color: #ffffff;
        }

        .card-hover:hover .icon-circle svg {
            fill: #1c1c1c;
        }


        .icon-circle {
            background-color: #eaf2f8;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .icon-circle svg {
            fill: #1c1c1c;
        }

        .logout-btn {
            position: absolute;
            top: 20px;
            right: 30px;
        }

        .card-hover small,
        .card-hover h5 {
            color: #1c1c1c;
        }

        .text-light-muted {
            color: #373737;
        }

        .btn-outline-navy {
            color: #1c1c1c;
            border: 2px solid #1c1c1c;
            background-color: transparent;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-outline-navy:hover {
            background-color: #1c1c1c;
            color: #ffffff;
        }

    </style>
</head>
<body>

    <!-- Tombol Logout -->
    <div class="logout-btn">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-navy">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
        </form>
    </div>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Silakan Pilih Cabang</h2>
            <p class="text-light-muted">Klik salah satu cabang untuk melanjutkan</p>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach(\App\Models\Cabang::all() as $cabang)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <form action="{{ route('simpan-cabang') }}" method="POST" onsubmit="return submitCabang(this);">
                        @csrf
                        <input type="hidden" name="kode_cabang" value="{{ $cabang->kode_cabang }}">

                        <button type="submit" class="card card-hover text-center w-100 p-4">
                            <div class="mb-3">
                                <div class="icon-circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 16 16">
                                        <path d="M2.97 1a1 1 0 0 0-.98.804L1 5v1a2 2 0 0 0 1 1.732V14a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-3h4v3a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V7.732A2 2 0 0 0 15 6V5l-.99-3.196A1 1 0 0 0 13.03 1H2.97zM2.02 2h11.96l.833 2.67a1 1 0 0 1-.893 1.326H2.08a1 1 0 0 1-.894-1.326L2.02 2zM13 14h-1v-3a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v3H3V8.466c.313.219.673.37 1.08.419C5.022 9 5.732 9 6.286 9c.555 0 1.264 0 2.206-.115a3.418 3.418 0 0 0 1.152-.391c.244-.14.47-.308.676-.502V14z"/>
                                    </svg>
                                </div>
                            </div>
                            <small class="text-uppercase">Cabang {{ $cabang->kode_cabang }}</small>
                            <h5 class="mt-1">{{ $cabang->nama_cabang }}</h5>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function submitCabang(form) {
            form.submit();
            return false;
        }
    </script>

</body>
</html>
