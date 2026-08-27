<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pembelian {{ date('Y-m-d H:i:s') }}</title>
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
            LAPORAN PEMBELIAN<br>
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
            <table class="datatable3" style="width: 125%">
                <thead>
                    <tr>
                        <th style="width:1%">NO</th>
                        <th style="width:4%">TGL</th>
                        <th style="width:4%">NO BUKTI</th>
                        <th style="width:10%">SUPPLIER</th>
                        <th style="width:10%">NAMA BARANG</th>
                        <th style="width:10%">KETERANGAN</th>
                        <th style="width:2%">JT</th>
                        <th style="width:4%">QTY</th>
                        <th style="width:5%">HARGA</th>
                        <th style="width:5%">DPP</th>
                        <th style="width:5%">DPP LAIN</th>
                        <th style="width:5%">PPN</th>
                        <th>TOTAL</th>
                        <th style="width: 5%">DIBUAT</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandtotal = 0;
                        $total_dpp = 0;
                        $total_dpp_lain = 0;
                        $total_ppn = 0;
                    @endphp
                    @foreach ($pembelian as $key => $d)
                        @php
                            $no_bukti = @$pembelian[$key + 1]->no_bukti;
                            $subtotal = ROUND($d->jumlah * $d->harga, 2);
                            $total = $subtotal + $d->penyesuaian;
                            if ($d->ppn == '1') {
                                $bgcolor = '#ececc8';
                            } else {
                                $bgcolor = '';
                            }

                            if ($d->kode_transaksi == 'PNJ') {
                                $namabarang = $d->ket_penjualan;
                            } else {
                                $namabarang = $d->nama_barang;
                            }

                            $dpp_val = $subtotal * 100 / 111;
                            $dpp_lain_val = $dpp_val * 11 / 12;
                            $ppn_val = $dpp_lain_val * 0.12;

                            $total_dpp += $dpp_val;
                            $total_dpp_lain += $dpp_lain_val;
                            $total_ppn += $ppn_val;
                            $grandtotal += $total;
                        @endphp
                        <tr style="background-color: {{ $bgcolor }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ formatIndo($d->tanggal) }}</td>
                            <td>{{ $d->no_bukti }}</td>
                            <td>{{ $d->nama_supplier }}</td>
                            <td>{{ $namabarang }}</td>
                            <td>{{ $d->keterangan ?? $d->keterangan_penjualan }}</td>
                            <td class="center">{{ $d->jenis_transaksi }}</td>
                            <td class="right">{{ formatAngkaDesimal($d->jumlah) }}</td>
                            <td class="right">{{ formatAngkaDesimal($d->harga) }}</td>
                            <td class="right">{{ formatAngkaDesimal($dpp_val) }}</td>
                            <td class="right">{{ formatAngkaDesimal($dpp_lain_val) }}</td>
                            <td class="right">{{ formatAngkaDesimal($ppn_val) }}</td>
                            <td class="right">{{ formatAngkaDesimal($total) }}</td>
                            <td>{{ date('d-m-Y H:i', strtotime($d->created_at)) }}</td>

                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-dark">
                    <tr>
                        <th colspan="9" align="center"><b>TOTAL</b></th>
                        <th class="right">{{ formatAngkaDesimal($total_dpp) }}</th>
                        <th class="right">{{ formatAngkaDesimal($total_dpp_lain) }}</th>
                        <th class="right">{{ formatAngkaDesimal($total_ppn) }}</th>
                        <th class="right">{{ formatAngkaDesimal($grandtotal) }}</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
<script>
    $(".freeze-table").freezeTable({
        'scrollable': true,
        'columnNum': 9,
        'shadow': true,
    });
</script>
