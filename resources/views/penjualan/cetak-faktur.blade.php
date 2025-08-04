<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Faktur Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .faktur-wrapper {
            width: 100%;
            padding: 0px;
        }

        .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
            margin-bottom: 5px;
        }

        .header h2 {
            margin: 0;
            font-size: 14px;
        }

        .info {
            font-size: 11px;
            margin-bottom: 10px;
        }

        .info p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        th, td {
            padding: 4px;
            border-bottom: 1px dashed #000;
        }

        th {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        tfoot td {
            font-weight: bold;
            padding-top: 6px;
            border-top: 1px solid #000;
        }

        .footer {
            text-align: center;
            margin-top: 12px;
            font-size: 11px;
            border-top: 1px dashed #000;
            padding-top: 6px;
        }
    </style>
</head>
<body>
    <div class="faktur-wrapper">
        <div class="header">
            <h2>Toko Raffi Collection</h2>
        </div>

        <div class="info">
            <p><strong>Cabang:</strong> {{ $penjualan->cabang->nama_cabang ?? '-' }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($penjualan->tanggal_penjualan)->format('d/m/Y') }}</p>
            <p><strong>No. Faktur:</strong> {{ $penjualan->no_faktur }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Uk</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Sub</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($penjualan->detailPenjualans as $i => $item)
                    @php $total += $item->subtotal ?? 0; @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item->detailProduk->produk->nama_produk ?? '-' }}</td>
                        <td>{{ $item->detailProduk->ukuran->kode_ukuran ?? '-' }}</td>
                        <td class="text-right">{{ $item->qty }}</td>
                        <td class="text-right">Rp{{ number_format($item->detailProduk->harga_jual, 0, ',', '.') }}</td>
                        <td class="text-right">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-right">Total</td>
                    <td class="text-right">Rp{{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="footer">
            -- Terima kasih --
        </div>
    </div>
</body>
</html>
