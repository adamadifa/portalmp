<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kartu Gudang Logistik {{ $barang->nama_barang }}{{ date('Y-m-d H:i:s') }}</title>
</head>
<style>
    .datatable3 {
        border-collapse: collapse;
        width: 100%;
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

    .header {
        margin-top: 30px;
    }
</style>

<body>
    <div class="header">
        <h4 class="title">
            KARTU GUDANG LOGISTIK<br>
        </h4>
        <h4>PERIODE {{ DateToIndo($dari) }} s/d {{ DateToIndo($sampai) }}</h4>
        <h4>{{ $barang->kode_barang }} {{ strtoupper($barang->nama_barang) }} ({{ $barang->satuan }})</h4>
    </div>
    <div class="content">
        @php
            $saldo_running = $saldo_awal != null ? $saldo_awal->jumlah : 0;
        @endphp
        <table class="datatable3">
            <thead>
                <tr>
                    <th>TANGGAL</th>
                    <th>KETERANGAN</th>
                    <th>MASUK</th>
                    <th>KELUAR</th>
                    <th>SALDO</th>
                </tr>
                <tr>
                    <th>SALDO AWAL</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th class="right">{{ formatAngkaDesimal($saldo_running) }}</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_masuk = 0;
                    $total_keluar = 0;
                @endphp
                @foreach ($kartu_gudang as $d)
                    @php
                        $saldo_running += $d->qty_masuk - $d->qty_keluar;
                        $total_masuk += $d->qty_masuk;
                        $total_keluar += $d->qty_keluar;
                    @endphp
                    <tr>
                        <td>{{ DateToIndo($d->tanggal) }}</td>
                        <td>{{ $d->keterangan ?? '-' }}</td>
                        <td class="right">{{ $d->qty_masuk > 0 ? formatAngkaDesimal($d->qty_masuk) : '-' }}</td>
                        <td class="right">{{ $d->qty_keluar > 0 ? formatAngkaDesimal($d->qty_keluar) : '-' }}</td>
                        <td class="right">{{ formatAngkaDesimal($saldo_running) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">TOTAL MUTASI</th>
                    <th class="right">{{ formatAngkaDesimal($total_masuk) }}</th>
                    <th class="right">{{ formatAngkaDesimal($total_keluar) }}</th>
                    <th class="right">{{ formatAngkaDesimal($saldo_running) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
