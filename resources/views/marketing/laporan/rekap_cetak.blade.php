<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekap Penjualan Marketing {{ date('Y-m-d H:i:s') }}</title>
    <link class="report-style" rel="stylesheet" href="{{ asset('assets/css/report.css') }}">
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
            REKAPITULASI PENJUALAN MARKETING<br>
        </h4>
        <h4> PERIODE {{ DateToIndo($dari) }} s/d {{ DateToIndo($sampai) }}</h4>
        @if ($selected_pelanggan != null)
            <h4>
                {{ $selected_pelanggan->kode_pelanggan }} - {{ $selected_pelanggan->nama_pelanggan }}
            </h4>
        @endif
    </div>
    <div class="content">
        <div class="freeze-table">
            <table class="datatable3" style="width: 100%">
                <thead>
                    <tr>
                        <th style="width:1%">NO</th>
                        <th style="width:10%">KODE PRODUK</th>
                        <th style="width:25%">NAMA PRODUK</th>
                        <th style="width:7%">SATUAN</th>
                        <th style="width:10%">TOTAL QTY</th>
                        <th style="width:15%">TOTAL DPP</th>
                        <th style="width:15%">TOTAL PPN (11%)</th>
                        <th style="width:17%">GRAND TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grand_qty = 0;
                        $grand_dpp = 0;
                        $grand_ppn = 0;
                        $grand_total = 0;
                    @endphp
                    @foreach ($rekap as $d)
                        @php
                            $grand_qty += $d->total_qty;
                            $grand_dpp += $d->total_dpp;
                            $grand_ppn += $d->total_ppn;
                            $grand_total += $d->total_jumlah;
                        @endphp
                        <tr>
                            <td class="center">{{ $loop->iteration }}</td>
                            <td class="center font-mono">{{ $d->kode_produk }}</td>
                            <td>{{ $d->nama_produk }}</td>
                            <td class="center">
                                <span style="text-transform: uppercase;">{{ $d->satuan }}</span>
                            </td>
                            <td class="right">{{ formatAngkaDesimal($d->total_qty) }}</td>
                            <td class="right">Rp {{ formatAngkaDesimal($d->total_dpp) }}</td>
                            <td class="right">Rp {{ formatAngkaDesimal($d->total_ppn) }}</td>
                            <td class="right" style="font-weight: bold;">Rp {{ formatAngkaDesimal($d->total_jumlah) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-dark">
                    <tr style="font-weight: bold; background-color: #f3f4f6;">
                        <th colspan="4" align="center"><b>TOTAL</b></th>
                        <th class="right">{{ formatAngkaDesimal($grand_qty) }}</th>
                        <th class="right">Rp {{ formatAngkaDesimal($grand_dpp) }}</th>
                        <th class="right">Rp {{ formatAngkaDesimal($grand_ppn) }}</th>
                        <th class="right">Rp {{ formatAngkaDesimal($grand_total) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
<script>
    $(".freeze-table").freezeTable({
        'scrollable': true,
        'columnNum': 3,
        'shadow': true,
    });
</script>
</html>
