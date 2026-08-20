<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Penjualan Marketing {{ date('Y-m-d H:i:s') }}</title>
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
            LAPORAN RINCIAN PENJUALAN MARKETING<br>
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
                        <th style="width:5%">TGL</th>
                        <th style="width:7%">NO BUKTI</th>
                        <th style="width:15%">PELANGGAN</th>
                        <th style="width:6%">KODE PRODUK</th>
                        <th style="width:15%">NAMA PRODUK</th>
                        <th style="width:4%">SATUAN</th>
                        <th style="width:4%">QTY</th>
                        <th style="width:8%">HARGA</th>
                        <th style="width:10%">DPP</th>
                        <th style="width:10%">DPP LAIN</th>
                        <th style="width:10%">PPN (11%)</th>
                        <th style="width:12%">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grouped = $penjualan->groupBy('no_bukti');
                        $grand_qty = 0;
                        $grand_dpp = 0;
                        $grand_dpp_lain = 0;
                        $grand_ppn = 0;
                        $grand_total = 0;
                        $global_index = 1;
                    @endphp
                    @foreach ($grouped as $no_bukti => $items)
                        @php
                            $sub_qty = 0;
                            $sub_dpp = 0;
                            $sub_dpp_lain = 0;
                            $sub_ppn = 0;
                            $sub_total = 0;
                        @endphp
                        @foreach ($items as $d)
                            @php
                                $dpp = $d->harga * $d->qty;
                                $dpp_lain = $dpp * 11 / 12;
                                $ppn = $dpp_lain * 0.12;
                                $total = $dpp + $ppn;

                                $sub_qty += $d->qty;
                                $sub_dpp += $dpp;
                                $sub_dpp_lain += $dpp_lain;
                                $sub_ppn += $ppn;
                                $sub_total += $total;

                                $grand_qty += $d->qty;
                                $grand_dpp += $dpp;
                                $grand_dpp_lain += $dpp_lain;
                                $grand_ppn += $ppn;
                                $grand_total += $total;
                            @endphp
                            <tr>
                                <td class="center">{{ $global_index++ }}</td>
                                <td class="center">{{ date('d-m-Y', strtotime($d->tanggal)) }}</td>
                                <td class="center font-mono">{{ $d->no_bukti }}</td>
                                <td>{{ $d->nama_pelanggan }}</td>
                                <td class="center font-mono">{{ $d->kode_produk }}</td>
                                <td>{{ $d->nama_produk }}</td>
                                <td class="center">
                                    <span style="text-transform: uppercase;">{{ $d->satuan }}</span>
                                </td>
                                <td class="right">{{ formatAngkaDesimal($d->qty) }}</td>
                                <td class="right">Rp {{ formatAngkaDesimal($d->harga) }}</td>
                                <td class="right">Rp {{ formatAngkaDesimal($dpp) }}</td>
                                <td class="right">Rp {{ formatAngkaDesimal($dpp_lain) }}</td>
                                <td class="right">Rp {{ formatAngkaDesimal($ppn) }}</td>
                                <td class="right" style="font-weight: bold;">Rp {{ formatAngkaDesimal($total) }}</td>
                            </tr>
                        @endforeach
                        <!-- Subtotal Row per No Bukti -->
                        <tr style="background-color: #f8fafc; font-weight: bold; font-style: italic;">
                            <td colspan="7" class="right" style="color: #4b5563;">SUBTOTAL ({{ $no_bukti }}) :</td>
                            <td class="right" style="color: #1e3a8a;">{{ formatAngkaDesimal($sub_qty) }}</td>
                            <td></td>
                            <td class="right" style="color: #1e3a8a;">Rp {{ formatAngkaDesimal($sub_dpp) }}</td>
                            <td class="right" style="color: #1e3a8a;">Rp {{ formatAngkaDesimal($sub_dpp_lain) }}</td>
                            <td class="right" style="color: #1e3a8a;">Rp {{ formatAngkaDesimal($sub_ppn) }}</td>
                            <td class="right" style="color: #1e3a8a;">Rp {{ formatAngkaDesimal($sub_total) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-dark">
                    <tr style="font-weight: bold; background-color: #f3f4f6;">
                        <th colspan="7" align="center"><b>TOTAL</b></th>
                        <th class="right">{{ formatAngkaDesimal($grand_qty) }}</th>
                        <th></th>
                        <th class="right">Rp {{ formatAngkaDesimal($grand_dpp) }}</th>
                        <th class="right">Rp {{ formatAngkaDesimal($grand_dpp_lain) }}</th>
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
        'columnNum': 4,
        'shadow': true,
    });
</script>
</html>
