<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Barang Masuk Gudang Logistik {{ date('Y-m-d H:i:s') }}</title>
</head>
<style>
    .datatable3 {
        border-collapse: collapse;
    }

    .datatable3 td {
        border: 1px solid #000000;
        padding: 6px;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        border-width: 1px;
    }

    .datatable3 th {
        border: 1px solid #050506;
        font-weight: bold;
        text-align: center;
        padding: 10px;
        font-size: 14px;
        font-family: Arial, Helvetica, sans-serif;
        background-color: #024a75;
        color: white;
        text-transform: uppercase;
        border-width: 1px;
    }

    h4 {
        font-family: Arial, Helvetica, sans-serif;
        line-height: 2px;
    }

    .right {
        text-align: right !important;
    }

    .left {
        text-align: left !important;
    }

    .center {
        text-align: center !important;
    }

    .green {
        background-color: #28a745 !important;
        color: white !important;
    }

    .header {
        margin-top: 30px;
    }
</style>

<body>
    <div class="header">
        <h4 class="title">
            LAPORAN BARANG MASUK GUDANG LOGISTIK<br>
        </h4>
        <h4>PERIODE {{ DateToIndo($dari) }} s/d {{ DateToIndo($sampai) }}</h4>
        @if (!empty($barang))
            <h4>KODE BARANG : {{ $barang->kode_barang }}</h4>
            <h4>NAMA BARANG : {{ $barang->nama_barang }}</h4>
        @endif
    </div>
    <div class="content">
        <table class="datatable3">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>TANGGAL</th>
                    <th>NO. BUKTI</th>
                    <th>KODE BARANG</th>
                    <th>NAMA BARANG</th>
                    <th>SATUAN</th>
                    <th>KETERANGAN</th>
                    <th>QTY</th>
                    <th>HARGA</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_qty = 0;
                    $grand_total = 0;
                @endphp
                @foreach ($barangmasuk as $d)
                    @php
                        $subtotal = ($d->jumlah * $d->harga) + $d->penyesuaian;
                        $total_qty += $d->jumlah;
                        $grand_total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ DateToIndo($d->tanggal) }}</td>
                        <td>{{ $d->no_bukti }}</td>
                        <td>{{ $d->kode_barang }}</td>
                        <td>{{ $d->nama_barang }}</td>
                        <td>{{ $d->satuan }}</td>
                        <td>{{ $d->keterangan }}</td>
                        <td class="right">{{ formatAngkaDesimal($d->jumlah) }}</td>
                        <td class="right">{{ formatAngkaDesimal($d->harga) }}</td>
                        <td class="right">{{ formatAngkaDesimal($subtotal) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <th colspan="7">TOTAL</th>
                <th class="right">{{ formatAngkaDesimal($total_qty) }}</th>
                <th></th>
                <th class="right">{{ formatAngkaDesimal($grand_total) }}</th>
            </tfoot>
        </table>
    </div>
</body>
</html>
