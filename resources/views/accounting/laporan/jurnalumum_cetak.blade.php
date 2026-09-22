<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jurnal Umum {{ date('Y-m-d H:i:s') }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #111;
            margin: 30px;
            background-color: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header .company-name {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            color: #000;
        }

        .header .report-title {
            font-size: 20px;
            font-weight: bold;
            margin: 5px 0;
            color: #1e3a8a;
        }

        .header .period {
            font-size: 13px;
            margin: 5px 0 0 0;
            color: #333;
            font-weight: bold;
        }

        .content {
            margin: 0 auto;
            max-width: 100%;
        }

        .datatable {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .datatable th {
            background-color: #1e3a8a;
            color: #ffffff;
            font-weight: bold;
            padding: 8px 10px;
            border: 1px solid #1e3a8a;
            text-align: left;
        }

        .datatable td {
            padding: 7px 10px;
            border: 1px solid #e5e7eb;
            vertical-align: middle;
        }

        .datatable tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .text-center { text-align: center !important; }
        .text-right { text-align: right !important; }
        .font-bold { font-weight: bold !important; }

        .total-row {
            background-color: #e2e8f0 !important;
            font-weight: bold;
            border-top: 2px solid #1e3a8a;
            border-bottom: 2px solid #1e3a8a;
        }
    </style>
</head>
<body>
    <div class="header">
        <h4 class="company-name">PT MAKMUR PERMATA</h4>
        <h2 class="report-title">JURNAL UMUM</h2>
        <p class="period">PERIODE {{ date('d-m-Y', strtotime($dari)) }} s/d {{ date('d-m-Y', strtotime($sampai)) }}</p>
    </div>

    <div class="content">
        <table class="datatable">
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%;">NO</th>
                    <th class="text-center" style="width: 12%;">TANGGAL</th>
                    <th style="width: 15%;">NO BUKTI</th>
                    <th style="width: 12%;">KODE AKUN</th>
                    <th style="width: 20%;">NAMA AKUN</th>
                    <th>KETERANGAN</th>
                    <th class="text-right" style="width: 14%;">DEBET</th>
                    <th class="text-right" style="width: 14%;">KREDIT</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_debet = 0;
                    $total_kredit = 0;
                    $no = 1;
                @endphp
                @forelse ($jurnalumum as $d)
                    @php
                        $debet = $d->debet_kredit == 'D' ? $d->jumlah : 0;
                        $kredit = $d->debet_kredit == 'K' ? $d->jumlah : 0;
                        $total_debet += $debet;
                        $total_kredit += $kredit;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td class="text-center">{{ date('d-m-Y', strtotime($d->tanggal)) }}</td>
                        <td class="font-bold">{{ $d->kode_ju }}</td>
                        <td class="font-bold">{{ $d->kode_akun }}</td>
                        <td>{{ $d->nama_akun }}</td>
                        <td>{{ $d->keterangan }}</td>
                        <td class="text-right font-bold">{{ $debet > 0 ? formatAngka($debet) : '-' }}</td>
                        <td class="text-right font-bold">{{ $kredit > 0 ? formatAngka($kredit) : '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center" style="padding: 20px; color: #94a3b8;">
                            Tidak ada transaksi jurnal umum pada periode ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
            @if(count($jurnalumum) > 0)
            <tfoot>
                <tr class="total-row">
                    <td colspan="6" class="text-right uppercase">TOTAL :</td>
                    <td class="text-right font-bold">{{ formatAngka($total_debet) }}</td>
                    <td class="text-right font-bold">{{ formatAngka($total_kredit) }}</td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</body>
</html>
