<nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow border-radius-xl bg-gradient-dark sticky-top " id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3">

    <div class="d-flex flex-column">
        <p class="text-white fw-bold mb-1" style="font-size: 1rem;">
            Cabang: {{ auth()->user()->cabang->nama_cabang ?? '-' }}
        </p>

        <nav aria-label="breadcrumb">
            @php
                $titles = [
                    'dashboard' => 'Dashboard',
                    'cabang.index' => 'Cabang',
                    'produk.index' => 'Produk',
                    'produk.detail' => 'Detail Produk',
                    'ukuran-produk.index' => 'Ukuran Produk',
                    'detail-produk.index' => 'Detail Produk',
                    'produksi.index' => 'Produksi',
                    'pengeluaran.index' => 'Pengeluaran',
                    'kategori-pengeluaran.index' => 'Kategori Pengeluaran',
                    'karyawan.index' => 'Karyawan',
                    'user.index' => 'User',
                ];

                $currentRoute = Route::currentRouteName();
                $parts = explode('.', $currentRoute);
            @endphp

            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-3 me-2">
                @if(count($parts) > 1 && $currentRoute !== $parts[0] . '.index')
                    {{-- Breadcrumb utama --}}
                    <li class="breadcrumb-item text-sm text-white">
                        {{ $titles[$parts[0] . '.index'] ?? ucfirst(str_replace('-', ' ', $parts[0])) }}
                    </li>
                    {{-- Breadcrumb sub --}}
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">
                        {{ $titles[$currentRoute] ?? ucfirst(str_replace('-', ' ', end($parts))) }}
                    </li>
                @else
                    {{-- Breadcrumb tunggal --}}
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">
                        {{ $titles[$currentRoute] ?? ucfirst(str_replace('-', ' ', $currentRoute)) }}
                    </li>
                @endif
            </ol>
        </nav>
    </div>

    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
        <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <ul class="navbar-nav d-flex align-items-center justify-content-end flex-row gap-3">

                @if(auth()->user()->role == 'super_admin')
                <li class="nav-item">
                    <a href="{{ route('pilih-cabang') }}" class="btn btn-sm btn-light fw-bold">
                        Pilih Cabang
                    </a>
                </li>
                @endif

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="me-1 fw-bold">{{ auth()->user()->nama }}</span>
                        <i class="material-symbols-rounded me-1" style="font-size: 1.6rem;">account_circle</i>
                        <i class="material-symbols-rounded" style="font-size: 1.2rem;">expand_more</i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">Profil</a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


