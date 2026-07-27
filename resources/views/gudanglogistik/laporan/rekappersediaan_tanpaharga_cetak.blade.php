<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekap Persediaan Gudang Logistik {{ date('Y-m-d H:i:s') }}</title>
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

    .header {
        margin-top: 30px;
    }
</style>

<body>
    <div class="header">
        <h4 class="title">
            REKAP PERSEDIAAN GUDANG LOGISTIK<br>
        </h4>
        <h4>PERIODE {{ DateToIndo($dari) }} s/d {{ DateToIndo($sampai) }}</h4>
        <h4>KATEGORI {{ $kategori->nama_kategori }}</h4>
    </div>
    <div class="content">
        <table class="datatable3">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>KODE</th>
                    <th>NAMA BARANG</th>
                    <th>SATUAN</th>
                    <th>SALDO AWAL</th>
                    <th>PEMASUKAN</th>
                    <th>PENGELUARAN</th>
                    <th>SALDO AKHIR</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grand_saldo_awal_qty = 0;
                    $grand_bm_qty = 0;
                    $grand_bk_qty = 0;
                    $grand_saldo_akhir_qty = 0;
                @endphp
                @foreach ($rekappersediaan as $d)
                    @php
                        $grand_saldo_awal_qty += $d->saldo_awal_qty;
                        $grand_bm_qty += $d->bm_qty;
                        $grand_bk_qty += $d->bk_qty;
                        $grand_saldo_akhir_qty += $d->saldo_akhir_qty;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->kode_barang }}</td>
                        <td>{{ $d->nama_barang }}</td>
                        <td>{{ $d->satuan }}</td>
                        <td class="right">{{ formatAngkaDesimal($d->saldo_awal_qty) }}</td>
                        <td class="right">{{ formatAngkaDesimal($d->bm_qty) }}</td>
                        <td class="right">{{ formatAngkaDesimal($d->bk_qty) }}</td>
                        <td class="right">{{ formatAngkaDesimal($d->saldo_akhir_qty) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">TOTAL</th>
                    <th class="right">{{ formatAngkaDesimal($grand_saldo_awal_qty) }}</th>
                    <th class="right">{{ formatAngkaDesimal($grand_bm_qty) }}</th>
                    <th class="right">{{ formatAngkaDesimal($grand_bk_qty) }}</th>
                    <th class="right">{{ formatAngkaDesimal($grand_saldo_akhir_qty) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
