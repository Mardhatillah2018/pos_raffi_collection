@extends('layouts.main')

@section('content')

<div class="container-fluid py-2">
    <div class="row">
        <h3 class="mb-1 h4 font-weight-bolder">Dashboard</h3>
        <p class="mb-2">
            Pantau performa toko secara real-time untuk mendukung pengambilan keputusan.
        </p>
        {{-- card baris pertama --}}
        <div class="row">
            @php
                use Illuminate\Support\Facades\Auth;
                $role = Auth::user()->role;
                $hari = \Carbon\Carbon::now()->translatedFormat('l');
                $tanggal = \Carbon\Carbon::now()->format('d-m-Y');
                $jam = \Carbon\Carbon::now()->format('H:i');
            @endphp

            @if ($role === 'super_admin')
                {{-- Card 1: Penjualan Hari Ini --}}
                <div class="col-xl-3 col-sm-6">
                    <a href="{{ url('/penjualan') }}" class="text-decoration-none text-dark">
                        <div class="card card-hover">
                            <div class="card-header p-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-sm text-capitalize mb-0">Penjualan Hari Ini</p>
                                    <h4 class="mb-0">Rp{{ number_format($penjualanHariIni, 0, ',', '.') }}</h4>
                                </div>
                                @php
                                    $iconPenjualan = $persenPenjualan >= 0 ? 'trending_up' : 'trending_down';
                                @endphp
                                <div class="icon icon-md icon-shape bg-gradient-dark shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">{{ $iconPenjualan }}</i>
                                </div>
                            </div>
                            <hr class="horizontal dark my-0">
                            <div class="card-footer p-3">
                                @if ($persenPenjualan !== null)
                                    <p class="mb-0 text-sm d-flex align-items-center">
                                        <span class="{{ $persenPenjualan >= 0 ? 'text-success' : 'text-danger' }} font-weight-bold d-flex align-items-center">
                                            <i class="material-icons-round me-1">
                                                {{ $persenPenjualan >= 0 ? 'arrow_upward' : 'arrow_downward' }}
                                            </i>
                                            {{ round($persenPenjualan, 2) }}%
                                        </span>
                                        <span class="ms-2 text-muted">dari kemarin</span>
                                    </p>
                                @else
                                    <p class="mb-0 text-sm text-muted">Tidak ada data kemarin</p>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Card 2: Jumlah Produk --}}
                <div class="col-xl-3 col-sm-6">
                    <a href="{{ url('/produk') }}" class="text-decoration-none text-dark">
                        <div class="card card-hover">
                            <div class="card-header p-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-sm text-capitalize mb-0">Jumlah Produk</p>
                                    <h4 class="mb-0">{{ $totalProduk }}</h4>
                                </div>
                                <div class="icon icon-md icon-shape bg-gradient-dark shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">inventory_2</i>
                                </div>
                            </div>
                            <hr class="horizontal dark my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0 text-sm d-flex align-items-center">
                                    <span class="text-success font-weight-bold me-1">{{ $jumlahProdukAktif }}</span>
                                    <span>produk aktif</span>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>


                {{-- Card 3: Total Stok --}}
                <div class="col-xl-3 col-sm-6">
                    <a href="{{ url('/stok') }}" class="text-decoration-none text-dark">
                        <div class="card card-hover">
                            <div class="card-header p-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-sm text-capitalize mb-0">Total Stok</p>
                                    <h4 class="mb-0">{{ $totalStok }}</h4>
                                </div>
                                <div class="icon icon-md icon-shape bg-gradient-dark shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">inventory</i>
                                </div>
                            </div>
                            <hr class="horizontal dark my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0 text-sm d-flex align-items-center">
                                    <span class="text-danger font-weight-bold me-1">{{ $produkStokKosong }}</span>
                                    <span>produk stok kosong</span>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Card 4: Pengeluaran Hari Ini --}}
                <div class="col-xl-3 col-sm-6">
                    <a href="{{ url('/pengeluaran') }}" class="text-decoration-none text-dark">
                        <div class="card card-hover">
                            <div class="card-header p-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-sm text-capitalize mb-0">Pengeluaran Hari Ini</p>
                                    <h4 class="mb-0">Rp{{ number_format($pengeluaranHariIni, 0, ',', '.') }}</h4>
                                </div>
                                <div class="icon icon-md icon-shape bg-gradient-dark shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">payments</i>
                                </div>
                            </div>
                            <hr class="horizontal dark my-0">
                            <div class="card-footer p-3">
                                @if (!is_null($persenPengeluaran))
                                    @php
                                        $ikon = $persenPengeluaran >= 0 ? 'arrow_upward' : 'arrow_downward';
                                        $warna = $persenPengeluaran >= 0 ? 'text-danger' : 'text-success';
                                    @endphp
                                    <p class="mb-0 text-sm d-flex align-items-center">
                                        <span class="{{ $warna }} font-weight-bold d-flex align-items-center">
                                            <i class="material-icons-round me-1">{{ $ikon }}</i>
                                            {{ round(abs($persenPengeluaran), 2) }}%
                                        </span>
                                        <span class="ms-2 text-muted">dari kemarin</span>
                                    </p>
                                @else
                                    <p class="mb-0 text-sm text-muted">Tidak ada data kemarin</p>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @else
                {{-- Card 1: Hari, Tanggal, Jam, Button --}}
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h3 class="fw-bold mb-1">
                                    <i class="bi bi-clock me-2"></i>
                                    <span id="clock">{{ \Carbon\Carbon::now()->format('H:i:s') }}</span>
                                </h3>
                                <p class="mb-0 text-muted">
                                    <i class="bi bi-calendar-week me-1"></i>
                                    {{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}
                                </p>
                            </div>
                            <a href="{{ route('penjualan.create') }}" class="btn btn-primary mt-3 mt-sm-0">
                                <i class="bi bi-plus-lg me-1"></i> Tambah Penjualan
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Penjualan Hari Ini --}}
                <div class="col-md-3 mb-4">
                    <a href="{{ url('/penjualan') }}" class="text-decoration-none text-dark">
                        <div class="card h-100 card-hover">
                            <div class="card-header p-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-sm text-capitalize mb-0">Penjualan Hari Ini</p>
                                    <h4 class="mb-0">Rp{{ number_format($penjualanHariIni, 0, ',', '.') }}</h4>
                                </div>
                                @php
                                    $iconPenjualan = $persenPenjualan >= 0 ? 'trending_up' : 'trending_down';
                                @endphp
                                <div class="icon icon-md icon-shape bg-gradient-dark shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">{{ $iconPenjualan }}</i>
                                </div>
                            </div>
                            <hr class="horizontal dark my-0">
                            <div class="card-footer p-3">
                                @if ($persenPenjualan !== null)
                                    <p class="mb-0 text-sm d-flex align-items-center">
                                        <span class="{{ $persenPenjualan >= 0 ? 'text-success' : 'text-danger' }} font-weight-bold d-flex align-items-center">
                                            <i class="material-icons-round me-1">
                                                {{ $persenPenjualan >= 0 ? 'arrow_upward' : 'arrow_downward' }}
                                            </i>
                                            {{ round($persenPenjualan, 2) }}%
                                        </span>
                                        <span class="ms-2 text-muted">dari kemarin</span>
                                    </p>
                                @else
                                    <p class="mb-0 text-sm text-muted">Tidak ada data kemarin</p>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>


                {{-- Card 3: Total Stok --}}
                <div class="col-md-3 mb-4">
                    <a href="{{ url('/stok') }}" class="text-decoration-none text-dark">
                        <div class="card h-100 card-hover">
                            <div class="card-header p-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-sm text-capitalize mb-0">Total Stok</p>
                                    <h4 class="mb-0">{{ $totalStok }}</h4>
                                </div>
                                <div class="icon icon-md icon-shape bg-gradient-dark shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">inventory</i>
                                </div>
                            </div>
                            <hr class="horizontal dark my-0">
                            <div class="card-footer p-3">
                                <p class="mb-0 text-sm d-flex align-items-center">
                                    <span class="text-danger font-weight-bold me-1">{{ $produkStokKosong }}</span>
                                    <span>produk stok kosong</span>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <style>
        .card-hover {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            background-color: #f8f9fa; /* efek background ringan saat hover */
        }
    </style>

    {{-- card baris kedua --}}
    <div class="row">
        <!-- Grafik Penjualan 7 Hari Terakhir -->
        <div class="col-lg-6 col-md-6 mt-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-0">Penjualan 7 Hari Terakhir</h6>
                    <p class="text-sm">Performa penjualan harian dalam seminggu terakhir.</p>
                    <div class="pe-2">
                        <div class="chart">
                            <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                        </div>
                    </div>
                    <hr class="dark horizontal">
                    <div class="d-flex">
                        <i class="material-symbols-rounded text-sm my-auto me-1">calendar_today</i>
                        <p class="mb-0 text-sm"> Diperbarui hari ini </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Pengeluaran 7 Hari Terakhir -->
        <div class="col-lg-6 col-md-6 mt-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-0">Pengeluaran 7 Hari Terakhir</h6>
                    <p class="text-sm">Ringkasan biaya operasional selama seminggu.</p>
                    <div class="pe-2">
                        <div class="chart">
                            <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
                        </div>
                    </div>
                    <hr class="dark horizontal">
                    <div class="d-flex">
                        <i class="material-symbols-rounded text-sm my-auto me-1">calendar_today</i>
                        <p class="mb-0 text-sm"> Diperbarui hari ini </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        {{-- tabel penjualan --}}
        <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-lg-6 col-7">
                            <h6>5 Penjualan Terakhir</h6>
                                <p class="text-sm mb-0">
                                <i class="fa fa-clock text-info" aria-hidden="true"></i>
                                <span class="font-weight-bold ms-1">Update terbaru</span> penjualan
                                </p>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-items-center mb-0">
                            <thead class="bg-gradient-dark ">
                                <tr>
                                    <th class="text-uppercase text-xs font-weight-bolder opacity-9 text-white">No Faktur</th>
                                    <th class="text-center text-uppercase text-xs font-weight-bolder opacity-9 text-white">Total Qty</th>
                                    <th class="text-center text-uppercase text-xs font-weight-bolder opacity-9 text-white">Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($penjualanTerakhir as $p)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm text-dark">{{ $p['no_faktur'] }}</h6>
                                                    <p class="text-xs text-secondary mb-0">
                                                        {{ \Carbon\Carbon::parse($p['created_at'])->translatedFormat('d M Y H:i') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge bg-gradient-info text-white">{{ $p['qty_total'] }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge bg-success text-white d-inline-flex align-items-center gap-1 px-2 py-1">
                                            <span class="material-symbols-rounded" style="font-size: 16px;">arrow_upward</span>
                                                Rp {{ number_format($p['total_harga'], 0, ',', '.') }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-sm text-muted py-3">
                                            Tidak ada penjualan terakhir.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6>Aktivitas Stok Barang</h6>
                    <p class="text-sm">
                        <i class="fa fa-clock text-primary" aria-hidden="true"></i>
                        <span class="font-weight-bold">Terbaru</span> hari ini
                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="timeline timeline-one-side">
                        @forelse($logStoks as $log)
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                @if($log->jenis === 'masuk')
                                <i class="material-symbols-rounded text-success text-gradient">arrow_downward</i>
                                @else
                                <i class="material-symbols-rounded text-danger text-gradient">arrow_upward</i>
                                @endif
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">
                                {{ $log->jenis === 'masuk' ? '+' : '-' }}{{ $log->qty }} pcs -
                                {{ $log->detailProduk->produk->nama_produk }}
                                {{ $log->detailProduk->ukuran->nama_ukuran ?? '' }}
                                </h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                {{ strtoupper($log->sumber) }} - {{ \Carbon\Carbon::parse($log->tanggal)->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                        @empty
                        <p class="text-sm text-muted">Belum ada aktivitas stok.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer py-4  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                &copy; <script>
                  document.write(new Date().getFullYear())
                </script>
                Raffi Collection
              </div>
            </div>
          </div>
        </div>
    </footer>
</div>
@endsection

@push('scripts')
<script>
    function updateClock() {
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
    }
    setInterval(updateClock, 1000);

    // Penjualan 7 hari terakhir
    const penjualan7Hari = @json($penjualan7Hari);
    var ctx = document.getElementById("chart-bars").getContext("2d");
    new Chart(ctx, {
    type: "bar",
    data: {
        labels: penjualan7Hari.map(p => {
            const tgl = new Date(p.tanggal);
            return tgl.getDate().toString().padStart(2, '0') + ' ' + tgl.toLocaleString('default', { month: 'short' });
            }),
        datasets: [{
        label: "Penjualan",
        tension: 0.4,
        borderWidth: 0,
        borderRadius: 4,
        borderSkipped: false,
        backgroundColor: "#43A047",
        data: penjualan7Hari.map(p => p.total),
        barThickness: 'flex'
        }],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
        legend: { display: false }
        },
        interaction: {
        intersect: false,
        mode: 'index',
        },
        scales: {
        y: {
            grid: {
            drawBorder: false,
            color: '#e5e5e5',
            drawTicks: false,
            borderDash: [5, 5],
            },
            ticks: {
            beginAtZero: true,
            padding: 10,
            color: "#737373",
            font: { size: 14, lineHeight: 2 }
            }
        },
        x: {
            grid: { display: false },
            ticks: {
            color: '#737373',
            padding: 10,
            font: { size: 14, lineHeight: 2 },
            maxRotation: 0,
            minRotation: 0
            }
        }
        }
    }
    });

    // pengeluaran 7 hari terakhir
    const pengeluaran7Hari = @json($pengeluaran7Hari);
    var ctx2 = document.getElementById("chart-line").getContext("2d");
    new Chart(ctx2, {
    type: "line",
    data: {
        labels: pengeluaran7Hari.map(p => {
        const tgl = new Date(p.tanggal);
        return tgl.getDate().toString().padStart(2, '0') + ' ' + tgl.toLocaleString('default', { month: 'short' });
        }),
        datasets: [{
        label: "Pengeluaran",
        tension: 0.4,
        borderWidth: 2,
        pointRadius: 3,
        pointBackgroundColor: "#E53935",
        pointBorderColor: "transparent",
        borderColor: "#E53935",
        backgroundColor: "transparent",
        fill: true,
        data: pengeluaran7Hari.map(p => p.total),
        maxBarThickness: 6
        }],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
        legend: { display: false }
        },
        interaction: {
        intersect: false,
        mode: 'index',
        },
        scales: {
        y: {
            grid: {
            drawBorder: false,
            color: '#e5e5e5',
            drawTicks: false,
            borderDash: [4, 4],
            },
            ticks: {
            color: '#737373',
            padding: 10,
            font: { size: 12, lineHeight: 2 }
            }
        },
        x: {
            grid: { display: false },
            ticks: {
            color: '#737373',
            padding: 10,
            font: { size: 12, lineHeight: 2 },
            maxRotation: 0,
            minRotation: 0
            }
        }
        }
    }
    });

</script>
@endpush
