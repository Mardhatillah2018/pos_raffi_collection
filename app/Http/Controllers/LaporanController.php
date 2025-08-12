<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\LogStok;
use App\Models\Pengeluaran;
use App\Models\Penjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function indexLabaRugi()
    {
        $user = Auth::user();
        $kodeCabang = $user->kode_cabang;

        // Ambil data penjualan & pengeluaran sesuai cabang user yang login
        $penjualans = Penjualan::with(['detailPenjualans.detailProduk'])
            ->where('kode_cabang', $kodeCabang)
            ->orderBy('tanggal_penjualan', 'desc')
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->tanggal_penjualan)->format('Y-m');
            });

        $pengeluarans = Pengeluaran::with('kategori')
            ->where('kode_cabang', $kodeCabang)
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->tanggal)->format('Y-m');
            });

        $rekap = [];

        foreach ($penjualans as $bulan => $listPenjualan) {
            $totalPenjualan = 0;
            $totalModal = 0;
            $totalQty = 0;

            foreach ($listPenjualan as $penjualan) {
                foreach ($penjualan->detailPenjualans as $detail) {
                    $hargaModal = $detail->detailProduk->harga_modal ?? 0;
                    $qty = $detail->qty;

                    $totalQty += $qty;
                    $totalPenjualan += $detail->subtotal;
                    $totalModal += ($hargaModal * $qty);
                }
            }

            $labaKotor = $totalPenjualan - $totalModal;

            $pengeluaranBulanItu = $pengeluarans[$bulan] ?? collect();
            $totalPengeluaran = $pengeluaranBulanItu->filter(function ($p) {
                return !$p->kategori->is_modal_produk;
            })->sum('total_pengeluaran');

            $labaBersih = $labaKotor - $totalPengeluaran;

            $rekap[] = [
                'bulan' => Carbon::createFromFormat('Y-m', $bulan)->isoFormat('MMMM Y'),
                'raw_bulan' => $bulan,
                'total_produk' => $totalQty,
                'total_penjualan' => $totalPenjualan,
                'laba_kotor' => $labaKotor,
                'pengeluaran' => $totalPengeluaran,
                'laba_bersih' => $labaBersih,
            ];
        }

        return view('laporan.laba-rugi.index', compact('rekap'));
    }

    public function showLabaRugi($bulan, Request $request)
    {
        $user = Auth::user();
        $kodeCabang = $user->role == 'superadmin' && $request->has('cabang')
            ? $request->get('cabang')
            : $user->kode_cabang;

        // Penjualan
        $penjualans = Penjualan::with(['detailPenjualans.detailProduk'])
            ->where('kode_cabang', $kodeCabang)
            ->whereYear('tanggal_penjualan', substr($bulan, 0, 4))
            ->whereMonth('tanggal_penjualan', substr($bulan, 5, 2))
            ->get()
            ->groupBy('tanggal_penjualan');

        // Pengeluaran
        $pengeluarans = Pengeluaran::with('kategori')
            ->where('kode_cabang', $kodeCabang)
            ->whereYear('tanggal', substr($bulan, 0, 4))
            ->whereMonth('tanggal', substr($bulan, 5, 2))
            ->get()
            ->groupBy('tanggal');

        $rekapPerHari = [];

        foreach ($penjualans as $tanggal => $penjualanList) {
            $totalPenjualan = 0;
            $totalModal = 0;
            $totalQty = 0;

            foreach ($penjualanList as $penjualan) {
                foreach ($penjualan->detailPenjualans as $detail) {
                    $qty = $detail->qty;
                    $hargaModal = $detail->detailProduk->harga_modal ?? 0;

                    $totalQty += $qty;
                    $totalPenjualan += $detail->subtotal;
                    $totalModal += $hargaModal * $qty;
                }
            }

            $labaKotor = $totalPenjualan - $totalModal;

            $pengeluaranHariItu = $pengeluarans[$tanggal] ?? collect();
            $totalPengeluaran = $pengeluaranHariItu->filter(function ($p) {
                return !$p->kategori->is_modal_produk;
            })->sum('total_pengeluaran');

            $labaBersih = $labaKotor - $totalPengeluaran;

            $rekapPerHari[] = [
                'tanggal' => Carbon::parse($tanggal)->translatedFormat('d F Y'),
                'total_produk' => $totalQty,
                'total_penjualan' => $totalPenjualan,
                'laba_kotor' => $labaKotor,
                'pengeluaran' => $totalPengeluaran,
                'laba_bersih' => $labaBersih,
            ];
        }

        $namaBulan = Carbon::createFromFormat('Y-m', $bulan)->translatedFormat('F Y');

        return view('laporan.laba-rugi.detail-perhari', compact('rekapPerHari', 'namaBulan'));
    }

    public function cetakLabaRugi(Request $request)
    {
        $user = Auth::user();
        $kodeCabang = $user->kode_cabang;

        // Tangkap input filter tanggal atau bulan
        $filter = $request->filter;
        $bulan = $request->bulan;
        $from = $request->from;
        $to = $request->to;

        Carbon::setLocale('id');

        if ($filter === 'bulan' && $bulan) {
            $startDate = Carbon::createFromFormat('Y-m', $bulan)->startOfMonth();
            $endDate = Carbon::createFromFormat('Y-m', $bulan)->endOfMonth();
            $periodeLabel = Carbon::createFromFormat('Y-m', $bulan)->translatedFormat('F Y');
        } elseif ($filter === 'tanggal' && $from && $to) {
            $startDate = Carbon::parse($from)->startOfDay();
            $endDate = Carbon::parse($to)->endOfDay();
            $periodeLabel = Carbon::parse($from)->translatedFormat('d F Y') . ' - ' . Carbon::parse($to)->translatedFormat('d F Y');
        } else {
            return back()->with('error', 'Pilih bulan atau rentang tanggal.');
        }

        // Ambil data penjualan dengan relasi detail penjualan dan produk
        $penjualans = Penjualan::with(['detailPenjualans.detailProduk'])
            ->where('kode_cabang', $kodeCabang)
            ->whereBetween('tanggal_penjualan', [$startDate, $endDate])
            ->get();

        // Ambil pengeluaran dan kategori pengeluaran
        $pengeluarans = Pengeluaran::with('kategori')
            ->where('kode_cabang', $kodeCabang)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();

        $totalPenjualan = 0;
        $totalModal = 0;

        foreach ($penjualans as $penjualan) {
            foreach ($penjualan->detailPenjualans as $detail) {
                $hargaModal = $detail->detailProduk->harga_modal ?? 0;
                $qty = $detail->qty;
                $totalPenjualan += $detail->subtotal;
                $totalModal += ($hargaModal * $qty);
            }
        }

        $labaKotor = $totalPenjualan - $totalModal;

        // Ambil kategori pengeluaran yang bukan modal produk
        $kategoriBeban = \App\Models\KategoriPengeluaran::where('is_modal_produk', 0)->get();

        $beban = [];
        $totalBeban = 0;

        foreach ($kategoriBeban as $kategori) {
            $jumlah = $pengeluarans
                ->where('kategori_id', $kategori->id)
                ->sum('total_pengeluaran');

            if ($jumlah > 0) {
                $beban[] = [
                    'kategori' => $kategori->nama_kategori,
                    'jumlah' => $jumlah,
                ];
                $totalBeban += $jumlah;
            }
        }

        $rekap = [];

        if ($totalPenjualan > 0 || $totalModal > 0 || $totalBeban > 0) {
            $rekap[] = [
                'bulan' => $periodeLabel,
                'total_penjualan' => $totalPenjualan,
                'total_modal' => $totalModal,
                'laba_kotor' => $labaKotor,
                'beban' => $beban,
                'total_beban' => $totalBeban,
                'laba_bersih' => $labaKotor - $totalBeban,
            ];
        }

        // Nama file untuk pdf
        if ($filter === 'bulan') {
            $namaFile = 'Laporan Laba Rugi - ' . Carbon::createFromFormat('Y-m', $bulan)->translatedFormat('F Y');
        } else {
            $startFormat = Carbon::parse($from)->translatedFormat('d F Y');
            $endFormat = Carbon::parse($to)->translatedFormat('d F Y');
            $namaFile = 'Laporan Laba Rugi - ' . $startFormat . ' - ' . $endFormat;
        }


        $tanggalCetakFormatted = now()->translatedFormat('d F Y');

        $pdf = Pdf::loadView('laporan.laba-rugi.cetak-laporan', [
            'rekap' => $rekap,
            'namaCabang' => Cabang::where('kode_cabang', $kodeCabang)->value('nama_cabang'),
            'tanggalCetak' => $tanggalCetakFormatted,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream($namaFile);
    }


    public function indexMutasiStok()
    {
        $user = Auth::user();
        $kodeCabang = $user->kode_cabang;

        $logStoks = LogStok::with('detailProduk.produk', 'detailProduk.ukuran')
            ->where('kode_cabang', $kodeCabang)
            ->where('status', 'disetujui')
            ->orderBy('tanggal')
            ->get()
            ->map(function ($log) {
                $log->tanggal = Carbon::parse($log->tanggal);
                return $log;
            });

        $mutasiPerBulan = $logStoks->groupBy(function ($log) {
            return $log->tanggal->format('Y-m');
        });

        $hasil = collect();

        $daftarPeriode = $mutasiPerBulan->keys()->sortDesc();

        foreach ($daftarPeriode as $periode) {
            $logsBulanIni = $mutasiPerBulan[$periode];

            $tanggalAwalBulan = Carbon::createFromFormat('Y-m', $periode)->startOfMonth();

            //hitung stok awal
            $stokAwal = $logStoks->filter(function ($log) use ($tanggalAwalBulan) {
                return $log->tanggal->lt($tanggalAwalBulan);
            })->reduce(function ($total, $log) {
                return $total + ($log->jenis === 'masuk' ? $log->qty : -$log->qty);
            }, 0);

            // Hitung stok masuk dan keluar bulan ini
            $stokMasuk = $logsBulanIni->where('jenis', 'masuk')->sum('qty');
            $stokKeluar = $logsBulanIni->where('jenis', 'keluar')->sum('qty');

            // Hitung stok akhir = stok awal + masuk - keluar
            $stokAkhir = $stokAwal + $stokMasuk - $stokKeluar;

            // Hitung jumlah produk unik bulan ini
            $jumlahProduk = $logsBulanIni->groupBy('detail_produk_id')->count();

            $hasil->push((object)[
                'bulan' => $tanggalAwalBulan->month,       // angka bulan (1-12)
                'tahun' => $tanggalAwalBulan->year,        // angka tahun (2025)
                'nama_bulan' => $tanggalAwalBulan->locale('id')->translatedFormat('F Y'), // nama lengkap bulan
                'jumlah_produk' => $jumlahProduk,
                'stok_awal' => $stokAwal,
                'stok_masuk' => $stokMasuk,
                'stok_keluar' => $stokKeluar,
                'stok_akhir' => $stokAkhir,
            ]);

        }

        return view('laporan.mutasi-stok.index', [
            'periodeList' => $hasil,
        ]);
    }

    public function showMutasiStok($bulan, $tahun)
    {
        $user = Auth::user();
        $kodeCabang = $user->kode_cabang;

        $namaCabang = $user->cabang->nama ?? 'Semua Cabang';
        $tanggalCetak = now();

        $tanggalAwalBulan = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $tanggalAkhirBulan = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        $logStoks = LogStok::with('detailProduk.produk', 'detailProduk.ukuran')
            ->where('kode_cabang', $kodeCabang)
            ->where('status', 'disetujui')
            ->get()
            ->map(function($log) {
                $log->tanggal = Carbon::parse($log->tanggal); // <-- convert ke Carbon
                return $log;
            })
            ->groupBy('detail_produk_id');

        $dataMutasi = $logStoks->map(function ($logs) use ($tanggalAwalBulan, $tanggalAkhirBulan) {
            $first = $logs->first();
            $detail = $first->detailProduk;

            $stokAwal = $logs->filter(function ($log) use ($tanggalAwalBulan) {
                return $log->tanggal->lt($tanggalAwalBulan);
            })->sum(function ($log) {
                return $log->jenis === 'masuk' ? $log->qty : -$log->qty;
            });

            $stokMasuk = $logs->filter(function ($log) use ($tanggalAwalBulan, $tanggalAkhirBulan) {
                return $log->tanggal->between($tanggalAwalBulan, $tanggalAkhirBulan) && $log->jenis === 'masuk';
            })->sum('qty');

            $stokKeluar = $logs->filter(function ($log) use ($tanggalAwalBulan, $tanggalAkhirBulan) {
                return $log->tanggal->between($tanggalAwalBulan, $tanggalAkhirBulan) && $log->jenis === 'keluar';
            })->sum('qty');

            $stokAkhir = $stokAwal + $stokMasuk - $stokKeluar;

            return (object)[
                'nama_produk' => $detail->produk->nama_produk ?? '-',
                'ukuran' => $detail->ukuran->kode_ukuran ?? '-',
                'harga_modal' => $detail->harga_modal ?? 0,
                'harga_jual' => $detail->harga_jual ?? 0,
                'stok_awal' => $stokAwal,
                'masuk' => $stokMasuk,
                'keluar' => $stokKeluar,
                'stok_akhir' => $stokAkhir,
            ];
        })->values();

        return view('laporan.mutasi-stok.detail-perproduk', compact('namaCabang', 'tanggalCetak', 'bulan', 'tahun', 'dataMutasi'));
    }

    public function cetakMutasiStok(Request $request)
    {
        $user = Auth::user();
        $kodeCabang = $user->kode_cabang;

        $filterType = $request->input('filter');

        $from = null;
        $to = null;

        Carbon::setLocale('id');

        if ($filterType === 'bulan') {
            $periode = $request->input('bulan');
            if (!$periode || !preg_match('/^\d{4}-\d{2}$/', $periode)) {
                abort(400, 'Format periode tidak valid');
            }

            [$tahun, $bulan] = explode('-', $periode);
            $tanggalAwal = Carbon::create($tahun, $bulan, 1)->startOfDay();
            $tanggalAkhir = Carbon::create($tahun, $bulan, 1)->endOfMonth()->endOfDay();

            // format tanggal
            $periodeLabel = Carbon::createFromDate($tahun, $bulan, 1)
                ->translatedFormat('F Y');

        } elseif ($filterType === 'tanggal') {
            $from = $request->input('from');
            $to = $request->input('to');

            if (!$from || !$to) {
                abort(400, 'Tanggal awal dan akhir wajib diisi');
            }

            $tanggalAwal = Carbon::parse($from)->startOfDay();
            $tanggalAkhir = Carbon::parse($to)->endOfDay();

            $tahun = $tanggalAwal->year;
            $bulan = $tanggalAwal->month;

            // format tanggal
            $periodeLabel = Carbon::parse($from)->translatedFormat('d F Y') .
                ' s/d ' .
                Carbon::parse($to)->translatedFormat('d F Y');
        } else {
             $periodeLabel = '';
            abort(400, 'Tipe filter tidak valid');
        }

        $logStoks = LogStok::with('detailProduk.produk', 'detailProduk.ukuran')
            ->where('kode_cabang', $kodeCabang)
            ->where('status', 'disetujui')
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->get()
            ->groupBy('detail_produk_id')
            ->map(function ($logs) use ($tanggalAwal, $tanggalAkhir) {
                $first = $logs->first();
                $detail = $first->detailProduk;

                $stokAwal = $logs->where('tanggal', '<', $tanggalAwal)
                    ->reduce(fn($total, $log) => $total + ($log->jenis === 'masuk' ? $log->qty : -$log->qty), 0);

                $masuk = $logs->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
                    ->where('jenis', 'masuk')
                    ->sum('qty');

                $keluar = $logs->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
                    ->where('jenis', 'keluar')
                    ->sum('qty');

                $stokAkhir = $stokAwal + $masuk - $keluar;

                return (object)[
                    'nama_produk' => $detail->produk->nama_produk ?? '-',
                    'ukuran'      => $detail->ukuran->kode_ukuran ?? '-',
                    'harga_modal' => $detail->harga_modal ?? 0,
                    'harga_jual'  => $detail->harga_jual ?? 0,
                    'stok_awal'   => $stokAwal,
                    'masuk'       => $masuk,
                    'keluar'      => $keluar,
                    'stok_akhir'  => $stokAkhir,
                ];
            })->values();

            $tanggalCetakFormatted = now()->translatedFormat('d F Y');


        $pdf = PDF::loadView('laporan.mutasi-stok.cetak-laporan', [
            'dataMutasi'   => $logStoks,
            'namaCabang'   => $user->cabang->nama_cabang ?? $kodeCabang,
            'periodeLabel' => $periodeLabel,
            // 'bulan'        => $bulan ?? null,
            // 'tahun'        => $tahun ?? null,
            // 'from'         => $from,
            // 'to'           => $to,
            'filterType'   => $filterType,
            'tanggalCetak' => $tanggalCetakFormatted
        ])->setPaper('a4', 'landscape');

        if ($filterType === 'bulan') {
            $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y');
            $fileName = "Laporan Mutasi Stok-$namaBulan.pdf";
        } else {
            $fromFormatted = Carbon::parse($from)->translatedFormat('d F Y');
            $toFormatted = Carbon::parse($to)->translatedFormat('d F Y');
            $fileName = "Laporan Mutasi Stok-$fromFormatted-$toFormatted.pdf";
        }

        return $pdf->stream($fileName);
    }



    // public function indexBukuBesar(Request $request)
    // {
    //     $user = Auth::user();
    //     $kodeCabang = $user->kode_cabang;

    //     // Ambil filter periode dari request, default bulan ini
    //     $periode = $request->input('bulan', Carbon::now()->format('Y-m'));
    //     if (!preg_match('/^\d{4}-\d{2}$/', $periode)) {
    //         abort(400, 'Format periode tidak valid');
    //     }

    //     [$tahun, $bulan] = explode('-', $periode);
    //     $tanggalAwal = Carbon::create($tahun, $bulan, 1)->startOfDay();
    //     $tanggalAkhir = Carbon::create($tahun, $bulan, 1)->endOfMonth()->endOfDay();

    //     // Ambil semua transaksi LogStok untuk cabang dan periode tsb
    //     $logStoks = LogStok::with('detailProduk.produk')
    //         ->where('kode_cabang', $kodeCabang)
    //         ->where('status', 'disetujui')
    //         ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
    //         ->orderBy('tanggal')
    //         ->get();

    //     $akunGroup = $logStoks->groupBy(function ($log) {
    //         $produk = $log->detailProduk->produk->nama_produk ?? 'Unknown Produk';
    //         $ukuran = $log->detailProduk->ukuran->kode_ukuran ?? '-';
    //         return $produk . ' - ' . $ukuran;
    //     });

    //     $dataBukuBesar = collect();

    //     foreach ($akunGroup as $akun => $logs) {
    //         // Hitung saldo awal = saldo sebelum periode
    //         $saldoAwal = LogStok::where('kode_cabang', $logs->first()->kode_cabang)
    //             ->where('status', 'disetujui')
    //             ->whereHas('detailProduk.produk', function ($query) use ($akun) {
    //                 // Query untuk produk dan ukuran sesuai akun
    //                 // Karena ini gabungan string, kita pisah dulu
    //                 [$namaProduk, $ukuran] = explode(' - ', $akun);

    //                 $query->where('nama_produk', $namaProduk);
    //             })
    //             ->whereDate('tanggal', '<', $tanggalAwal)
    //             ->get()
    //             ->reduce(function ($total, $log) {
    //                 return $total + ($log->jenis === 'masuk' ? $log->qty : -$log->qty);
    //             }, 0);

    //         // Buat list transaksi di periode
    //         $transaksi = $logs->map(function ($log) {
    //             return (object)[
    //                 'tanggal' => \Carbon\Carbon::parse($log->tanggal)->format('Y-m-d'),
    //                 'keterangan' => $log->jenis == 'masuk' ? 'Stok Masuk' : 'Stok Keluar',
    //                 'debit' => $log->jenis == 'masuk' ? $log->qty : 0,
    //                 'kredit' => $log->jenis == 'keluar' ? $log->qty : 0,
    //             ];
    //         });

    //         // Hitung saldo berjalan tiap transaksi
    //         $saldo = $saldoAwal;
    //         $transaksi = $transaksi->map(function ($item) use (&$saldo) {
    //             $saldo += $item->debit - $item->kredit;
    //             $item->saldo = $saldo;
    //             return $item;
    //         });

    //         $dataBukuBesar->push((object)[
    //             'akun' => $akun,
    //             'saldo_awal' => $saldoAwal,
    //             'transaksi' => $transaksi,
    //         ]);
    //     }

    //     return view('laporan.buku-besar.index', [
    //         'dataBukuBesar' => $dataBukuBesar,
    //         'periode' => $periode,
    //     ]);
    // }

    // public function cetakBukuBesar(Request $request)
    // {
    //     $user = Auth::user();
    //     $kodeCabang = $user->kode_cabang;

    //     $periode = $request->input('bulan');
    //     if (!$periode || !preg_match('/^\d{4}-\d{2}$/', $periode)) {
    //         abort(400, 'Format periode tidak valid');
    //     }

    //     [$tahun, $bulan] = explode('-', $periode);
    //     $tanggalAwal = Carbon::create($tahun, $bulan, 1)->startOfDay();
    //     $tanggalAkhir = Carbon::create($tahun, $bulan, 1)->endOfMonth()->endOfDay();

    //     $logStoks = LogStok::with('detailProduk.produk')
    //         ->where('kode_cabang', $kodeCabang)
    //         ->where('status', 'disetujui')
    //         ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
    //         ->orderBy('tanggal')
    //         ->get();

    //     $akunGroup = $logStoks->groupBy(function ($log) {
    //         $produk = $log->detailProduk->produk->nama_produk ?? 'Unknown Produk';
    //         $ukuran = $log->detailProduk->ukuran->kode_ukuran ?? '-';
    //         return $produk . ' - ' . $ukuran;
    //     });

    //     $dataBukuBesar = collect();

    //     foreach ($akunGroup as $akun => $logs) {
    //         $saldoAwal = LogStok::where('kode_cabang', $logs->first()->kode_cabang)
    //             ->where('status', 'disetujui')
    //             ->whereHas('detailProduk.produk', function ($query) use ($akun) {
    //                 [$namaProduk, $ukuran] = explode(' - ', $akun);

    //                 $query->where('nama_produk', $namaProduk);
    //             })
    //             ->whereDate('tanggal', '<', $tanggalAwal)
    //             ->get()
    //             ->reduce(function ($total, $log) {
    //                 return $total + ($log->jenis === 'masuk' ? $log->qty : -$log->qty);
    //             }, 0);

    //         $transaksi = $logs->map(function ($log) {
    //             return (object)[
    //                 'tanggal' => $log->tanggal->format('Y-m-d'),
    //                 'keterangan' => $log->jenis == 'masuk' ? 'Stok Masuk' : 'Stok Keluar',
    //                 'debit' => $log->jenis == 'masuk' ? $log->qty : 0,
    //                 'kredit' => $log->jenis == 'keluar' ? $log->qty : 0,
    //             ];
    //         });

    //         $saldo = $saldoAwal;
    //         $transaksi = $transaksi->map(function ($item) use (&$saldo) {
    //             $saldo += $item->debit - $item->kredit;
    //             $item->saldo = $saldo;
    //             return $item;
    //         });

    //         $dataBukuBesar->push((object)[
    //             'akun' => $akun,
    //             'saldo_awal' => $saldoAwal,
    //             'transaksi' => $transaksi,
    //         ]);
    //     }

    //     $pdf = PDF::loadView('laporan.buku-besar.cetak-laporan', [
    //         'dataBukuBesar' => $dataBukuBesar,
    //         'namaCabang' => $user->cabang->nama_cabang ?? $kodeCabang,
    //         'bulan' => $bulan,
    //         'tahun' => $tahun,
    //         'tanggalCetak' => now(),
    //     ])->setPaper('a4', 'portrait');

    //     return $pdf->stream("buku-besar-$bulan-$tahun.pdf");
    // }
}
