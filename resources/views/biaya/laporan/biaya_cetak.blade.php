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
        @if(($jenis_periode ?? '') == 'bulan_pajak')
            <h4> BULAN / MASA PAJAK {{ str_pad($bulan, 2, '0', STR_PAD_LEFT) }} TAHUN {{ $tahun }}</h4>
        @else
            <h4> PERIODE {{ DateToIndo($dari) }} s/d {{ DateToIndo($sampai) }}</h4>
        @endif
        @if ($supplier != null)
            <h4>
                {{ $supplier->kode_supplier }} - {{ $supplier->nama_supplier }}
            </h4>
        @endif
    </div>
    <div class="content">
        <div class="freeze-table">
            <table class="datatable3" style="width: 130%">
                <thead>
                    <tr>
                        <th style="width:1%">NO</th>
                        <th style="width:4%">TGL</th>
                        <th style="width:4%">MASA PAJAK</th>
                        <th style="width:5%">NO BUKTI</th>
                        <th style="width:10%">SUPPLIER / REKANAN</th>
                        <th style="width:12%">KETERANGAN / RINCIAN</th>
                        <th style="width:8%">KODE AKUN</th>
                        <th style="width:3%">QTY</th>
                        <th style="width:5%">HARGA</th>
                        <th style="width:5%">DPP</th>
                        <th style="width:5%">DPP LAIN</th>
                        <th style="width:5%">PPN</th>
                        <th style="width:6%">TOTAL</th>
                        <th style="width:4%">DIBUAT</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandtotal = 0;
                        $total_dpp = 0;
                        $total_dpp_lain = 0;
                        $total_ppn = 0;
                    @endphp
                    @foreach ($biaya as $key => $d)
                        @php
                            $subtotal = $d->jumlah * $d->harga;
                            $total = $subtotal + $d->penyesuaian;

                            if ($d->ppn == '1') {
                                $dpp_val = (100 / 111) * $total;
                                $dpp_lain_val = $dpp_val * (11 / 12);
                                $ppn_val = $dpp_lain_val * (12 / 100);
                            } else {
                                $dpp_val = 0;
                                $dpp_lain_val = 0;
                                $ppn_val = 0;
                            }

                            $total_dpp += $dpp_val;
                            $total_dpp_lain += $dpp_lain_val;
                            $total_ppn += $ppn_val;
                            $grandtotal += $total;

                            $masaPajak = (!empty($d->bulan_pajak) ? str_pad($d->bulan_pajak, 2, '0', STR_PAD_LEFT) : date('m', strtotime($d->tanggal))) . '/' . (!empty($d->tahun_pajak) ? $d->tahun_pajak : date('Y', strtotime($d->tanggal)));
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ formatIndo($d->tanggal) }}</td>
                            <td class="center font-mono">{{ $masaPajak }}</td>
                            <td>{{ $d->no_bukti }}</td>
                            <td>{{ $d->nama_supplier ?? '-' }}</td>
                            <td>{{ $d->keterangan }}</td>
                            <td>{{ $d->kode_akun }} - {{ $d->nama_akun }}</td>
                            <td class="center">{{ formatAngkaDesimal($d->jumlah) }}</td>
                            <td class="right">{{ formatAngkaDesimal($d->harga) }}</td>
                            <td class="right">{{ formatAngkaDesimal($dpp_val) }}</td>
                            <td class="right">{{ formatAngkaDesimal($dpp_lain_val) }}</td>
                            <td class="right">{{ formatAngkaDesimal($ppn_val) }}</td>
                            <td class="right" style="font-weight: bold">{{ formatAngkaDesimal($total) }}</td>
                            <td>{{ date('d-m-Y H:i', strtotime($d->created_at_header ?? $d->created_at)) }}</td>
                        </tr>
                    @endforeach
                    @if($biaya->isEmpty())
                        <tr>
                            <td colspan="14" style="text-align: center; color: #888; padding: 20px;">Tidak ada data biaya pada periode ini.</td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="8" style="text-align: right">GRAND TOTAL</th>
                        <th class="right" style="font-weight: bold">{{ formatAngkaDesimal($total_dpp) }}</th>
                        <th class="right" style="font-weight: bold">{{ formatAngkaDesimal($total_dpp_lain) }}</th>
                        <th class="right" style="font-weight: bold">{{ formatAngkaDesimal($total_ppn) }}</th>
                        <th class="right" style="font-weight: bold">{{ formatAngkaDesimal($grandtotal) }}</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
</html>
