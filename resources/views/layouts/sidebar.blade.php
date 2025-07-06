{{-- <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white" id="sidenav-main"> --}}
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white" id="sidenav-main" style="overflow-y: hidden;">
    <div class="sidenav-header text-center py-4"
        style="position: sticky; top: 0; z-index: 10; background-color: white;">
        <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 d-block" href="#">
            <span class="d-block text-sm text-dark fw-bold" style="font-size: 1.5rem;">Raffi</span>
            <span class="d-block text-xs text-muted" style="font-size: 0.95rem;">Collection</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Dashboard</h6>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('/') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="/">
                <i class="material-icons-round opacity-5 me-2">dashboard</i>
                <span class="nav-link-text ms-1">Dashboard</span>
            </a>
        </li>
        <!-- Master Data -->
        <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Master Data</h6>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('cabang*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="/cabang">
                <i class="material-icons-round opacity-5 me-2">store</i>
                <span class="nav-link-text ms-1">Cabang</span>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link text-dark" href="../pages/kategori.html">
                <i class="material-icons-round opacity-5 me-2">category</i>
                <span class="nav-link-text ms-1">Kategori</span>
            </a>
        </li> --}}
        <li class="nav-item">
            <a class="nav-link text-dark" href="../pages/produk.html">
                <i class="material-icons-round opacity-5 me-2">inventory_2</i>
                <span class="nav-link-text ms-1">Produk</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="../pages/ukuran.html">
                <i class="material-icons-round opacity-5 me-2">straighten</i>
                <span class="nav-link-text ms-1">Ukuran Produk</span>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link text-dark" href="../pages/varian.html">
                <i class="material-icons-round opacity-5 me-2">style</i>
                <span class="nav-link-text ms-1">Produk Varian</span>
            </a>
        </li> --}}

        <!-- Operasional -->
        <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Operasional</h6>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="../pages/stok.html">
                <i class="material-icons-round opacity-5 me-2">inventory</i>
                <span class="nav-link-text ms-1">Stok</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="../pages/stok.html">
                <i class="material-icons-round opacity-5 me-2">style</i>
                <span class="nav-link-text ms-1">Pengurangan Stok</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="../pages/penjualan.html">
                <i class="material-icons-round opacity-5 me-2">point_of_sale</i>
                <span class="nav-link-text ms-1">Penjualan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="../pages/pengeluaran.html">
                <i class="material-icons-round opacity-5 me-2">money_off</i>
                <span class="nav-link-text ms-1">Pengeluaran</span>
            </a>
        </li>

        <!-- Kepegawaian & Akses -->
        <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Kepegawaian & Akses</h6>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="../pages/karyawan.html">
                <i class="material-icons-round opacity-5 me-2">badge</i>
                <span class="nav-link-text ms-1">Karyawan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="../pages/gaji.html">
                <i class="material-icons-round opacity-5 me-2">payments</i>
                <span class="nav-link-text ms-1">Gaji</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('users*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="/users">
                <i class="material-icons-round opacity-5 me-2">manage_accounts</i>
                <span class="nav-link-text ms-1">User</span>
            </a>
        </li>

      </ul>
    </div>
  </aside>
