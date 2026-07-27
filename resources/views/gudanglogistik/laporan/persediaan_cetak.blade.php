<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Persediaan Gudang Logistik {{ date('Y-m-d H:i:s') }}</title>
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
            LAPORAN BARANG PERSEDIAAN GUDANG LOGISTIK<br>
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
                    <th>OPNAME</th>
                    <th>SELISIH</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_saldo_awal = 0;
                    $total_pemasukan = 0;
                    $total_pengeluaran = 0;
                    $total_saldo_akhir = 0;
                    $total_opname = 0;
                    $total_selisih = 0;
                @endphp
                @foreach ($persediaan as $d)
                    @php
                        $selisih = ROUND($d->opname_qty, 2) - ROUND($d->saldo_akhir_qty, 2);
                        
                        $total_saldo_awal += $d->saldo_awal_qty;
                        $total_pemasukan += $d->bm_qty;
                        $total_pengeluaran += $d->bk_qty;
                        $total_saldo_akhir += $d->saldo_akhir_qty;
                        $total_opname += $d->opname_qty;
                        $total_selisih += $selisih;
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
                        <td class="right">{{ formatAngkaDesimal($d->opname_qty) }}</td>
                        <td class="right">{{ formatAngkaDesimal($selisih) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">TOTAL</th>
                    <th class="right">{{ formatAngkaDesimal($total_saldo_awal) }}</th>
                    <th class="right">{{ formatAngkaDesimal($total_pemasukan) }}</th>
                    <th class="right">{{ formatAngkaDesimal($total_pengeluaran) }}</th>
                    <th class="right">{{ formatAngkaDesimal($total_saldo_akhir) }}</th>
                    <th class="right">{{ formatAngkaDesimal($total_opname) }}</th>
                    <th class="right">{{ formatAngkaDesimal($total_selisih) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
