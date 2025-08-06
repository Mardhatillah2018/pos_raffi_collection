<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\DetailProduk;
use App\Models\LogStok;
use App\Models\Penjualan;
use App\Models\Stok;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kodeCabang = Auth::user()->kode_cabang;

        $penjualans = Penjualan::with('user')
            ->where('kode_cabang', $kodeCabang)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('penjualan.index', compact('penjualans'));
    }



    /**
     * Show the form for creating a new resource.
     */

    public function create()
{
    $kodeCabang = Auth::user()->kode_cabang;

    $detailProduks = DetailProduk::with(['produk', 'ukuran', 'stokCabang'])
        ->whereHas('stokCabang', function ($query) {
            $query->where('stok', '>', 0);
        })
        ->get();

    $cabangs = Cabang::all();

    // Ambil no_faktur terakhir untuk hari ini
    $lastFaktur = Penjualan::whereDate('created_at', now()->toDateString())
        ->orderByDesc('id')
        ->first();

    if ($lastFaktur) {
        // ambil 4 digit terakhir dari no_faktur
        $lastNumber = (int) substr($lastFaktur->no_faktur, -4);
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    } else {
        $newNumber = '0001';
    }

    // Format: KODECABANG-TGL-NO
    $noFaktur = $kodeCabang . '-' . now()->format('Ymd') . '-' . $newNumber;

    return view('penjualan.create', compact('detailProduks', 'kodeCabang', 'cabangs', 'noFaktur'));
}


    public function review(Request $request)
    {
        $validated = $request->validate([
            'no_faktur' => 'required|string',
            'tanggal_penjualan' => 'required|date',
            'detail_produk_id.*' => 'required|exists:detail_produks,id',
            'qty.*' => 'required|integer|min:1',
            'harga_satuan.*' => 'required|numeric|min:0',
            'total_harga' => 'required|numeric|min:0',
        ]);

        $produkDetails = [];
        foreach ($request->detail_produk_id as $index => $id) {
            $produk = DetailProduk::with(['produk', 'ukuran'])->find($id);
            $qty = $request->qty[$index];
            $harga = $request->harga_satuan[$index];
            $subtotal = $qty * $harga;

            $produkDetails[] = [
                'detail_produk_id' => $id,
                'produk' => $produk->produk->nama_produk,
                'ukuran' => $produk->ukuran->nama_ukuran,
                'qty' => $qty,
                'harga' => $harga,
                'subtotal' => $subtotal,
            ];
        }

        return redirect()->route('penjualan.create')->with('reviewData', [
            'no_faktur' => $request->no_faktur,
            'tanggal_penjualan' => $request->tanggal_penjualan,
            'total_harga' => $request->total_harga,
            'produkDetails' => $produkDetails,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_penjualan' => 'required|date',
            'detail_produk_id.*' => 'required|exists:detail_produks,id',
            'qty.*' => 'required|integer|min:1',
            'harga_satuan.*' => 'required|numeric|min:0',
            'total_harga' => 'required|numeric|min:0',
            'no_faktur' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $noFaktur = $request->no_faktur;

            // Simpan data penjualan utama
            $penjualan = Penjualan::create([
                'no_faktur' => $noFaktur,
                'tanggal_penjualan' => $request->tanggal_penjualan,
                'total_harga' => $request->total_harga,
                'kode_cabang' => Auth::user()->kode_cabang,
                'created_by' => Auth::id(),
            ]);

            // Loop semua detail produk
            foreach ($request->detail_produk_id as $index => $detail_produk_id) {
                $qty = $request->qty[$index];
                $harga = $request->harga_satuan[$index];
                $subtotal = $qty * $harga;

                // Cek stok dari tabel stok berdasarkan cabang
                $stok = Stok::where('detail_produk_id', $detail_produk_id)
                            ->where('kode_cabang', Auth::user()->kode_cabang)
                            ->first();

                if (!$stok || $stok->stok < $qty) {
                    throw new \Exception('Stok tidak mencukupi untuk produk ID ' . $detail_produk_id);
                }

                // Simpan detail penjualan
                $penjualan->detailPenjualans()->create([
                    'detail_produk_id' => $detail_produk_id,
                    'qty' => $qty,
                    'harga_satuan' => $harga,
                    'subtotal' => $subtotal,
                ]);

                // Kurangi stok
                $stok->decrement('stok', $qty);
                LogStok::create([
                    'detail_produk_id' => $detail_produk_id,
                    'kode_cabang' => Auth::user()->kode_cabang,
                    'tanggal' => $request->tanggal_penjualan,
                    'qty' => $qty,
                    'jenis' => 'keluar',
                    'status' => 'disetujui',
                    'sumber' => 'penjualan',
                    'keterangan' => 'Penjualan No. Faktur ' . $noFaktur,
                    'created_by' => Auth::id(),
                ]);
            }

            DB::commit();

            return redirect('/penjualan')->with([
                'sukses_penjualan' => true,
                'penjualan_id' => $penjualan->id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan penjualan: ' . $e->getMessage());
        }
    }

    public function cetakFaktur($id)
    {
        $penjualan = Penjualan::with([
            'detailPenjualans.detailProduk.produk',
            'user',
            'cabang'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('penjualan.cetak-faktur', compact('penjualan'))
                ->setPaper([0, 0, 226.77, 566.93]);

        return $pdf->stream('faktur-penjualan-' . $penjualan->no_faktur . '.pdf');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $penjualan = Penjualan::with(['detailPenjualans.detailProduk.produk', 'detailPenjualans.detailProduk.ukuran'])
                        ->findOrFail($id);

        return view('penjualan.detail-penjualan', compact('penjualan'));
    }

    public function cetakPDF(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSampai = $request->tanggal_sampai;

        $kodeCabang = Auth::user()->kode_cabang;

        $penjualans = Penjualan::where('kode_cabang', $kodeCabang)
            ->whereDate('tanggal_penjualan', '>=', $tanggalMulai)
            ->whereDate('tanggal_penjualan', '<=', $tanggalSampai)
            ->orderBy('tanggal_penjualan', 'asc')
            ->get();

        $namaCabang = Cabang::where('kode_cabang', $kodeCabang)->value('nama_cabang') ?? '-';

        $pdf = Pdf::loadView('penjualan.laporan-penjualan', [
            'penjualans' => $penjualans,
            'namaCabang' => $namaCabang,
            'periode' => [
                'mulai' => $tanggalMulai,
                'sampai' => $tanggalSampai,
            ],
            'tanggalCetak' => now()->toDateString(),
        ])->setPaper('A4', 'portrait');

        $mulaiFormat = Carbon::parse($tanggalMulai)->translatedFormat('d F Y');
        $sampaiFormat = Carbon::parse($tanggalSampai)->translatedFormat('d F Y');
        $namaFile = "Laporan Penjualan Periode {$mulaiFormat} - {$sampaiFormat}.pdf";

        return $pdf->stream($namaFile);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penjualan $penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        //
    }
}
