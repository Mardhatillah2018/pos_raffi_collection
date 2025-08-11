<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .struk-wrapper {
            width: 100%;
            padding: 0px;
        }

        .header, .footer {
            text-align: center;
            font-size: 11px;
        }

        .header h2 {
            margin: 0;
            font-size: 14px;
        }

        .info {
            font-size: 11px;
            margin: 10px 0;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 5px 0;
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
            text-align: left;
        }

        thead {
            border-bottom: 1px solid #000;
        }

        tfoot td {
            font-weight: bold;
            padding-top: 6px;
            border-top: 1px solid #000;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

    </style>
</head>
<body>
    <div class="struk-wrapper">
        <div class="header">
            <p>Selamat Datang</p>
            <h2>Raffi Collection</h2>
            <p>{{ $penjualan->cabang->alamat ?? '-' }}</p>
            <p>{{ $penjualan->cabang->no_hp ?? '-' }}</p>
        </div>

        <div class="info">
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($penjualan->created_at)->format('d/m/Y H:i:s') }}</p>
            <p><strong>Kasir:</strong> {{ $penjualan->user->nama ?? '-' }}</p>
            <p><strong>No. Struk:</strong> {{ $penjualan->no_struk }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Qty</th>
                    <th>Nama Produk</th>
                    <th>Uk</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Sub</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($penjualan->detailPenjualans as $item)
                    @php $total += $item->subtotal ?? 0; @endphp
                    <tr>
                        <td>{{ $item->qty }}</td>
                        <td>{{ $item->detailProduk->produk->nama_produk ?? '-' }}</td>
                        <td>{{ $item->detailProduk->ukuran->kode_ukuran ?? '-' }}</td>
                        <td class="text-right">Rp{{ number_format($item->detailProduk->harga_jual, 0, ',', '.') }}</td>
                        <td class="text-right">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right">Total:</td>
                    <td class="text-right">Rp{{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="footer">
            <p>-- Terimakasih --</p>
            <p>Barang yang sudah dibayar tidak dapat dikembalikan</p>
        </div>
    </div>
</body>
</html>
