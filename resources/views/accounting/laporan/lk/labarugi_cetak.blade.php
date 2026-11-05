<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laba Rugi {{ date('Y-m-d H:i:s') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000;
            margin: 20px;
            background-color: #fff;
            font-size: 11px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header .company-name {
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            color: #111;
        }

        .header .report-title {
            font-size: 18px;
            font-weight: bold;
            margin: 4px 0;
            color: #1e3a8a;
        }

        .header .period {
            font-size: 12px;
            margin: 2px 0 0 0;
            color: #333;
            font-weight: bold;
        }

        .content {
            margin: 0 auto;
            max-width: 850px;
        }

        .table-lr {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            line-height: 1.45;
        }

        .table-lr th {
            border-top: 1.5px solid #000;
            border-bottom: 1.5px solid #000;
            padding: 5px 6px;
            font-weight: bold;
            background-color: #f8fafc;
            text-align: left;
        }

        .table-lr td {
            padding: 3px 6px;
            border-bottom: 1px dotted #999;
            vertical-align: middle;
        }

        .col-kode {
            width: 90px;
            font-family: Arial, sans-serif;
            white-space: nowrap;
        }

        .col-nama {
            /* flex width */
        }

        .col-jumlah {
            width: 150px;
            text-align: right;
            white-space: nowrap;
        }

        .row-section-header td {
            font-weight: bold;
            text-transform: uppercase;
            border-top: 1.5px solid #000;
            border-bottom: 1px solid #000;
            background-color: #f1f5f9;
            padding-top: 6px;
            padding-bottom: 6px;
            font-size: 11.5px;
        }

        .row-sub-header td {
            font-weight: bold;
            border-bottom: 1px dotted #999;
            padding-top: 5px;
            padding-bottom: 3px;
        }

        .row-subtotal td {
            font-weight: bold;
            font-style: italic;
            border-top: 1px solid #000;
            border-bottom: 1px dotted #000;
            background-color: #fafafa;
        }

        .row-total td {
            font-weight: bold;
            border-top: 1.5px solid #000;
            border-bottom: 1.5px solid #000;
            background-color: #f8fafc;
        }

        .row-laba-kotor td {
            font-weight: bold;
            background-color: #ffff00 !important;
            border-top: 1.5px solid #000 !important;
            border-bottom: 1.5px solid #000 !important;
            font-size: 12px;
            color: #000;
        }

        .row-grand-total td {
            font-weight: bold;
            border-top: 1.5px solid #000;
            border-bottom: 2px double #000;
            background-color: #f1f5f9;
            padding-top: 6px;
            padding-bottom: 6px;
            font-size: 12px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .pl-1 { padding-left: 14px !important; }
        .pl-2 { padding-left: 28px !important; }
        .pl-3 { padding-left: 42px !important; }

        @media print {
            body {
                margin: 5mm;
                font-size: 10px;
            }
            .content {
                max-width: 100%;
            }
            .row-laba-kotor td {
                background-color: #ffff00 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
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
            $lrMap = $lrMap ?? $lrAccounts->keyBy('kode_akun');

            // Format helper
            $fmt = function($val) {
                if ($val == 0) return '-';
                if ($val < 0) return '(' . number_format(abs($val), 0, ',', '.') . ')';
                return number_format($val, 0, ',', '.');
            };

            // Get total value helper
            $valOf = function($code) use ($lrMap) {
                return isset($lrMap[$code]) ? (float)$lrMap[$code]->total : 0.0;
            };

            // Get account name helper
            $nameOf = function($code, $default = '') use ($lrMap) {
                return isset($lrMap[$code]) ? $lrMap[$code]->nama_akun : $default;
            };

            // ==========================================
            // 1. PENDAPATAN
            // ==========================================
            $pendapatanAccounts = $lrAccounts->filter(function($a) {
                return substr($a->kode_akun, 0, 1) === '4';
            });
            $totalPendapatan = $pendapatanAccounts->where('is_leaf', true)->sum('total');

            // ==========================================
            // 2. HPP & BIAYA PRODUKSI
            // ==========================================
            $sa_bb   = $hppBahan['sa_bb'] ?? 0;
            $pemb_bb = $hppBahan['pemb_bb'] ?? 0;
            $ak_bb   = $hppBahan['ak_bb'] ?? 0;
            $used_bb = $hppBahan['used_bb'] ?? ($sa_bb + $pemb_bb - $ak_bb);

            $sa_bk   = $hppBahan['sa_bk'] ?? 0;
            $pemb_bk = $hppBahan['pemb_bk'] ?? 0;
            $ak_bk   = $hppBahan['ak_bk'] ?? 0;
            $used_bk = $hppBahan['used_bk'] ?? ($sa_bk + $pemb_bk - $ak_bk);

            // BOP (6-11100)
            $bopAccounts = $lrAccounts->filter(function($a) {
                return str_starts_with($a->kode_akun, '6-111') && $a->is_leaf;
            });
            $totalBOP = $bopAccounts->sum('total');

            // BPTL (6-12100)
            $bptlAccounts = $lrAccounts->filter(function($a) {
                return str_starts_with($a->kode_akun, '6-121') && $a->is_leaf;
            });
            $totalBPTL = $bptlAccounts->sum('total');

            // Overhead Lainnya (6-13100)
            $overheadLainnyaAccounts = $lrAccounts->filter(function($a) {
                return str_starts_with($a->kode_akun, '6-131') && $a->is_leaf;
            });
            $totalOverheadLainnya = $overheadLainnyaAccounts->sum('total');

            // Total Biaya Produksi
            $totalBiayaProduksi = $used_bb + $used_bk + $totalBOP + $totalBPTL + $totalOverheadLainnya;

            // Persediaan Barang Jadi (5-12103 & 5-13103)
            $sa_bj = $hppBahan['sa_bj'] ?? $valOf('5-12103');
            $ak_bj = $hppBahan['ak_bj'] ?? $valOf('5-13103');

            // HPP & Laba Kotor
            $totalHpp = $totalBiayaProduksi + $sa_bj - $ak_bj;
            $labaKotor = $totalPendapatan - $totalHpp;

            // ==========================================
            // 3. BIAYA OPERASIONAL (6-2)
            // ==========================================
            // Admin (6-21100)
            $adminAccounts = $lrAccounts->filter(function($a) {
                return str_starts_with($a->kode_akun, '6-211') && $a->is_leaf;
            });
            $totalAdmin = $adminAccounts->sum('total');

            // Penyusutan & Amortisasi (6-22100)
            $penyusutanAccounts = $lrAccounts->filter(function($a) {
                return str_starts_with($a->kode_akun, '6-221') && $a->is_leaf;
            });
            $totalPenyusutan = $penyusutanAccounts->sum('total');

            // Jasa (6-23100)
            $jasaAccounts = $lrAccounts->filter(function($a) {
                return str_starts_with($a->kode_akun, '6-231') && $a->is_leaf;
            });
            $totalJasa = $jasaAccounts->sum('total');

            // Impor (6-24100)
            $imporAccounts = $lrAccounts->filter(function($a) {
                return str_starts_with($a->kode_akun, '6-241') && $a->is_leaf;
            });
            $totalImpor = $imporAccounts->sum('total');

            // Gaji (6-25110)
            $gajiAccounts = $lrAccounts->filter(function($a) {
                return str_starts_with($a->kode_akun, '6-2511') && $a->is_leaf;
            });
            $totalGaji = $gajiAccounts->sum('total');

            // Utiliti, Adm, Sewa (6-25120 & 6-25130)
            $utilitiAccounts = $lrAccounts->filter(function($a) {
                return (str_starts_with($a->kode_akun, '6-2512') || str_starts_with($a->kode_akun, '6-2513')) && $a->is_leaf;
            });
            $totalUtiliti = $utilitiAccounts->sum('total');

            // Total Biaya Umum & Administrasi
            $totalUmumAdm = $totalGaji + $totalUtiliti;

            // Sisa Biaya Operasional lain (jika ada)
            $handledPrefixes = ['6-211', '6-221', '6-231', '6-241', '6-2511', '6-2512', '6-2513'];
            $otherOperasional = $lrAccounts->filter(function($a) use ($handledPrefixes) {
                if (!str_starts_with($a->kode_akun, '6-2') || !$a->is_leaf) return false;
                foreach ($handledPrefixes as $p) {
                    if (str_starts_with($a->kode_akun, $p)) return false;
                }
                return true;
            });
            $totalOtherOperasional = $otherOperasional->sum('total');

            // TOTAL BIAYA OPERASIONAL
            $totalBiayaOperasional = $totalAdmin + $totalPenyusutan + $totalJasa + $totalImpor + $totalUmumAdm + $totalOtherOperasional;

            // ==========================================
            // 4. LABA (RUGI) BERSIH
            // ==========================================
            $labaBersih = $labaKotor - $totalBiayaOperasional;
        @endphp

        <table class="table-lr">
            <thead>
                <tr>
                    <th class="col-kode">Kode Akun</th>
                    <th class="col-nama">Keterangan</th>
                    <th class="col-jumlah">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <!-- 1. PENDAPATAN -->
                @if (isset($lrMap['4-11000']))
                    <tr class="row-sub-header">
                        <td class="col-kode">4-11000</td>
                        <td class="col-nama">{{ $lrMap['4-11000']->nama_akun }}</td>
                        <td class="col-jumlah"></td>
                    </tr>
                @endif
                @if (isset($lrMap['4-11100']))
                    <tr class="row-sub-header">
                        <td class="col-kode">4-11100</td>
                        <td class="col-nama pl-1">{{ $lrMap['4-11100']->nama_akun }}</td>
                        <td class="col-jumlah"></td>
                    </tr>
                @endif
                @foreach ($pendapatanAccounts as $acc)
                    @if ($acc->is_leaf)
                        <tr>
                            <td class="col-kode">{{ $acc->kode_akun }}</td>
                            <td class="col-nama pl-2">{{ $acc->nama_akun }}</td>
                            <td class="col-jumlah">{{ $fmt($acc->total) }}</td>
                        </tr>
                    @endif
                @endforeach
                <tr class="row-subtotal">
                    <td></td>
                    <td class="pl-2">Jumlah Pendapatan</td>
                    <td class="col-jumlah">{{ $fmt($totalPendapatan) }}</td>
                </tr>

                <!-- 2. HARGA POKOK PENJUALAN -->
                <tr class="row-section-header">
                    <td colspan="3">HARGA POKOK PENJUALAN</td>
                </tr>

                <!-- BAHAN BAKU -->
                <tr class="row-sub-header">
                    <td></td>
                    <td colspan="2">BAHAN BAKU</td>
                </tr>
                <tr>
                    <td class="col-kode">5-12101</td>
                    <td class="col-nama pl-1">{{ $nameOf('5-12101', 'P/L Persediaan Bahan Baku (Awal)') }}</td>
                    <td class="col-jumlah">{{ $fmt($sa_bb) }}</td>
                </tr>
                <tr>
                    <td class="col-kode">5-11101</td>
                    <td class="col-nama pl-1">{{ $nameOf('5-11101', 'Pembelian Bahan Baku') }}</td>
                    <td class="col-jumlah">{{ $fmt($pemb_bb) }}</td>
                </tr>
                <tr>
                    <td class="col-kode">5-13101</td>
                    <td class="col-nama pl-1">{{ $nameOf('5-13101', 'P/L Persediaan Bahan Baku (Akhir)') }}</td>
                    <td class="col-jumlah">{{ $ak_bb != 0 ? '(' . number_format($ak_bb, 0, ',', '.') . ')' : '-' }}</td>
                </tr>
                <tr class="row-subtotal">
                    <td></td>
                    <td class="pl-1">Bahan Baku yang digunakan</td>
                    <td class="col-jumlah">{{ $fmt($used_bb) }}</td>
                </tr>

                <!-- BAHAN KEMASAN -->
                <tr class="row-sub-header">
                    <td></td>
                    <td colspan="2">BAHAN KEMASAN</td>
                </tr>
                <tr>
                    <td class="col-kode">5-12102</td>
                    <td class="col-nama pl-1">{{ $nameOf('5-12102', 'P/L Persediaan Bahan Kemasan (Awal)') }}</td>
                    <td class="col-jumlah">{{ $fmt($sa_bk) }}</td>
                </tr>
                <tr>
                    <td class="col-kode">5-11102</td>
                    <td class="col-nama pl-1">{{ $nameOf('5-11102', 'Pembelian Bahan Kemasan') }}</td>
                    <td class="col-jumlah">{{ $fmt($pemb_bk) }}</td>
                </tr>
                <tr>
                    <td class="col-kode">5-13102</td>
                    <td class="col-nama pl-1">{{ $nameOf('5-13102', 'P/L Persediaan Bahan Kemasan (Akhir)') }}</td>
                    <td class="col-jumlah">{{ $ak_bk != 0 ? '(' . number_format($ak_bk, 0, ',', '.') . ')' : '-' }}</td>
                </tr>
                <tr class="row-subtotal">
                    <td></td>
                    <td class="pl-1">Bahan Kemasan yang digunakan</td>
                    <td class="col-jumlah">{{ $fmt($used_bk) }}</td>
                </tr>

                <!-- BIAYA OVERHEAD PABRIK -->
                <tr class="row-section-header">
                    <td colspan="3">BIAYA OVERHEAD PABRIK</td>
                </tr>
                @if (isset($lrMap['6-11100']))
                    <tr class="row-sub-header">
                        <td class="col-kode">6-11100</td>
                        <td class="col-nama">{{ $lrMap['6-11100']->nama_akun }}</td>
                        <td class="col-jumlah"></td>
                    </tr>
                @endif
                @foreach ($bopAccounts as $acc)
                    <tr>
                        <td class="col-kode">{{ $acc->kode_akun }}</td>
                        <td class="col-nama pl-1">{{ $acc->nama_akun }}</td>
                        <td class="col-jumlah">{{ $fmt($acc->total) }}</td>
                    </tr>
                @endforeach
                <tr class="row-subtotal">
                    <td></td>
                    <td class="pl-1">Total Biaya Overhead Pabrik</td>
                    <td class="col-jumlah">{{ $fmt($totalBOP) }}</td>
                </tr>

                <!-- BIAYA TIDAK LANGSUNG (BPTL) -->
                @if (isset($lrMap['6-12100']))
                    <tr class="row-sub-header">
                        <td class="col-kode">6-12100</td>
                        <td class="col-nama">{{ $lrMap['6-12100']->nama_akun }}</td>
                        <td class="col-jumlah"></td>
                    </tr>
                @endif
                @foreach ($bptlAccounts as $acc)
                    <tr>
                        <td class="col-kode">{{ $acc->kode_akun }}</td>
                        <td class="col-nama pl-1">{{ $acc->nama_akun }}</td>
                        <td class="col-jumlah">{{ $fmt($acc->total) }}</td>
                    </tr>
                @endforeach
                <tr class="row-subtotal">
                    <td></td>
                    <td class="pl-1">Total Biaya Produksi Tidak Langsung</td>
                    <td class="col-jumlah">{{ $fmt($totalBPTL) }}</td>
                </tr>

                <!-- BIAYA OVERHEAD LAINNYA -->
                @if (isset($lrMap['6-13100']))
                    <tr class="row-sub-header">
                        <td class="col-kode">6-13100</td>
                        <td class="col-nama">{{ $lrMap['6-13100']->nama_akun }}</td>
                        <td class="col-jumlah"></td>
                    </tr>
                @endif
                @foreach ($overheadLainnyaAccounts as $acc)
                    <tr>
                        <td class="col-kode">{{ $acc->kode_akun }}</td>
                        <td class="col-nama pl-1">{{ $acc->nama_akun }}</td>
                        <td class="col-jumlah">{{ $fmt($acc->total) }}</td>
                    </tr>
                @endforeach
                <tr class="row-subtotal">
                    <td></td>
                    <td class="pl-1">Total Biaya Overhead Lainnya</td>
                    <td class="col-jumlah">{{ $fmt($totalOverheadLainnya) }}</td>
                </tr>

                <!-- TOTAL BIAYA PRODUKSI -->
                <tr class="row-subtotal" style="background-color: #f1f5f9;">
                    <td></td>
                    <td style="font-weight: bold; font-style: normal;">Total Biaya Produksi</td>
                    <td class="col-jumlah" style="font-weight: bold; font-style: normal;">{{ $fmt($totalBiayaProduksi) }}</td>
                </tr>

                <!-- PERSEDIAAN BARANG JADI & HPP -->
                <tr>
                    <td class="col-kode">5-12103</td>
                    <td class="col-nama">{{ $nameOf('5-12103', 'P/L Persediaan Barang Jadi (Awal)') }}</td>
                    <td class="col-jumlah">{{ $fmt($sa_bj) }}</td>
                </tr>
                <tr>
                    <td class="col-kode">5-13103</td>
                    <td class="col-nama">{{ $nameOf('5-13103', 'P/L Persediaan Barang Jadi (Akhir)') }}</td>
                    <td class="col-jumlah">{{ $ak_bj != 0 ? '(' . number_format($ak_bj, 0, ',', '.') . ')' : '-' }}</td>
                </tr>
                <tr class="row-total">
                    <td></td>
                    <td style="font-weight: bold;">HPP</td>
                    <td class="col-jumlah" style="font-weight: bold;">{{ $fmt($totalHpp) }}</td>
                </tr>

                <!-- LABA KOTOR (YELLOW HIGHLIGHT) -->
                <tr class="row-laba-kotor">
                    <td></td>
                    <td>LABA KOTOR</td>
                    <td class="col-jumlah">{{ $fmt($labaKotor) }}</td>
                </tr>

                <!-- 3. BIAYA OPERASIONAL -->
                <tr class="row-section-header">
                    <td colspan="3">BIAYA OPERASIONAL</td>
                </tr>
                <tr class="row-sub-header">
                    <td class="col-kode">6-21100</td>
                    <td class="col-nama">Beban Operasi</td>
                    <td class="col-jumlah"></td>
                </tr>
                <tr class="row-sub-header">
                    <td class="col-kode">6-21100</td>
                    <td class="col-nama pl-1">Biaya ADM</td>
                    <td class="col-jumlah"></td>
                </tr>
                @foreach ($adminAccounts as $acc)
                    <tr>
                        <td class="col-kode">{{ $acc->kode_akun }}</td>
                        <td class="col-nama pl-2">{{ $acc->nama_akun }}</td>
                        <td class="col-jumlah">{{ $fmt($acc->total) }}</td>
                    </tr>
                @endforeach
                <tr class="row-subtotal">
                    <td></td>
                    <td class="pl-1">Total Biaya Admin</td>
                    <td class="col-jumlah">{{ $fmt($totalAdmin) }}</td>
                </tr>

                <!-- BIAYA PENYUSUTAN & AMORTISASI -->
                <tr class="row-sub-header">
                    <td class="col-kode">6-22100</td>
                    <td class="col-nama">BIAYA PEMASARAN UMUM</td>
                    <td class="col-jumlah"></td>
                </tr>
                <tr class="row-sub-header">
                    <td class="col-kode">6-22100</td>
                    <td class="col-nama pl-1">Biaya Penyusutan & Amortisasi</td>
                    <td class="col-jumlah"></td>
                </tr>
                @foreach ($penyusutanAccounts as $acc)
                    <tr>
                        <td class="col-kode">{{ $acc->kode_akun }}</td>
                        <td class="col-nama pl-2">{{ $acc->nama_akun }}</td>
                        <td class="col-jumlah">{{ $fmt($acc->total) }}</td>
                    </tr>
                @endforeach
                <tr class="row-subtotal">
                    <td></td>
                    <td class="pl-1">Total Biaya Penyusutan & Amortisasi</td>
                    <td class="col-jumlah">{{ $fmt($totalPenyusutan) }}</td>
                </tr>

                <!-- BIAYA JASA -->
                @if (isset($lrMap['6-23100']))
                    <tr class="row-sub-header">
                        <td class="col-kode">6-23100</td>
                        <td class="col-nama">{{ $lrMap['6-23100']->nama_akun }}</td>
                        <td class="col-jumlah"></td>
                    </tr>
                @endif
                @foreach ($jasaAccounts as $acc)
                    <tr>
                        <td class="col-kode">{{ $acc->kode_akun }}</td>
                        <td class="col-nama pl-1">{{ $acc->nama_akun }}</td>
                        <td class="col-jumlah">{{ $fmt($acc->total) }}</td>
                    </tr>
                @endforeach
                <tr class="row-subtotal">
                    <td></td>
                    <td class="pl-1">Total Biaya Jasa</td>
                    <td class="col-jumlah">{{ $fmt($totalJasa) }}</td>
                </tr>

                <!-- BIAYA IMPOR -->
                @if (isset($lrMap['6-24100']))
                    <tr class="row-sub-header">
                        <td class="col-kode">6-24100</td>
                        <td class="col-nama">{{ $lrMap['6-24100']->nama_akun }}</td>
                        <td class="col-jumlah"></td>
                    </tr>
                @endif
                @foreach ($imporAccounts as $acc)
                    <tr>
                        <td class="col-kode">{{ $acc->kode_akun }}</td>
                        <td class="col-nama pl-1">{{ $acc->nama_akun }}</td>
                        <td class="col-jumlah">{{ $fmt($acc->total) }}</td>
                    </tr>
                @endforeach
                <tr class="row-subtotal">
                    <td></td>
                    <td class="pl-1">Total Biaya Impor</td>
                    <td class="col-jumlah">{{ $fmt($totalImpor) }}</td>
                </tr>

                <!-- BIAYA UMUM & ADMINISTRASI -->
                @if (isset($lrMap['6-25100']))
                    <tr class="row-sub-header">
                        <td class="col-kode">6-25100</td>
                        <td class="col-nama">{{ $lrMap['6-25100']->nama_akun }}</td>
                        <td class="col-jumlah"></td>
                    </tr>
                @endif
                @if (isset($lrMap['6-25110']))
                    <tr class="row-sub-header">
                        <td class="col-kode">6-25110</td>
                        <td class="col-nama pl-1">{{ $lrMap['6-25110']->nama_akun }}</td>
                        <td class="col-jumlah"></td>
                    </tr>
                @endif
                @foreach ($gajiAccounts as $acc)
                    <tr>
                        <td class="col-kode">{{ $acc->kode_akun }}</td>
                        <td class="col-nama pl-2">{{ $acc->nama_akun }}</td>
                        <td class="col-jumlah">{{ $fmt($acc->total) }}</td>
                    </tr>
                @endforeach
                <tr class="row-subtotal">
                    <td></td>
                    <td class="pl-1">Total Biaya Gaji, Lembur</td>
                    <td class="col-jumlah">{{ $fmt($totalGaji) }}</td>
                </tr>

                @if (isset($lrMap['6-25120']))
                    <tr class="row-sub-header">
                        <td class="col-kode">6-25120</td>
                        <td class="col-nama pl-1">{{ $lrMap['6-25120']->nama_akun }}</td>
                        <td class="col-jumlah"></td>
                    </tr>
                @endif
                @foreach ($utilitiAccounts as $acc)
                    <tr>
                        <td class="col-kode">{{ $acc->kode_akun }}</td>
                        <td class="col-nama pl-2">{{ $acc->nama_akun }}</td>
                        <td class="col-jumlah">{{ $fmt($acc->total) }}</td>
                    </tr>
                @endforeach
                @foreach ($otherOperasional as $acc)
                    <tr>
                        <td class="col-kode">{{ $acc->kode_akun }}</td>
                        <td class="col-nama pl-2">{{ $acc->nama_akun }}</td>
                        <td class="col-jumlah">{{ $fmt($acc->total) }}</td>
                    </tr>
                @endforeach
                <tr class="row-subtotal">
                    <td></td>
                    <td class="pl-1">Total Biaya Umum & Administrasi</td>
                    <td class="col-jumlah">{{ $fmt($totalUmumAdm + $totalOtherOperasional) }}</td>
                </tr>

                <!-- TOTAL BIAYA OPERASIONAL -->
                <tr class="row-total">
                    <td></td>
                    <td style="font-weight: bold; text-transform: uppercase;">TOTAL BIAYA OPERASIONAL</td>
                    <td class="col-jumlah" style="font-weight: bold;">{{ $fmt($totalBiayaOperasional) }}</td>
                </tr>

                <!-- 4. LABA (RUGI) BERSIH -->
                <tr class="row-grand-total">
                    <td></td>
                    <td>LABA (RUGI) BERSIH</td>
                    <td class="col-jumlah" style="color: {{ $labaBersih >= 0 ? '#1e3a8a' : '#dc2626' }};">
                        {{ $fmt($labaBersih) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
