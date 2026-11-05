<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laba Rugi Tahunan {{ $tahun }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
            margin: 15px;
            background-color: #fff;
            font-size: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header .company-name {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            color: #000;
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
            width: 100%;
            overflow-x: auto;
            position: relative;
        }

        .table-lr-tahunan {
            width: max-content;
            min-width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            line-height: 1.4;
        }

        .table-lr-tahunan th {
            border-top: 1.5px solid #000;
            border-bottom: 1.5px solid #000;
            padding: 5px 6px;
            font-weight: bold;
            background-color: #f1f5f9;
            text-align: center;
            white-space: nowrap;
        }

        .table-lr-tahunan td {
            padding: 2.5px 6px;
            border-bottom: 1px dotted #555;
            vertical-align: middle;
            white-space: nowrap;
        }

        /* =====================
           FREEZE COLUMN PERTAMA
           ===================== */
        .col-keterangan {
            text-align: left;
            min-width: 320px;
            max-width: 420px;
            white-space: normal;
            word-break: break-word;
            /* Sticky freeze */
            position: sticky;
            left: 0;
            z-index: 2;
            background-color: #fff;
            border-right: 2px solid #cbd5e1 !important;
        }

        /* Freeze header kolom keterangan */
        .table-lr-tahunan thead th:first-child {
            position: sticky;
            left: 0;
            z-index: 3;
            background-color: #f1f5f9;
            border-right: 2px solid #94a3b8 !important;
        }

        /* Pastikan background row tertentu tetap terlihat saat freeze */
        .row-laba-kotor .col-keterangan {
            background-color: #ffff00 !important;
        }
        .row-subtotal .col-keterangan {
            background-color: #fafafa;
        }
        .row-total-prod .col-keterangan {
            background-color: #f8fafc;
        }
        .row-hpp .col-keterangan {
            background-color: #f8fafc;
        }
        .row-grand-total .col-keterangan {
            background-color: #f1f5f9;
        }
        .header-main .col-keterangan,
        .header-sub .col-keterangan,
        .header-underline .col-keterangan,
        .account-group .col-keterangan {
            background-color: #fff;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .header-main td {
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px dotted #555;
            padding-top: 10px;
            padding-bottom: 3px;
            font-size: 10.5px;
        }

        .header-sub td {
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px dotted #555;
            padding-top: 6px;
            padding-bottom: 2px;
        }

        .header-underline td {
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            border-bottom: 1px dotted #555;
            padding-top: 6px;
            padding-bottom: 2px;
        }

        .account-group td {
            font-weight: bold;
            border-bottom: 1px dotted #555;
        }

        .row-subtotal td {
            font-weight: bold !important;
            font-style: italic;
            border-top: 1px solid #000;
            border-bottom: 1px dotted #000;
            background-color: #fafafa;
        }

        .row-total-prod td {
            font-weight: bold !important;
            font-style: italic;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            background-color: #f8fafc;
        }

        .row-hpp td {
            font-weight: bold !important;
            border-top: 1.5px solid #000;
            border-bottom: 1.5px solid #000;
            background-color: #f8fafc;
        }

        .row-laba-kotor td {
            font-weight: bold !important;
            background-color: #ffff00 !important;
            border-top: 1.5px solid #000 !important;
            border-bottom: 1.5px solid #000 !important;
            color: #000;
        }

        .row-grand-total td {
            font-weight: bold !important;
            border-top: 1.5px solid #000;
            border-bottom: 2px double #000;
            background-color: #f1f5f9;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .pl-1 { padding-left: 10px !important; }
        .pl-2 { padding-left: 20px !important; }
        .pl-sub { padding-left: 25px !important; }

        @media print {
            body {
                margin: 5px;
                font-size: 9px;
            }

            /* Non-aktifkan sticky saat print agar halaman tercetak normal */
            .col-keterangan,
            .table-lr-tahunan thead th:first-child {
                position: static !important;
                border-right: 1px solid #000 !important;
            }

            /* Paksa warna tercetak */
            .row-laba-kotor td,
            .row-laba-kotor .col-keterangan {
                background-color: #ffff00 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            /* Lebar tabel print penuh */
            .table-lr-tahunan {
                width: 100% !important;
            }

            .content {
                overflow-x: visible !important;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h4 class="company-name">{{ config('app.name', 'PORTAL MP') }}</h4>
        <h2 class="report-title">Laba Rugi Tahunan (Horizontal)</h2>
        <h4 class="period">Tahun {{ $tahun }}</h4>
    </div>

    @php
        $lrMap = $lrMap ?? $labarugi->keyBy('kode_akun');

        // Helper formatting
        $fmt = function($val) {
            if ($val === null || abs($val) < 0.001) return '-';
            if ($val < 0) return '(' . number_format(abs($val), 0, ',', '.') . ')';
            return number_format($val, 0, ',', '.');
        };

        // Monthly balance arrays
        $mVal = function($code, $m) use ($balances) {
            return $balances[$code][$m] ?? 0.0;
        };

        $yearVal = function($code) use ($balances) {
            $sum = 0;
            for ($m = 1; $m <= 12; $m++) {
                $sum += ($balances[$code][$m] ?? 0.0);
            }
            return $sum;
        };

        $nameOf = function($code, $default = '') use ($lrMap) {
            return isset($lrMap[$code]) ? $lrMap[$code]->nama_akun : $default;
        };

        // 1. PENDAPATAN (4)
        $pendapatanAccounts = $labarugi->filter(function($a) {
            return substr($a->kode_akun, 0, 1) === '4' && ($a->is_leaf ?? ($a->level >= 2));
        });

        $mTotalPendapatan = array_fill(1, 12, 0.0);
        for ($m = 1; $m <= 12; $m++) {
            foreach ($pendapatanAccounts as $acc) {
                $mTotalPendapatan[$m] += $mVal($acc->kode_akun, $m);
            }
        }
        $yTotalPendapatan = array_sum($mTotalPendapatan);

        // 2. HPP & BIAYA PRODUKSI
        // Bahan Baku
        $mSaBB = $hppBahanTahunan['bb']['sa'] ?? array_fill(1, 12, 0.0);
        $mPembBB = $hppBahanTahunan['bb']['pemb'] ?? array_fill(1, 12, 0.0);
        $mAkBB = $hppBahanTahunan['bb']['ak'] ?? array_fill(1, 12, 0.0);
        $mUsedBB = $hppBahanTahunan['bb']['used'] ?? array_fill(1, 12, 0.0);

        // Bahan Kemasan
        $mSaBK = $hppBahanTahunan['bk']['sa'] ?? array_fill(1, 12, 0.0);
        $mPembBK = $hppBahanTahunan['bk']['pemb'] ?? array_fill(1, 12, 0.0);
        $mAkBK = $hppBahanTahunan['bk']['ak'] ?? array_fill(1, 12, 0.0);
        $mUsedBK = $hppBahanTahunan['bk']['used'] ?? array_fill(1, 12, 0.0);

        // BOP (6-11100)
        $bopAccounts = $labarugi->filter(function($a) {
            return str_starts_with($a->kode_akun, '6-111') && ($a->is_leaf ?? ($a->level >= 2));
        });
        $mTotalBOP = array_fill(1, 12, 0.0);
        for ($m = 1; $m <= 12; $m++) {
            foreach ($bopAccounts as $acc) {
                $mTotalBOP[$m] += $mVal($acc->kode_akun, $m);
            }
        }

        // BPTL (6-12100)
        $bptlAccounts = $labarugi->filter(function($a) {
            return str_starts_with($a->kode_akun, '6-121') && ($a->is_leaf ?? ($a->level >= 2));
        });
        $mTotalBPTL = array_fill(1, 12, 0.0);
        for ($m = 1; $m <= 12; $m++) {
            foreach ($bptlAccounts as $acc) {
                $mTotalBPTL[$m] += $mVal($acc->kode_akun, $m);
            }
        }

        // Overhead Lainnya (6-13100)
        $overheadLainnyaAccounts = $labarugi->filter(function($a) {
            return str_starts_with($a->kode_akun, '6-131') && ($a->is_leaf ?? ($a->level >= 2));
        });
        $mTotalOverheadLainnya = array_fill(1, 12, 0.0);
        for ($m = 1; $m <= 12; $m++) {
            foreach ($overheadLainnyaAccounts as $acc) {
                $mTotalOverheadLainnya[$m] += $mVal($acc->kode_akun, $m);
            }
        }

        // Total Biaya Produksi
        $mTotalBiayaProduksi = array_fill(1, 12, 0.0);
        for ($m = 1; $m <= 12; $m++) {
            $mTotalBiayaProduksi[$m] = $mUsedBB[$m] + $mUsedBK[$m] + $mTotalBOP[$m] + $mTotalBPTL[$m] + $mTotalOverheadLainnya[$m];
        }

        // Persediaan Barang Jadi (5-12103 & 5-13103)
        $mSaBJ = $hppBahanTahunan['bj']['sa'] ?? array_fill(1, 12, 0.0);
        $mAkBJ = $hppBahanTahunan['bj']['ak'] ?? array_fill(1, 12, 0.0);

        // Total HPP & Laba Kotor
        $mTotalHPP = array_fill(1, 12, 0.0);
        $mLabaKotor = array_fill(1, 12, 0.0);
        for ($m = 1; $m <= 12; $m++) {
            $mTotalHPP[$m] = $mTotalBiayaProduksi[$m] + $mSaBJ[$m] - $mAkBJ[$m];
            $mLabaKotor[$m] = $mTotalPendapatan[$m] - $mTotalHPP[$m];
        }

        // 3. BIAYA OPERASIONAL (6-2)
        // Admin (6-21100)
        $adminAccounts = $labarugi->filter(function($a) {
            return str_starts_with($a->kode_akun, '6-211') && ($a->is_leaf ?? ($a->level >= 2));
        });
        $mTotalAdmin = array_fill(1, 12, 0.0);
        for ($m = 1; $m <= 12; $m++) {
            foreach ($adminAccounts as $acc) {
                $mTotalAdmin[$m] += $mVal($acc->kode_akun, $m);
            }
        }

        // Penyusutan & Amortisasi (6-22100)
        $penyusutanAccounts = $labarugi->filter(function($a) {
            return str_starts_with($a->kode_akun, '6-221') && ($a->is_leaf ?? ($a->level >= 2));
        });
        $mTotalPenyusutan = array_fill(1, 12, 0.0);
        for ($m = 1; $m <= 12; $m++) {
            foreach ($penyusutanAccounts as $acc) {
                $mTotalPenyusutan[$m] += $mVal($acc->kode_akun, $m);
            }
        }

        // Jasa (6-23100)
        $jasaAccounts = $labarugi->filter(function($a) {
            return str_starts_with($a->kode_akun, '6-231') && ($a->is_leaf ?? ($a->level >= 2));
        });
        $mTotalJasa = array_fill(1, 12, 0.0);
        for ($m = 1; $m <= 12; $m++) {
            foreach ($jasaAccounts as $acc) {
                $mTotalJasa[$m] += $mVal($acc->kode_akun, $m);
            }
        }

        // Impor (6-24100)
        $imporAccounts = $labarugi->filter(function($a) {
            return str_starts_with($a->kode_akun, '6-241') && ($a->is_leaf ?? ($a->level >= 2));
        });
        $mTotalImpor = array_fill(1, 12, 0.0);
        for ($m = 1; $m <= 12; $m++) {
            foreach ($imporAccounts as $acc) {
                $mTotalImpor[$m] += $mVal($acc->kode_akun, $m);
            }
        }

        // Gaji (6-25110)
        $gajiAccounts = $labarugi->filter(function($a) {
            return str_starts_with($a->kode_akun, '6-2511') && ($a->is_leaf ?? ($a->level >= 2));
        });
        $mTotalGaji = array_fill(1, 12, 0.0);
        for ($m = 1; $m <= 12; $m++) {
            foreach ($gajiAccounts as $acc) {
                $mTotalGaji[$m] += $mVal($acc->kode_akun, $m);
            }
        }

        // Utiliti, Adm, Sewa (6-25120 & 6-25130)
        $utilitiAccounts = $labarugi->filter(function($a) {
            return (str_starts_with($a->kode_akun, '6-2512') || str_starts_with($a->kode_akun, '6-2513')) && ($a->is_leaf ?? ($a->level >= 2));
        });
        $mTotalUtiliti = array_fill(1, 12, 0.0);
        for ($m = 1; $m <= 12; $m++) {
            foreach ($utilitiAccounts as $acc) {
                $mTotalUtiliti[$m] += $mVal($acc->kode_akun, $m);
            }
        }

        // Total Biaya Umum & Administrasi
        $mTotalUmumAdm = array_fill(1, 12, 0.0);
        for ($m = 1; $m <= 12; $m++) {
            $mTotalUmumAdm[$m] = $mTotalGaji[$m] + $mTotalUtiliti[$m];
        }

        // TOTAL BIAYA OPERASIONAL & LABA BERSIH
        $mTotalBiayaOperasional = array_fill(1, 12, 0.0);
        $mLabaBersih = array_fill(1, 12, 0.0);
        for ($m = 1; $m <= 12; $m++) {
            $mTotalBiayaOperasional[$m] = $mTotalAdmin[$m] + $mTotalPenyusutan[$m] + $mTotalJasa[$m] + $mTotalImpor[$m] + $mTotalUmumAdm[$m];
            $mLabaBersih[$m] = $mLabaKotor[$m] - $mTotalBiayaOperasional[$m];
        }
    @endphp

    <div class="content">
        <table class="table-lr-tahunan">
            <thead>
                <tr>
                    <th class="col-keterangan">Keterangan</th>
                    @for ($m = 1; $m <= 12; $m++)
                        <th style="width: 55px;">{{ ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'][$m - 1] }}</th>
                    @endfor
                    <th style="width: 80px;">Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- 1. PENDAPATAN -->
                @if (isset($lrMap['4-11000']))
                    <tr class="account-group">
                        <td class="col-keterangan">4-11000 &nbsp; {{ $lrMap['4-11000']->nama_akun }}</td>
                        @for ($m = 1; $m <= 12; $m++) <td></td> @endfor
                        <td></td>
                    </tr>
                @endif
                @if (isset($lrMap['4-11100']))
                    <tr class="account-group">
                        <td class="col-keterangan pl-1">4-11100 &nbsp; {{ $lrMap['4-11100']->nama_akun }}</td>
                        @for ($m = 1; $m <= 12; $m++) <td></td> @endfor
                        <td></td>
                    </tr>
                @endif
                @foreach ($pendapatanAccounts as $acc)
                    <tr>
                        <td class="col-keterangan pl-2">{{ $acc->kode_akun }} &nbsp; {{ $acc->nama_akun }}</td>
                        @for ($m = 1; $m <= 12; $m++)
                            <td class="text-right">{{ $fmt($mVal($acc->kode_akun, $m)) }}</td>
                        @endfor
                        <td class="text-right font-bold">{{ $fmt($yearVal($acc->kode_akun)) }}</td>
                    </tr>
                @endforeach
                <tr class="row-subtotal">
                    <td class="pl-sub">Jumlah Pendapatan</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right">{{ $fmt($mTotalPendapatan[$m]) }}</td>
                    @endfor
                    <td class="text-right">{{ $fmt($yTotalPendapatan) }}</td>
                </tr>

                <!-- 2. HARGA POKOK PENJUALAN -->
                <tr class="header-main">
                    <td colspan="14">HARGA POKOK PENJUALAN</td>
                </tr>

                <!-- BAHAN BAKU -->
                <tr class="header-sub">
                    <td colspan="14">BAHAN BAKU</td>
                </tr>
                <tr>
                    <td class="col-keterangan">5-12101 &nbsp; {{ $nameOf('5-12101', 'P/L Persediaan Bahan Baku') }}</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right">{{ $fmt($mSaBB[$m]) }}</td>
                    @endfor
                    <td class="text-right">{{ $fmt(array_sum($mSaBB)) }}</td>
                </tr>
                <tr>
                    <td class="col-keterangan">5-11101 &nbsp; {{ $nameOf('5-11101', 'Pembelian Bahan Baku') }}</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right">{{ $fmt($mPembBB[$m]) }}</td>
                    @endfor
                    <td class="text-right">{{ $fmt(array_sum($mPembBB)) }}</td>
                </tr>
                <tr>
                    <td class="col-keterangan">5-13101 &nbsp; {{ $nameOf('5-13101', 'P/L Persediaan Bahan Baku') }}</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right">{{ $mAkBB[$m] != 0 ? '(' . number_format($mAkBB[$m], 0, ',', '.') . ')' : '-' }}</td>
                    @endfor
                    <td class="text-right">{{ array_sum($mAkBB) != 0 ? '(' . number_format(array_sum($mAkBB), 0, ',', '.') . ')' : '-' }}</td>
                </tr>
                <tr class="row-subtotal">
                    <td class="pl-sub">Bahan Baku yang digunakan</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right">{{ $fmt($mUsedBB[$m]) }}</td>
                    @endfor
                    <td class="text-right">{{ $fmt(array_sum($mUsedBB)) }}</td>
                </tr>

                <!-- BAHAN KEMASAN -->
                <tr class="header-sub">
                    <td colspan="14">BAHAN KEMASAN</td>
                </tr>
                <tr>
                    <td class="col-keterangan">5-12102 &nbsp; {{ $nameOf('5-12102', 'P/L Persediaan Bahan Kemasan') }}</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right">{{ $fmt($mSaBK[$m]) }}</td>
                    @endfor
                    <td class="text-right">{{ $fmt(array_sum($mSaBK)) }}</td>
                </tr>
                <tr>
                    <td class="col-keterangan">5-11102 &nbsp; {{ $nameOf('5-11102', 'Pembelian Bahan Kemasan') }}</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right">{{ $fmt($mPembBK[$m]) }}</td>
                    @endfor
                    <td class="text-right">{{ $fmt(array_sum($mPembBK)) }}</td>
                </tr>
                <tr>
                    <td class="col-keterangan">5-13102 &nbsp; {{ $nameOf('5-13102', 'P/L Persediaan Bahan Kemasan') }}</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right">{{ $mAkBK[$m] != 0 ? '(' . number_format($mAkBK[$m], 0, ',', '.') . ')' : '-' }}</td>
                    @endfor
                    <td class="text-right">{{ array_sum($mAkBK) != 0 ? '(' . number_format(array_sum($mAkBK), 0, ',', '.') . ')' : '-' }}</td>
                </tr>
                <tr class="row-subtotal">
                    <td class="pl-sub">Bahan Kemasan yang digunakan</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right">{{ $fmt($mUsedBK[$m]) }}</td>
                    @endfor
                    <td class="text-right">{{ $fmt(array_sum($mUsedBK)) }}</td>
                </tr>

                <!-- BIAYA OVERHEAD PABRIK -->
                <tr class="header-underline">
                    <td colspan="14">BIAYA OVERHEAD PABRIK</td>
                </tr>
                @if (isset($lrMap['6-11100']))
                    <tr class="account-group">
                        <td class="col-keterangan">6-11100 &nbsp; {{ $lrMap['6-11100']->nama_akun }}</td>
                        @for ($m = 1; $m <= 12; $m++) <td></td> @endfor
                        <td></td>
                    </tr>
                @endif
                @foreach ($bopAccounts as $acc)
                    <tr>
                        <td class="col-keterangan pl-1">{{ $acc->kode_akun }} &nbsp; {{ $acc->nama_akun }}</td>
                        @for ($m = 1; $m <= 12; $m++)
                            <td class="text-right">{{ $fmt($mVal($acc->kode_akun, $m)) }}</td>
                        @endfor
                        <td class="text-right">{{ $fmt($yearVal($acc->kode_akun)) }}</td>
                    </tr>
                @endforeach
                <tr class="row-subtotal">
                    <td class="pl-sub">Total Biaya Overhead Pabrik</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right">{{ $fmt($mTotalBOP[$m]) }}</td>
                    @endfor
                    <td class="text-right">{{ $fmt(array_sum($mTotalBOP)) }}</td>
                </tr>

                <!-- BIAYA TIDAK LANGSUNG (BPTL) -->
                @if (isset($lrMap['6-12100']))
                    <tr class="account-group">
                        <td class="col-keterangan">6-12100 &nbsp; {{ $lrMap['6-12100']->nama_akun }}</td>
                        @for ($m = 1; $m <= 12; $m++) <td></td> @endfor
                        <td></td>
                    </tr>
                @endif
                @foreach ($bptlAccounts as $acc)
                    <tr>
                        <td class="col-keterangan pl-1">{{ $acc->kode_akun }} &nbsp; {{ $acc->nama_akun }}</td>
                        @for ($m = 1; $m <= 12; $m++)
                            <td class="text-right">{{ $fmt($mVal($acc->kode_akun, $m)) }}</td>
                        @endfor
                        <td class="text-right">{{ $fmt($yearVal($acc->kode_akun)) }}</td>
                    </tr>
                @endforeach
                <tr class="row-subtotal">
                    <td class="pl-sub">Total Biaya Produksi Tidak Langsung</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right">{{ $fmt($mTotalBPTL[$m]) }}</td>
                    @endfor
                    <td class="text-right">{{ $fmt(array_sum($mTotalBPTL)) }}</td>
                </tr>

                <!-- BIAYA OVERHEAD LAINNYA -->
                @if (isset($lrMap['6-13100']))
                    <tr class="account-group">
                        <td class="col-keterangan">6-13100 &nbsp; {{ $lrMap['6-13100']->nama_akun }}</td>
                        @for ($m = 1; $m <= 12; $m++) <td></td> @endfor
                        <td></td>
                    </tr>
                @endif
                @foreach ($overheadLainnyaAccounts as $acc)
                    <tr>
                        <td class="col-keterangan pl-1">{{ $acc->kode_akun }} &nbsp; {{ $acc->nama_akun }}</td>
                        @for ($m = 1; $m <= 12; $m++)
                            <td class="text-right">{{ $fmt($mVal($acc->kode_akun, $m)) }}</td>
                        @endfor
                        <td class="text-right">{{ $fmt($yearVal($acc->kode_akun)) }}</td>
                    </tr>
                @endforeach
                <tr class="row-subtotal">
                    <td class="pl-sub">Total Biaya Overhead Lainnya</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right">{{ $fmt($mTotalOverheadLainnya[$m]) }}</td>
                    @endfor
                    <td class="text-right">{{ $fmt(array_sum($mTotalOverheadLainnya)) }}</td>
                </tr>

                <!-- TOTAL BIAYA PRODUKSI -->
                <tr class="row-total-prod">
                    <td class="pl-sub">Total Biaya Produksi</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right">{{ $fmt($mTotalBiayaProduksi[$m]) }}</td>
                    @endfor
                    <td class="text-right">{{ $fmt(array_sum($mTotalBiayaProduksi)) }}</td>
                </tr>

                <!-- PERSEDIAAN BARANG JADI -->
                <tr>
                    <td class="col-keterangan">5-12103 &nbsp; {{ $nameOf('5-12103', 'P/L Persediaan Barang Jadi') }}</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right">{{ $fmt($mSaBJ[$m]) }}</td>
                    @endfor
                    <td class="text-right">{{ $fmt(array_sum($mSaBJ)) }}</td>
                </tr>
                <tr>
                    <td class="col-keterangan">5-13103 &nbsp; {{ $nameOf('5-13103', 'P/L Persediaan Barang Jadi') }}</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right">{{ $mAkBJ[$m] != 0 ? '(' . number_format($mAkBJ[$m], 0, ',', '.') . ')' : '-' }}</td>
                    @endfor
                    <td class="text-right">{{ array_sum($mAkBJ) != 0 ? '(' . number_format(array_sum($mAkBJ), 0, ',', '.') . ')' : '-' }}</td>
                </tr>

                <!-- TOTAL HARGA POKOK PENJUALAN (HPP) -->
                <tr class="row-hpp">
                    <td class="pl-sub">TOTAL HARGA POKOK PENJUALAN (HPP)</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right">{{ $fmt($mTotalHPP[$m]) }}</td>
                    @endfor
                    <td class="text-right">{{ $fmt(array_sum($mTotalHPP)) }}</td>
                </tr>

                <!-- LABA KOTOR (YELLOW HIGHLIGHT) -->
                <tr class="row-laba-kotor">
                    <td class="pl-sub">LABA KOTOR</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right">{{ $fmt($mLabaKotor[$m]) }}</td>
                    @endfor
                    <td class="text-right">{{ $fmt(array_sum($mLabaKotor)) }}</td>
                </tr>

                <!-- 3. BIAYA OPERASIONAL -->
                <tr class="header-main">
                    <td colspan="14">BIAYA OPERASIONAL</td>
                </tr>
                <tr class="account-group">
                    <td class="col-keterangan">6-21100 &nbsp; Beban Operasi</td>
                    @for ($m = 1; $m <= 12; $m++) <td></td> @endfor
                    <td></td>
                </tr>
                <tr class="account-group">
                    <td class="col-keterangan pl-1">6-21100 &nbsp; Biaya ADM</td>
                    @for ($m = 1; $m <= 12; $m++) <td></td> @endfor
                    <td></td>
                </tr>
                @foreach ($adminAccounts as $acc)
                    <tr>
                        <td class="col-keterangan pl-2">{{ $acc->kode_akun }} &nbsp; {{ $acc->nama_akun }}</td>
                        @for ($m = 1; $m <= 12; $m++)
                            <td class="text-right">{{ $fmt($mVal($acc->kode_akun, $m)) }}</td>
                        @endfor
                        <td class="text-right">{{ $fmt($yearVal($acc->kode_akun)) }}</td>
                    </tr>
                @endforeach
                <tr class="row-subtotal">
                    <td class="pl-sub">Total Biaya Admin</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right">{{ $fmt($mTotalAdmin[$m]) }}</td>
                    @endfor
                    <td class="text-right">{{ $fmt(array_sum($mTotalAdmin)) }}</td>
                </tr>

                <!-- BIAYA PENYUSUTAN & AMORTISASI -->
                <tr class="account-group">
                    <td class="col-keterangan">6-22100 &nbsp; BIAYA PEMASARAN UMUM</td>
                    @for ($m = 1; $m <= 12; $m++) <td></td> @endfor
                    <td></td>
                </tr>
                <tr class="account-group">
                    <td class="col-keterangan pl-1">6-22100 &nbsp; Biaya Penyusutan & Amortisasi</td>
                    @for ($m = 1; $m <= 12; $m++) <td></td> @endfor
                    <td></td>
                </tr>
                @foreach ($penyusutanAccounts as $acc)
                    <tr>
                        <td class="col-keterangan pl-2">{{ $acc->kode_akun }} &nbsp; {{ $acc->nama_akun }}</td>
                        @for ($m = 1; $m <= 12; $m++)
                            <td class="text-right">{{ $fmt($mVal($acc->kode_akun, $m)) }}</td>
                        @endfor
                        <td class="text-right">{{ $fmt($yearVal($acc->kode_akun)) }}</td>
                    </tr>
                @endforeach
                <tr class="row-subtotal">
                    <td class="pl-sub">Total Biaya Penyusutan & Amortisasi</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right">{{ $fmt($mTotalPenyusutan[$m]) }}</td>
                    @endfor
                    <td class="text-right">{{ $fmt(array_sum($mTotalPenyusutan)) }}</td>
                </tr>

                <!-- BIAYA JASA -->
                @if (isset($lrMap['6-23100']))
                    <tr class="account-group">
                        <td class="col-keterangan">6-23100 &nbsp; {{ $lrMap['6-23100']->nama_akun }}</td>
                        @for ($m = 1; $m <= 12; $m++) <td></td> @endfor
                        <td></td>
                    </tr>
                @endif
                @foreach ($jasaAccounts as $acc)
                    <tr>
                        <td class="col-keterangan pl-1">{{ $acc->kode_akun }} &nbsp; {{ $acc->nama_akun }}</td>
                        @for ($m = 1; $m <= 12; $m++)
                            <td class="text-right">{{ $fmt($mVal($acc->kode_akun, $m)) }}</td>
                        @endfor
                        <td class="text-right">{{ $fmt($yearVal($acc->kode_akun)) }}</td>
                    </tr>
                @endforeach
                <tr class="row-subtotal">
                    <td class="pl-sub">Total Biaya Jasa</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right">{{ $fmt($mTotalJasa[$m]) }}</td>
                    @endfor
                    <td class="text-right">{{ $fmt(array_sum($mTotalJasa)) }}</td>
                </tr>

                <!-- BIAYA IMPOR -->
                @if (isset($lrMap['6-24100']))
                    <tr class="account-group">
                        <td class="col-keterangan">6-24100 &nbsp; {{ $lrMap['6-24100']->nama_akun }}</td>
                        @for ($m = 1; $m <= 12; $m++) <td></td> @endfor
                        <td></td>
                    </tr>
                @endif
                @foreach ($imporAccounts as $acc)
                    <tr>
                        <td class="col-keterangan pl-1">{{ $acc->kode_akun }} &nbsp; {{ $acc->nama_akun }}</td>
                        @for ($m = 1; $m <= 12; $m++)
                            <td class="text-right">{{ $fmt($mVal($acc->kode_akun, $m)) }}</td>
                        @endfor
                        <td class="text-right">{{ $fmt($yearVal($acc->kode_akun)) }}</td>
                    </tr>
                @endforeach
                <tr class="row-subtotal">
                    <td class="pl-sub">Total Biaya Impor</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right">{{ $fmt($mTotalImpor[$m]) }}</td>
                    @endfor
                    <td class="text-right">{{ $fmt(array_sum($mTotalImpor)) }}</td>
                </tr>

                <!-- BIAYA UMUM & ADMINISTRASI -->
                @if (isset($lrMap['6-25100']))
                    <tr class="account-group">
                        <td class="col-keterangan">6-25100 &nbsp; {{ $lrMap['6-25100']->nama_akun }}</td>
                        @for ($m = 1; $m <= 12; $m++) <td></td> @endfor
                        <td></td>
                    </tr>
                @endif
                @if (isset($lrMap['6-25110']))
                    <tr class="account-group">
                        <td class="col-keterangan pl-1">6-25110 &nbsp; {{ $lrMap['6-25110']->nama_akun }}</td>
                        @for ($m = 1; $m <= 12; $m++) <td></td> @endfor
                        <td></td>
                    </tr>
                @endif
                @foreach ($gajiAccounts as $acc)
                    <tr>
                        <td class="col-keterangan pl-2">{{ $acc->kode_akun }} &nbsp; {{ $acc->nama_akun }}</td>
                        @for ($m = 1; $m <= 12; $m++)
                            <td class="text-right">{{ $fmt($mVal($acc->kode_akun, $m)) }}</td>
                        @endfor
                        <td class="text-right">{{ $fmt($yearVal($acc->kode_akun)) }}</td>
                    </tr>
                @endforeach
                <tr class="row-subtotal">
                    <td class="pl-sub">Total Biaya Gaji, Lembur</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right">{{ $fmt($mTotalGaji[$m]) }}</td>
                    @endfor
                    <td class="text-right">{{ $fmt(array_sum($mTotalGaji)) }}</td>
                </tr>

                <!-- BEBAN UTILITI, ADM, SEWA -->
                @if (isset($lrMap['6-25120']))
                    <tr class="account-group">
                        <td class="col-keterangan pl-1">6-25120 &nbsp; {{ $lrMap['6-25120']->nama_akun }}</td>
                        @for ($m = 1; $m <= 12; $m++) <td></td> @endfor
                        <td></td>
                    </tr>
                @endif
                @foreach ($utilitiAccounts as $acc)
                    <tr>
                        <td class="col-keterangan pl-2">{{ $acc->kode_akun }} &nbsp; {{ $acc->nama_akun }}</td>
                        @for ($m = 1; $m <= 12; $m++)
                            <td class="text-right">{{ $fmt($mVal($acc->kode_akun, $m)) }}</td>
                        @endfor
                        <td class="text-right">{{ $fmt($yearVal($acc->kode_akun)) }}</td>
                    </tr>
                @endforeach
                <tr class="row-subtotal">
                    <td class="pl-sub">Total Biaya Umum & Administrasi</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right">{{ $fmt($mTotalUmumAdm[$m]) }}</td>
                    @endfor
                    <td class="text-right">{{ $fmt(array_sum($mTotalUmumAdm)) }}</td>
                </tr>

                <!-- TOTAL BIAYA OPERASIONAL -->
                <tr class="row-hpp">
                    <td style="font-weight: bold; text-transform: uppercase;">TOTAL BIAYA OPERASIONAL</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right">{{ $fmt($mTotalBiayaOperasional[$m]) }}</td>
                    @endfor
                    <td class="text-right">{{ $fmt(array_sum($mTotalBiayaOperasional)) }}</td>
                </tr>

                <!-- 4. LABA (RUGI) BERSIH -->
                <tr class="row-grand-total">
                    <td>LABA (RUGI) BERSIH</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right" style="color: {{ $mLabaBersih[$m] >= 0 ? '#1e3a8a' : '#dc2626' }};">
                            {{ $fmt($mLabaBersih[$m]) }}
                        </td>
                    @endfor
                    <td class="text-right font-bold" style="color: {{ array_sum($mLabaBersih) >= 0 ? '#1e3a8a' : '#dc2626' }};">
                        {{ $fmt(array_sum($mLabaBersih)) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
