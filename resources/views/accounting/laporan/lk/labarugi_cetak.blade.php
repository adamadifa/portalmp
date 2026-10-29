<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laba Rugi {{ date('Y-m-d H:i:s') }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #111;
            margin: 30px;
            background-color: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header .company-name {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            color: #000;
        }

        .header .report-title {
            font-size: 22px;
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
            max-width: 800px;
        }

        .datatable-labarugi {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .datatable-labarugi th {
            border-top: 2px solid #1e3a8a;
            border-bottom: 2px solid #1e3a8a;
            padding: 8px 12px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            background-color: #f8fafc;
            color: #1e3a8a;
        }

        .datatable-labarugi td {
            padding: 6px 12px;
            font-size: 12px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .row-subtotal td {
            font-weight: bold !important;
            border-top: 1.5px solid #1e3a8a;
            border-bottom: 1px solid #1e3a8a;
            background-color: #f8fafc;
        }

        .row-grand-total td {
            font-weight: bold !important;
            border-top: 2px solid #1e3a8a;
            border-bottom: 2px double #1e3a8a;
            padding-top: 8px;
            padding-bottom: 8px;
            font-size: 13px;
            background-color: #f1f5f9;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        @media print {
            body {
                margin: 10mm;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h3 class="company-name">{{ config('app.name', 'PORTAL MP') }}</h3>
        <h2 class="report-title">LABA RUGI</h2>
        <p class="period">Periode: {{ date('d-m-Y', strtotime($dari)) }} s.d. {{ date('d-m-Y', strtotime($sampai)) }}</p>
    </div>

    <div class="content">
        @php
            $totalPendapatan = 0;
            $totalHpp = 0;
            $totalBeban = 0;
        @endphp

        <table class="datatable-labarugi">
            <thead>
                <tr>
                    <th style="text-align: left;">Nama Akun</th>
                    <th class="text-right" style="width: 200px;">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <!-- PENDAPATAN (4) -->
                <tr>
                    <td colspan="2" style="font-weight: bold; font-size: 14px; color: #1e3a8a; padding-top: 12px;">PENDAPATAN OPERASIONAL</td>
                </tr>
                @foreach ($lrAccounts as $acc)
                    @if (substr($acc->kode_akun, 0, 1) === '4')
                        @php
                            $indent = ($acc->level ?? 0) * 16;
                            $isLeaf = $acc->is_leaf ?? ($acc->level >= 3);
                            if ($isLeaf) {
                                $totalPendapatan += $acc->total;
                            }
                        @endphp
                        @if (!$isLeaf || $acc->total != 0)
                            <tr style="{{ !$isLeaf ? 'font-weight: bold; background-color: #fafafa;' : '' }}">
                                <td style="padding-left: {{ max(16, $indent) }}px;">
                                    {{ $acc->kode_akun }} - {{ $acc->nama_akun }}
                                </td>
                                <td class="text-right">
                                    {{ $isLeaf ? formatAngka($acc->total) : '' }}
                                </td>
                            </tr>
                        @endif
                    @endif
                @endforeach
                <tr class="row-subtotal">
                    <td>TOTAL PENDAPATAN</td>
                    <td class="text-right">{{ formatAngka($totalPendapatan) }}</td>
                </tr>

                <!-- HPP (5) -->
                <tr>
                    <td colspan="2" style="font-weight: bold; font-size: 14px; color: #1e3a8a; padding-top: 20px;">HARGA POKOK PENJUALAN (HPP)</td>
                </tr>
                @php
                    $totalHpp = 0;
                @endphp
                @if (isset($hppBahan))
                    <tr>
                        <td style="padding-left: 20px;">Persediaaan Awal Bahan Baku</td>
                        <td class="text-right">{{ $hppBahan['sa_bb'] != 0 ? formatAngka($hppBahan['sa_bb']) : '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 20px;">Pembelian Bahan Baku</td>
                        <td class="text-right">{{ $hppBahan['pemb_bb'] != 0 ? formatAngka($hppBahan['pemb_bb']) : '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 20px;">Persediaaan Akhir Bahan Baku</td>
                        <td class="text-right">{{ $hppBahan['ak_bb'] != 0 ? '(' . formatAngka($hppBahan['ak_bb']) . ')' : '-' }}</td>
                    </tr>
                    <tr style="font-weight: bold; background-color: #fafafa;">
                        <td style="padding-left: 20px;">Bahan Baku yang digunakan</td>
                        <td class="text-right">{{ $hppBahan['used_bb'] != 0 ? formatAngka($hppBahan['used_bb']) : '-' }}</td>
                    </tr>
                    @php $totalHpp += $hppBahan['used_bb']; @endphp

                    <tr>
                        <td style="padding-left: 20px;">Persediaan Awal Bahan Kemasan</td>
                        <td class="text-right">{{ $hppBahan['sa_bk'] != 0 ? formatAngka($hppBahan['sa_bk']) : '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 20px;">Pembelian Bahan Kemasan</td>
                        <td class="text-right">{{ $hppBahan['pemb_bk'] != 0 ? formatAngka($hppBahan['pemb_bk']) : '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 20px;">Persediaan Akhir Bahan Kemasan</td>
                        <td class="text-right">{{ $hppBahan['ak_bk'] != 0 ? '(' . formatAngka($hppBahan['ak_bk']) . ')' : '-' }}</td>
                    </tr>
                    <tr style="font-weight: bold; background-color: #fafafa;">
                        <td style="padding-left: 20px;">Bahan Kemasan yg digunakan</td>
                        <td class="text-right">{{ $hppBahan['used_bk'] != 0 ? formatAngka($hppBahan['used_bk']) : '-' }}</td>
                    </tr>
                    @php $totalHpp += $hppBahan['used_bk']; @endphp
                @endif
                @foreach ($lrAccounts as $acc)
                    @if (substr($acc->kode_akun, 0, 1) === '5' && (!isset($hppBahan) || !in_array($acc->kode_akun, ['5-11000', '5-11100', '5-11101', '5-11102', '5-12000', '5-12100', '5-12101', '5-12102', '5-12103', '5-13000', '5-13100', '5-13101', '5-13102', '5-13103'])))
                        @php
                            $indent = ($acc->level ?? 0) * 16;
                            $isLeaf = $acc->is_leaf ?? ($acc->level >= 3);
                            if ($isLeaf) {
                                $totalHpp += $acc->total;
                            }
                        @endphp
                        @if (!$isLeaf || $acc->total != 0)
                            <tr style="{{ !$isLeaf ? 'font-weight: bold; background-color: #fafafa;' : '' }}">
                                <td style="padding-left: {{ max(16, $indent) }}px;">
                                    {{ $acc->kode_akun }} - {{ $acc->nama_akun }}
                                </td>
                                <td class="text-right">
                                    {{ $isLeaf ? formatAngka($acc->total) : '' }}
                                </td>
                            </tr>
                        @endif
                    @endif
                @endforeach
                <tr class="row-subtotal">
                    <td>TOTAL HARGA POKOK PENJUALAN</td>
                    <td class="text-right">{{ formatAngka($totalHpp) }}</td>
                </tr>

                <!-- LABA KOTOR -->
                @php
                    $labaKotor = $totalPendapatan - $totalHpp;
                @endphp
                <tr class="row-subtotal" style="background-color: #e2e8f0;">
                    <td>LABA KOTOR</td>
                    <td class="text-right">{{ formatAngka($labaKotor) }}</td>
                </tr>

                <!-- BEBAN OPERASIONAL (6) -->
                <tr>
                    <td colspan="2" style="font-weight: bold; font-size: 14px; color: #1e3a8a; padding-top: 20px;">BEBAN OPERASIONAL</td>
                </tr>
                @foreach ($lrAccounts as $acc)
                    @if (substr($acc->kode_akun, 0, 1) === '6')
                        @php
                            $indent = ($acc->level ?? 0) * 16;
                            $isLeaf = $acc->is_leaf ?? ($acc->level >= 3);
                            if ($isLeaf) {
                                $totalBeban += $acc->total;
                            }
                        @endphp
                        @if (!$isLeaf || $acc->total != 0)
                            <tr style="{{ !$isLeaf ? 'font-weight: bold; background-color: #fafafa;' : '' }}">
                                <td style="padding-left: {{ max(16, $indent) }}px;">
                                    {{ $acc->kode_akun }} - {{ $acc->nama_akun }}
                                </td>
                                <td class="text-right">
                                    {{ $isLeaf ? formatAngka($acc->total) : '' }}
                                </td>
                            </tr>
                        @endif
                    @endif
                @endforeach
                <tr class="row-subtotal">
                    <td>TOTAL BEBAN OPERASIONAL</td>
                    <td class="text-right">{{ formatAngka($totalBeban) }}</td>
                </tr>

                <!-- LABA / RUGI BERSIH -->
                @php
                    $labaBersih = $labaKotor - $totalBeban;
                @endphp
                <tr class="row-grand-total">
                    <td>LABA (RUGI) BERSIH</td>
                    <td class="text-right {{ $labaBersih >= 0 ? 'text-blue-900' : 'text-red-600' }}">
                        {{ formatAngka($labaBersih) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
