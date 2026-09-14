<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pembayaran Biaya {{ date('Y-m-d H:i:s') }}</title>
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
            LAPORAN PEMBAYARAN BIAYA<br>
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
                        <th style="width:2%">NO</th>
                        <th style="width:6%">TGL BAYAR</th>
                        <th style="width:8%">NO BUKTI</th>
                        <th style="width:14%">SUPPLIER / REKANAN</th>
                        <th style="width:10%">BANK / KAS</th>
                        <th style="width:5%">CABANG</th>
                        <th style="width:14%">KETERANGAN</th>
                        <th style="width:8%">JUMLAH BAYAR</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandtotal = 0;
                    @endphp
                    @foreach ($pembayaran as $d)
                        @php
                            $grandtotal += $d->jumlah;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ formatIndo($d->tanggal) }}</td>
                            <td>{{ $d->no_bukti }}</td>
                            <td>{{ $d->nama_supplier ?? '-' }}</td>
                            <td>{{ $d->nama_bank }}</td>
                            <td class="center">{{ $d->kode_cabang ?? '-' }}</td>
                            <td>{{ $d->keterangan ?? '-' }}</td>
                            <td class="right" style="font-weight: bold">{{ formatAngkaDesimal($d->jumlah) }}</td>
                        </tr>
                    @endforeach
                    @if($pembayaran->isEmpty())
                        <tr>
                            <td colspan="8" style="text-align: center; color: #888; padding: 20px;">Tidak ada catatan histori pembayaran pada periode ini.</td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="7" style="text-align: right">TOTAL PEMBAYARAN</th>
                        <th class="right" style="font-weight: bold">{{ formatAngkaDesimal($grandtotal) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
</html>
