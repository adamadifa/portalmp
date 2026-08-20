<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Kartu Piutang {{ date('Y-m-d H:i:s') }}</title>
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
            LAPORAN KARTU PIUTANG MARKETING<br>
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
            <table class="datatable3" style="width: 150%">
                <thead>
                    <tr>
                        <th style="width:1%">NO</th>
                        <th style="width:5%">TANGGAL</th>
                        <th style="width:7%">NO BUKTI</th>
                        <th style="width:6%">KODE PEL.</th>
                        <th style="width:15%">NAMA PELANGGAN</th>
                        <th style="width:8%">TOTAL PIUTANG</th>
                        <th style="width:8%">SALDO AWAL</th>
                        <th style="width:8%">PENJUALAN</th>
                        <th style="width:8%">PEMBAYARAN</th>
                        <th style="width:10%">SALDO AKHIR</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grand_total_piutang = 0;
                        $grand_saldo_awal = 0;
                        $grand_netto = 0;
                        $grand_bayar = 0;
                        $grand_saldo_akhir = 0;
                    @endphp
                    @foreach ($kartupiutang as $d)
                        @php
                            $grand_total_piutang += $d->total_piutang;
                            $grand_saldo_awal += $d->saldo_awal;
                            $grand_netto += $d->netto;
                            $grand_bayar += $d->jmlbayar;
                            $grand_saldo_akhir += $d->saldo_akhir;
                        @endphp
                        <tr>
                            <td class="center">{{ $loop->iteration }}</td>
                            <td class="center">{{ date('d-m-Y', strtotime($d->tanggal)) }}</td>
                            <td class="center font-mono">{{ $d->no_bukti }}</td>
                            <td class="center font-mono">{{ $d->kode_pelanggan }}</td>
                            <td>{{ $d->nama_pelanggan }}</td>
                            <td class="right">Rp {{ formatAngkaDesimal($d->total_piutang) }}</td>
                            <td class="right">Rp {{ formatAngkaDesimal($d->saldo_awal) }}</td>
                            <td class="right">Rp {{ formatAngkaDesimal($d->netto) }}</td>
                            <td class="right" style="color: #16a34a;">Rp {{ formatAngkaDesimal($d->jmlbayar) }}</td>
                            <td class="right" style="font-weight: bold; color: #dc2626;">Rp {{ formatAngkaDesimal($d->saldo_akhir) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-dark">
                    <tr style="font-weight: bold; background-color: #f3f4f6;">
                        <th colspan="5" align="center"><b>TOTAL</b></th>
                        <th class="right">Rp {{ formatAngkaDesimal($grand_total_piutang) }}</th>
                        <th class="right">Rp {{ formatAngkaDesimal($grand_saldo_awal) }}</th>
                        <th class="right">Rp {{ formatAngkaDesimal($grand_netto) }}</th>
                        <th class="right">Rp {{ formatAngkaDesimal($grand_bayar) }}</th>
                        <th class="right">Rp {{ formatAngkaDesimal($grand_saldo_akhir) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
<script>
    $(".freeze-table").freezeTable({
        'scrollable': true,
        'columnNum': 5,
        'shadow': true,
    });
</script>
</html>
