<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Buku Besar {{ date('Y-m-d H:i:s') }}</title>
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
            max-width: 100%;
        }

        .account-title {
            text-align: left;
            font-size: 14px;
            font-weight: bold;
            color: #1e3a8a;
            margin-top: 30px;
            margin-bottom: 6px;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 4px;
        }

        .datatable-ledger {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .datatable-ledger th {
            border-top: 2px solid #1e3a8a;
            border-bottom: 2px solid #1e3a8a;
            padding: 8px 10px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            background-color: #f8fafc;
            color: #1e3a8a;
        }

        .datatable-ledger td {
            padding: 6px 10px;
            font-size: 11px;
            vertical-align: middle;
            border-bottom: 1px solid #e2e8f0;
        }

        .row-saldo-awal {
            font-weight: bold;
            background-color: #f1f5f9;
        }

        .row-total {
            font-weight: bold;
            background-color: #f8fafc;
            border-top: 1.5px solid #1e3a8a;
            border-bottom: 2px double #1e3a8a;
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
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h3 class="company-name">{{ config('app.name', 'PORTAL MP') }}</h3>
        <h2 class="report-title">BUKU BESAR</h2>
        <p class="period">Periode: {{ date('d-m-Y', strtotime($dari)) }} s.d. {{ date('d-m-Y', strtotime($sampai)) }}</p>
    </div>

    <div class="content">
        @foreach ($coaList as $acc)
            @php
                $kode_akun = $acc->kode_akun;
                $prefix = substr($kode_akun, 0, 1);
                $isDebetNormal = in_array($prefix, ['1', '5', '6']);

                // Saldo awal akumulasi sampai hari sebelum $dari
                $initSaldoAwal = (float)($saldoAwalMap[$kode_akun] ?? 0);
                $runningBalance = $initSaldoAwal;
                $prevTx = $mutasiSebelum[$kode_akun] ?? null;
                if ($prevTx) {
                    $debetPrev = (float)$prevTx->total_debet_prev;
                    $kreditPrev = (float)$prevTx->total_kredit_prev;
                    if ($isDebetNormal) {
                        $runningBalance += ($debetPrev - $kreditPrev);
                    } else {
                        $runningBalance += ($kreditPrev - $debetPrev);
                    }
                }

                $txs = $mutasiPeriode[$kode_akun] ?? collect();

                $totalDebet = 0;
                $totalKredit = 0;
            @endphp

            <div class="account-title">
                {{ $acc->kode_akun }} - {{ $acc->nama_akun }}
            </div>

            <table class="datatable-ledger">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">Tanggal</th>
                        <th style="width: 130px;">No. Bukti</th>
                        <th style="width: 120px;">Sumber</th>
                        <th>Keterangan</th>
                        <th class="text-right" style="width: 110px;">Debet (Rp)</th>
                        <th class="text-right" style="width: 110px;">Kredit (Rp)</th>
                        <th class="text-right" style="width: 130px;">Saldo (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Baris Saldo Awal -->
                    <tr class="row-saldo-awal">
                        <td class="text-center">{{ date('d-m-Y', strtotime($dari)) }}</td>
                        <td>-</td>
                        <td>SALDO AWAL</td>
                        <td>Saldo Awal Periode</td>
                        <td class="text-right">-</td>
                        <td class="text-right">-</td>
                        <td class="text-right font-bold">{{ formatAngka($runningBalance) }}</td>
                    </tr>

                    <!-- Baris Mutasi Transaksi -->
                    @forelse ($txs as $tx)
                        @php
                            $debet = (float) $tx->jml_debet;
                            $kredit = (float) $tx->jml_kredit;
                            $totalDebet += $debet;
                            $totalKredit += $kredit;

                            if ($isDebetNormal) {
                                $runningBalance += ($debet - $kredit);
                            } else {
                                $runningBalance += ($kredit - $debet);
                            }
                        @endphp
                        <tr>
                            <td class="text-center">{{ date('d-m-Y', strtotime($tx->tanggal)) }}</td>
                            <td>{{ $tx->no_bukti }}</td>
                            <td>{{ $tx->sumber }}</td>
                            <td>{{ $tx->keterangan }}</td>
                            <td class="text-right">{{ $debet > 0 ? formatAngka($debet) : '-' }}</td>
                            <td class="text-right">{{ $kredit > 0 ? formatAngka($kredit) : '-' }}</td>
                            <td class="text-right font-medium">{{ formatAngka($runningBalance) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center" style="color: #94a3b8; font-style: italic; padding: 8px;">Tidak ada transaksi pada periode ini</td>
                        </tr>
                    @endforelse

                    <!-- Baris Total & Saldo Akhir -->
                    <tr class="row-total">
                        <td colspan="4" class="text-right font-bold">TOTAL MUTASI & SALDO AKHIR</td>
                        <td class="text-right font-bold">{{ formatAngka($totalDebet) }}</td>
                        <td class="text-right font-bold">{{ formatAngka($totalKredit) }}</td>
                        <td class="text-right font-bold text-blue-900">{{ formatAngka($runningBalance) }}</td>
                    </tr>
                </tbody>
            </table>
        @endforeach
    </div>
</body>
</html>
