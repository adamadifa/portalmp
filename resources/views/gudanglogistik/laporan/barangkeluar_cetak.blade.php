<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Barang Keluar Gudang Logistik {{ date('Y-m-d H:i:s') }}</title>
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

    .red {
        background-color: #c7473a !important;
        color: white !important;
    }

    .header {
        margin-top: 30px;
    }
</style>

<body>
    <div class="header">
        <h4 class="title">
            LAPORAN BARANG KELUAR GUDANG LOGISTIK<br>
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
                    <th>JENIS PENGELUARAN</th>
                    <th>QTY</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_qty = 0;
                @endphp
                @foreach ($barangkeluar as $d)
                    @php
                        $total_qty += $d->jumlah;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ DateToIndo($d->tanggal) }}</td>
                        <td>{{ $d->no_bukti }}</td>
                        <td>{{ $d->kode_barang }}</td>
                        <td>{{ $d->nama_barang }}</td>
                        <td>{{ $d->satuan }}</td>
                        <td>{{ $d->keterangan }}</td>
                        <td>{{ $jenis_pengeluaran[$d->kode_jenis_pengeluaran] ?? $d->kode_jenis_pengeluaran }}</td>
                        <td class="right">{{ formatAngkaDesimal($d->jumlah) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <th colspan="8">TOTAL</th>
                <th class="right">{{ formatAngkaDesimal($total_qty) }}</th>
            </tfoot>
        </table>
    </div>
</body>
</html>
