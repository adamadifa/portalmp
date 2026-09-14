<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekap Akun Biaya {{ date('Y-m-d H:i:s') }}</title>
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
            REKAPITULASI AKUN BIAYA (COA)<br>
        </h4>
        <h4> PERIODE {{ DateToIndo($dari) }} s/d {{ DateToIndo($sampai) }}</h4>
    </div>
    <div class="content">
        <div class="freeze-table">
            <table class="datatable3" style="width: 100%">
                <thead>
                    <tr>
                        <th style="width:2%">NO</th>
                        <th style="width:10%">KODE AKUN</th>
                        <th style="width:30%">NAMA AKUN (COA)</th>
                        <th style="width:10%">JML TRANSAKSI</th>
                        <th style="width:15%">TOTAL BIAYA</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandtotal = 0;
                        $total_trx = 0;
                    @endphp
                    @foreach ($rekap as $d)
                        @php
                            $grandtotal += $d->total_biaya;
                            $total_trx += $d->jumlah_transaksi;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>'{{ $d->kode_akun }}</td>
                            <td>{{ $d->nama_akun }}</td>
                            <td class="center">{{ $d->jumlah_transaksi }}</td>
                            <td class="right" style="font-weight: bold">{{ formatAngkaDesimal($d->total_biaya) }}</td>
                        </tr>
                    @endforeach
                    @if($rekap->isEmpty())
                        <tr>
                            <td colspan="5" style="text-align: center; color: #888; padding: 20px;">Tidak ada rekap data pada periode ini.</td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" style="text-align: right">GRAND TOTAL</th>
                        <th class="center" style="font-weight: bold">{{ $total_trx }}</th>
                        <th class="right" style="font-weight: bold">{{ formatAngkaDesimal($grandtotal) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
</html>
