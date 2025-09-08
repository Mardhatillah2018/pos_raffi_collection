<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white" id="sidenav-main">
{{-- <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white" id="sidenav-main" style="overflow-y: hidden;"> --}}
    <div class="sidenav-header text-center py-4"
        style="position: sticky; top: 0; z-index: 10; background-color: white;">
        <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 d-block" href="#">
            <span style="display: block; font-size: 1.8rem; font-weight: 700; font-family: 'Playfair Display', serif;">Raffi</span>
            {{-- <span class="d-block text-dark" style="font-size: 2rem; font-weight: 800; font-family: 'Segoe UI', sans-serif;">Raffi</span> --}}
            <span class="d-block text-muted" style="font-size: 0.9rem; letter-spacing: 1px; font-style: italic; font-family: 'Georgia', serif;">Collection</span>
        </a>
    </div>

<style>
    .sidenav-header.scrolled {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-bottom: 1px solid #dee2e6;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }
</style>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidenavHeader = document.querySelector('.sidenav-header');
            window.addEventListener('scroll', function() {
                if (window.scrollY > 0) {
                    sidenavHeader.classList.add('scrolled');
                } else {
                    sidenavHeader.classList.remove('scrolled');
                }
            });
        });
    </script>
@endpush
<style>
    .sub-menu .nav-link::before {
    content: "•";
    margin-right: 8px;
    font-size: 1rem;
    color: #6c757d;
}
</style>

    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item mt-2">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Dashboard</h6>
        </li>
        <li class="nav-item" title="Lihat Dashboard">
            <a class="nav-link {{ Request::is('dashboard*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="/dashboard">
                <i class="material-icons-round opacity-5 me-2">dashboard</i>
                <span class="nav-link-text ms-1">Dashboard</span>
            </a>
        </li>
        @if (Auth::user()->role === 'super_admin')
            <!-- Master Data -->
            <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Master Data</h6>
            </li>
            <li class="nav-item" title="Kelola Cabang">
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
            <li class="nav-item" title="Kelola Produk">
                <a class="nav-link {{ Request::is('produk') || Request::is('produk/*') || Request::is('ukuran-produk*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                data-bs-toggle="collapse"
                href="#produkDropdown"
                aria-expanded="{{ Request::is('produk') || Request::is('produk/*') || Request::is('ukuran-produk*') ? 'true' : 'false' }}"
                aria-controls="produkDropdown">
                    <i class="material-icons-round opacity-5 me-2">inventory_2</i>
                    <span class="nav-link-text ms-1">Produk</span>
                </a>

                <div class="collapse {{ Request::is('produk') || Request::is('produk/*') || Request::is('ukuran-produk*') ? 'show' : '' }}" id="produkDropdown">
                    <ul class="nav flex-column sub-menu ms-4">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('produk') || Request::is('produk/*') ? 'active text-primary fw-bold' : 'text-dark' }}" href="/produk">
                                Kelola Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('ukuran-produk*') ? 'active text-primary fw-bold' : 'text-dark' }}" href="/ukuran-produk">
                                Ukuran Produk
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- <li class="nav-item">
                <a class="nav-link text-dark" href="../pages/varian.html">
                    <i class="material-icons-round opacity-5 me-2">style</i>
                    <span class="nav-link-text ms-1">Produk Varian</span>
                </a>
            </li> --}}
        @endif

        <!-- Operasional -->
        <li class="nav-item mt-2">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Operasional</h6>
        </li>
        @if (Auth::user()->role === 'super_admin')
            <li class="nav-item" title="Kelola Produksi">
                <a class="nav-link {{ Request::is('produksi*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="/produksi">
                    <i class="material-icons-round opacity-5 me-2">content_cut</i>
                    <span class="nav-link-text ms-1">Produksi</span>
                </a>
            </li>
            <li class="nav-item" title="Kelola Pembelian">
                <a class="nav-link {{ Request::is('pembelian*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="/pembelian">
                    <i class="material-icons-round opacity-5 me-2">shopping_bag</i>
                    <span class="nav-link-text ms-1">Pembelian</span>
                </a>
            </li>
        @endif
        <li class="nav-item" title="Kelola Stok">
            <a class="nav-link {{ Request::is('stok*') || Request::is('pengurangan-stok*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
            data-bs-toggle="collapse"
            href="#stokDropdown"
            aria-expanded="{{ Request::is('stok*') || Request::is('pengurangan-stok*') ? 'true' : 'false' }}"
            aria-controls="stokDropdown">
                <i class="material-icons-round opacity-5 me-2">inventory</i>
                <span class="nav-link-text ms-1">Stok</span>

            </a>

            <div class="collapse {{ Request::is('stok*') || Request::is('pengurangan-stok*') ? 'show' : '' }}" id="stokDropdown">
                <ul class="nav flex-column sub-menu ms-4">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('stok*') ? 'active text-primary fw-bold' : 'text-dark' }}" href="/stok">
                            Lihat Stok
                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link {{ Request::is('pengurangan-stok*') ? 'active text-primary fw-bold' : 'text-dark' }}" href="/pengurangan-stok">
                            Pengurangan Stok
                            @if ($jumlahPendingPengurangan > 0)
                                <span class="badge rounded-pill bg-danger ms-2" style="font-size: 0.75rem;">
                                    {{ $jumlahPendingPengurangan }}
                                </span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item" title="Lihat Penjualan">
            <a class="nav-link {{ Request::is('penjualan*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="/penjualan">
                <i class="material-icons-round opacity-5 me-2">point_of_sale</i>
                <span class="nav-link-text ms-1">Penjualan</span>
            </a>
        </li>
        <li class="nav-item" title="Kelola Pengeluaran">
            <a class="nav-link
                {{ Request::is('pengeluaran') || Request::is('pengeluaran/*') || Request::is('pengajuan-pengeluaran')
                    ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                data-bs-toggle="collapse"
                href="#pengeluaranDropdown"
                aria-expanded="{{ Request::is('pengeluaran') || Request::is('pengeluaran/*') || Request::is('pengajuan-pengeluaran') ? 'true' : 'false' }}"
                aria-controls="pengeluaranDropdown">
                <i class="material-icons-round opacity-5 me-2">receipt_long</i>
                <span class="nav-link-text ms-1">Pengeluaran</span>
            </a>

            <div class="collapse {{ Request::is('pengeluaran') || Request::is('pengeluaran/*') || Request::is('pengajuan-pengeluaran') ? 'show' : '' }}" id="pengeluaranDropdown">
                <ul class="nav flex-column sub-menu ms-4">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('pengeluaran') || Request::is('pengeluaran/*') ? 'active text-primary fw-bold' : 'text-dark' }}"
                            href="{{ url('/pengeluaran') }}">
                            Daftar Pengeluaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('pengajuan-pengeluaran') ? 'active text-primary fw-bold' : 'text-dark' }}"
                            href="{{ route('pengeluaran.pengajuan') }}">
                            Pengajuan
                            @if ($jumlahPendingPengeluaran > 0)
                                <span class="badge rounded-pill bg-danger ms-2" style="font-size: 0.75rem;">
                                    {{ $jumlahPendingPengeluaran }}
                                </span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        @if (Auth::user()->role === 'super_admin')
            {{-- <li class="nav-item" title="Lihat Keuntungan">
                <a class="nav-link {{ Request::is('keuntungan*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="/keuntungan">
                    <i class="material-icons-round opacity-5 me-2">trending_up</i>
                    <span class="nav-link-text ms-1">Keuntungan</span>
                </a>
            </li> --}}

            <li class="nav-item" title="Laporan">
                <a class="nav-link {{ Request::is('laba-rugi*') || Request::is('mutasi-stok*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                data-bs-toggle="collapse"
                href="#laporanDropdown"
                aria-expanded="{{ Request::is('laba-rugi*') || Request::is('mutasi-stok*') ? 'true' : 'false' }}"
                aria-controls="laporanDropdown">
                    <i class="material-icons-round opacity-5 me-2">assessment</i>
                    <span class="nav-link-text ms-1"> Cetak Laporan</span>
                </a>

                <div class="collapse {{ Request::is('laba-rugi*') || Request::is('mutasi-stok*') ? 'show' : '' }}" id="laporanDropdown">
                    <ul class="nav flex-column sub-menu ms-4">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('mutasi-stok*') ? 'active text-primary fw-bold' : 'text-dark' }}" href="/mutasi-stok">
                                Mutasi Stok
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('laba-rugi*') ? 'active text-primary fw-bold' : 'text-dark' }}" href="/laba-rugi">
                                Laba Rugi
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- <li class="nav-item" title="Lihat Laporan Buku Besar">
                <a class="nav-link {{ Request::is('buku-besar*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="/buku-besar">
                    <i class="material-icons-round opacity-5 me-2">assessment</i>
                    <span class="nav-link-text ms-1">Laporan Buku Besar</span>
                </a>
            </li> --}}
        @endif

        <li class="nav-item" title="Lihat Kas Harian">
            <a class="nav-link {{ Request::is('kas-harian*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="/kas-harian">
                <i class="material-icons-round opacity-5 me-2">attach_money</i>

                <span class="nav-link-text ms-1">Kas Harian</span>
            </a>
        </li>

        @if (Auth::user()->role === 'super_admin')
        <!-- Kepegawaian & Akses -->
            <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Kepegawaian & Akses</h6>
            </li>
            <li class="nav-item" title="Kelola Karyawan">
                <a class="nav-link {{ Request::is('karyawan*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="/karyawan">
                    <i class="material-icons-round opacity-5 me-2">badge</i>
                    <span class="nav-link-text ms-1">Karyawan</span>
                </a>
            </li>
            <li class="nav-item" title="Kelola Gaji">
                <a class="nav-link {{ Request::is('gaji*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="/gaji">
                    <i class="material-icons-round opacity-5 me-2">payments</i>
                    <span class="nav-link-text ms-1">Gaji</span>
                </a>
            </li>
            <li class="nav-item" title="Kelola User">
                <a class="nav-link {{ Request::is('users*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="/users">
                    <i class="material-icons-round opacity-5 me-2">manage_accounts</i>
                    <span class="nav-link-text ms-1">User</span>
                </a>
            </li>
        @endif
      </ul>
    </div>
  </aside>
