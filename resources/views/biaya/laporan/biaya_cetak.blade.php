<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Biaya {{ date('Y-m-d H:i:s') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">
    <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
    <script src="{{ asset('assets/vendor/libs/freeze/js/freeze-table.min.js') }}"></script>
    <style>
        .freeze-table {
            height: auto;
            max-height: 830px;
            overflow: auto;
        }
    </style>
</head>

<body>
    <div class="header">
        <h4 class="title">
            LAPORAN TRANSAKSI BIAYA<br>
        </h4>
        <h4> PERIODE {{ DateToIndo($dari) }} s/d {{ DateToIndo($sampai) }}</h4>
        @if ($supplier != null)
            <h4>
                {{ $supplier->kode_supplier }} - {{ $supplier->nama_supplier }}
            </h4>
        @endif
    </div>
    <div class="content">
        <div class="freeze-table">
            <table class="datatable3" style="width: 100%">
                <thead>
                    <tr>
                        <th style="width:1%">NO</th>
                        <th style="width:4%">TGL</th>
                        <th style="width:5%">NO BUKTI</th>
                        <th style="width:10%">SUPPLIER / REKANAN</th>
                        <th style="width:12%">KETERANGAN / RINCIAN</th>
                        <th style="width:8%">KODE AKUN</th>
                        <th style="width:2%">JT</th>
                        <th style="width:3%">QTY</th>
                        <th style="width:5%">HARGA</th>
                        <th style="width:4%">PENY</th>
                        <th style="width:6%">TOTAL</th>
                        <th style="width:4%">DIBUAT</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandtotal = 0;
                    @endphp
                    @foreach ($biaya as $key => $d)
                        @php
                            $subtotal = $d->jumlah * $d->harga;
                            $total = $subtotal + $d->penyesuaian;
                            $grandtotal += $total;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ formatIndo($d->tanggal) }}</td>
                            <td>{{ $d->no_bukti }}</td>
                            <td>{{ $d->nama_supplier ?? '-' }}</td>
                            <td>{{ $d->keterangan }}</td>
                            <td>{{ $d->kode_akun }} - {{ $d->nama_akun }}</td>
                            <td class="center">{{ $d->jenis_transaksi }}</td>
                            <td class="center">{{ formatAngkaDesimal($d->jumlah) }}</td>
                            <td class="right">{{ formatAngkaDesimal($d->harga) }}</td>
                            <td class="right">{{ formatAngkaDesimal($d->penyesuaian) }}</td>
                            <td class="right" style="font-weight: bold">{{ formatAngkaDesimal($total) }}</td>
                            <td>{{ date('d-m-Y H:i', strtotime($d->created_at_header ?? $d->created_at)) }}</td>
                        </tr>
                    @endforeach
                    @if($biaya->isEmpty())
                        <tr>
                            <td colspan="12" style="text-align: center; color: #888; padding: 20px;">Tidak ada data biaya pada periode ini.</td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="10" style="text-align: right">GRAND TOTAL</th>
                        <th class="right" style="font-weight: bold">{{ formatAngkaDesimal($grandtotal) }}</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
</html>
