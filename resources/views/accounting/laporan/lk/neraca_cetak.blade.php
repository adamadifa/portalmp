<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Neraca {{ date('Y-m-d H:i:s') }}</title>
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

        .datatable-neraca {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .datatable-neraca th {
            border-top: 2px solid #1e3a8a;
            border-bottom: 2px solid #1e3a8a;
            padding: 8px 12px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            background-color: #f8fafc;
            color: #1e3a8a;
        }

        .datatable-neraca td {
            padding: 6px 12px;
            font-size: 12px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .row-grand-total td {
            font-weight: bold !important;
            border-top: 2px solid #1e3a8a;
            border-bottom: 2px double #1e3a8a;
            padding-top: 8px;
            padding-bottom: 8px;
            font-size: 13px;
            background-color: #f8fafc;
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
        <h2 class="report-title">NERACA</h2>
        <p class="period">Per {{ date('d-m-Y', strtotime($sampai)) }}</p>
    </div>

    <div class="content">
        @php
            $totalAktiva = 0;
            $totalPasiva = 0;
        @endphp

        <table class="datatable-neraca">
            <thead>
                <tr>
                    <th style="text-align: left;">Nama Akun</th>
                    <th class="text-right" style="width: 200px;">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <!-- AKTIVA (1) -->
                <tr>
                    <td colspan="2" style="font-weight: bold; font-size: 14px; color: #1e3a8a; padding-top: 12px;">AKTIVA</td>
                </tr>
                @foreach ($neraca as $acc)
                    @if (substr($acc->kode_akun, 0, 1) === '1')
                        @php
                            $indent = ($acc->level ?? 0) * 16;
                            if ($acc->level >= 3) {
                                $totalAktiva += $acc->saldo_akhir;
                            }
                        @endphp
                        @if ($acc->level < 3 || $acc->saldo_akhir != 0)
                            <tr style="{{ $acc->level < 3 ? 'font-weight: bold; background-color: #fafafa;' : '' }}">
                                <td style="padding-left: {{ max(16, $indent) }}px;">
                                    {{ $acc->kode_akun }} - {{ $acc->nama_akun }}
                                </td>
                                <td class="text-right">
                                    {{ $acc->level >= 3 ? formatAngka($acc->saldo_akhir) : '' }}
                                </td>
                            </tr>
                        @endif
                    @endif
                @endforeach
                <tr class="row-grand-total">
                    <td>TOTAL AKTIVA</td>
                    <td class="text-right">{{ formatAngka($totalAktiva) }}</td>
                </tr>

                <!-- KEWAJIBAN & EKUITAS (2 & 3) -->
                <tr>
                    <td colspan="2" style="font-weight: bold; font-size: 14px; color: #1e3a8a; padding-top: 24px;">KEWAJIBAN & EKUITAS</td>
                </tr>
                @foreach ($neraca as $acc)
                    @if (in_array(substr($acc->kode_akun, 0, 1), ['2', '3']))
                        @php
                            $indent = ($acc->level ?? 0) * 16;
                            if ($acc->level >= 3) {
                                $totalPasiva += $acc->saldo_akhir;
                            }
                        @endphp
                        @if ($acc->level < 3 || $acc->saldo_akhir != 0)
                            <tr style="{{ $acc->level < 3 ? 'font-weight: bold; background-color: #fafafa;' : '' }}">
                                <td style="padding-left: {{ max(16, $indent) }}px;">
                                    {{ $acc->kode_akun }} - {{ $acc->nama_akun }}
                                </td>
                                <td class="text-right">
                                    {{ $acc->level >= 3 ? formatAngka($acc->saldo_akhir) : '' }}
                                </td>
                            </tr>
                        @endif
                    @endif
                @endforeach
                <tr class="row-grand-total">
                    <td>TOTAL KEWAJIBAN & EKUITAS</td>
                    <td class="text-right">{{ formatAngka($totalPasiva) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
