<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laba Rugi Tahunan {{ $tahun }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #111;
            margin: 15px;
            background-color: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
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
            color: #900000;
        }

        .header .period {
            font-size: 13px;
            margin: 5px 0 0 0;
            color: #333;
            font-weight: bold;
        }

        .content {
            margin: 0 auto;
            width: 100%;
            overflow-x: auto;
        }

        .datatable9 {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .datatable9 th {
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            padding: 6px 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
        }

        .datatable9 td {
            padding: 4px 4px;
            font-size: 10.5px;
            vertical-align: middle;
            height: 18px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* Subtotal/Total Rows */
        .subtotal-row td {
            font-weight: bold !important;
            border-top: 1px solid #000;
            border-bottom: 1.5px solid #000;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .subtotal-row-grand td {
            font-weight: bold !important;
            border-top: 1.5px solid #000;
            border-bottom: 2px double #000;
            padding-top: 6px;
            padding-bottom: 6px;
            font-size: 11px;
        }

        .section-header td {
            font-weight: bold;
            font-size: 11px;
            padding-top: 8px;
        }

        @media print {
            body {
                margin: 5px;
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
        // Group coas by parent code (sub_akun)
        $nodesByParent = [];
        foreach ($labarugi as $coa) {
            $node_monthly_balances = [];
            for ($m = 1; $m <= 12; $m++) {
                $node_monthly_balances[$m] = $balances[$coa->kode_akun][$m] ?? 0.0;
            }
            $parentKey = empty($coa->sub_akun) ? '0' : $coa->sub_akun;
            $nodesByParent[$parentKey][] = [
                'kode_akun' => $coa->kode_akun,
                'nama_akun' => $coa->nama_akun,
                'sub_akun' => $coa->sub_akun,
                'level' => $coa->level,
                'monthly_balances' => $node_monthly_balances,
                'children' => []
            ];
        }

        // Recursive tree builder
        if (!function_exists('buildTreeLRTahunan')) {
            function buildTreeLRTahunan(&$nodesByParent, $parentId = '0')
            {
                $branch = [];
                if (isset($nodesByParent[$parentId])) {
                    foreach ($nodesByParent[$parentId] as $node) {
                        $node['children'] = buildTreeLRTahunan($nodesByParent, $node['kode_akun']);
                        $branch[] = $node;
                    }
                }
                return $branch;
            }
        }

        // Build the top level trees
        $tree = buildTreeLRTahunan($nodesByParent, '0');

        // Separate Pendapatan (4), HPP / Pembelian (5), and Biaya / Beban (6)
        $pendapatanTree = [];
        $hppTree = [];
        $bebanTree = [];

        foreach ($tree as $rootNode) {
            $prefix = substr($rootNode['kode_akun'], 0, 1);
            if ($prefix == '4') {
                $pendapatanTree[] = $rootNode;
            } elseif ($prefix == '5') {
                $hppTree[] = $rootNode;
            } elseif ($prefix == '6') {
                $bebanTree[] = $rootNode;
            }
        }

        // Recursive balance calculator
        if (!function_exists('calculateTreeBalancesLRTahunan')) {
            function calculateTreeBalancesLRTahunan(&$nodes)
            {
                $monthly_totals = array_fill(1, 12, 0.0);
                foreach ($nodes as &$node) {
                    if (count($node['children']) > 0) {
                        $node['monthly_balances'] = calculateTreeBalancesLRTahunan($node['children']);
                    }
                    for ($m = 1; $m <= 12; $m++) {
                        $monthly_totals[$m] += $node['monthly_balances'][$m] ?? 0.0;
                    }
                }
                return $monthly_totals;
            }
        }

        // Calculate recursive balances
        calculateTreeBalancesLRTahunan($pendapatanTree);
        calculateTreeBalancesLRTahunan($hppTree);
        calculateTreeBalancesLRTahunan($bebanTree);

        // Helper function to format negative values with parentheses
        if (!function_exists('formatLRTahunanValue')) {
            function formatLRTahunanValue($value, $hideIfZero = false) {
                if ($value === null || $value == 0) {
                    return $hideIfZero ? '' : '-';
                }
                if ($value < 0) {
                    return '(' . (function_exists('formatAngkaDesimal') ? formatAngkaDesimal(abs($value)) : number_format(abs($value), 2, ',', '.')) . ')';
                }
                return function_exists('formatAngkaDesimal') ? formatAngkaDesimal($value) : number_format($value, 2, ',', '.');
            }
        }

        // Recursive tree rendering function
        if (!function_exists('renderTreeLRTahunan')) {
            function renderTreeLRTahunan($nodes, $level = 0)
            {
                foreach ($nodes as $node) {
                    $indent = $level * 12;
                    $hasChildren = count($node['children']) > 0;

                    // Check if node has non-zero values in any month
                    $hasAnyValue = false;
                    for ($m = 1; $m <= 12; $m++) {
                        if (abs($node['monthly_balances'][$m] ?? 0) > 0.001) {
                            $hasAnyValue = true;
                            break;
                        }
                    }

                    if ($hasChildren) {
                        // Category Header (Root or Sub-Root)
                        echo '<tr class="' . ($level == 0 ? 'section-header' : '') . '">';
                        echo '<td style="padding-left: ' . $indent . 'px; font-weight: bold;">' . $node['kode_akun'] . ' &nbsp; ' . $node['nama_akun'] . '</td>';
                        for ($m = 1; $m <= 12; $m++) {
                            echo '<td></td>';
                        }
                        echo '</tr>';

                        // Render children recursively
                        renderTreeLRTahunan($node['children'], $level + 1);

                        // Render Subtotal/Jumlah row
                        echo '<tr class="subtotal-row">';
                        echo '<td style="padding-left: ' . $indent . 'px;">Jumlah ' . $node['nama_akun'] . '</td>';
                        for ($m = 1; $m <= 12; $m++) {
                            echo '<td class="text-right">' . formatLRTahunanValue($node['monthly_balances'][$m] ?? 0) . '</td>';
                        }
                        echo '</tr>';
                    } else {
                        // Leaf account - show even if zero or only if non-zero
                        echo '<tr>';
                        echo '<td style="padding-left: ' . $indent . 'px;">' . $node['kode_akun'] . ' &nbsp; ' . $node['nama_akun'] . '</td>';
                        for ($m = 1; $m <= 12; $m++) {
                            echo '<td class="text-right">' . formatLRTahunanValue($node['monthly_balances'][$m] ?? 0) . '</td>';
                        }
                        echo '</tr>';
                    }
                }
            }
        }
    @endphp

    <div class="content">
        <table class="datatable9">
            <thead>
                <tr>
                    <th style="text-align: left; width: 16%;">Deskripsi Akun</th>
                    <th style="width: 7%;">Jan</th>
                    <th style="width: 7%;">Feb</th>
                    <th style="width: 7%;">Mar</th>
                    <th style="width: 7%;">Apr</th>
                    <th style="width: 7%;">Mei</th>
                    <th style="width: 7%;">Jun</th>
                    <th style="width: 7%;">Jul</th>
                    <th style="width: 7%;">Ags</th>
                    <th style="width: 7%;">Sep</th>
                    <th style="width: 7%;">Okt</th>
                    <th style="width: 7%;">Nov</th>
                    <th style="width: 7%;">Des</th>
                </tr>
            </thead>
            <tbody>
                <!-- 1. PENDAPATAN OPERASIONAL (4) -->
                <tr class="section-header">
                    <td style="font-weight: bold; font-size: 11px; text-transform: uppercase;">PENDAPATAN OPERASIONAL</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td></td>
                    @endfor
                </tr>
                @if (!empty($pendapatanTree))
                    @php renderTreeLRTahunan($pendapatanTree, 1); @endphp
                @endif

                <!-- Total Pendapatan Operasional -->
                <tr class="subtotal-row">
                    <td style="font-weight: bold;">TOTAL PENDAPATAN OPERASIONAL</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right" style="font-weight: bold;">
                            @php
                                $totalPendapatan = 0;
                                foreach ($pendapatanTree as $node) {
                                    $totalPendapatan += ($node['monthly_balances'][$m] ?? 0);
                                }
                                echo formatLRTahunanValue($totalPendapatan);
                            @endphp
                        </td>
                    @endfor
                </tr>

                <!-- Spacer -->
                <tr><td colspan="13" style="height: 10px;"></td></tr>

                <!-- 2. HARGA POKOK PENJUALAN / PEMBELIAN (5) -->
                <tr class="section-header">
                    <td style="font-weight: bold; font-size: 11px; text-transform: uppercase;">HARGA POKOK PENJUALAN (HPP)</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td></td>
                    @endfor
                </tr>
                @if (!empty($hppTree))
                    @php renderTreeLRTahunan($hppTree, 1); @endphp
                @endif

                <!-- Total HPP -->
                <tr class="subtotal-row">
                    <td style="font-weight: bold;">TOTAL HARGA POKOK PENJUALAN</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right" style="font-weight: bold;">
                            @php
                                $totalHpp = 0;
                                foreach ($hppTree as $node) {
                                    $totalHpp += ($node['monthly_balances'][$m] ?? 0);
                                }
                                echo formatLRTahunanValue($totalHpp);
                            @endphp
                        </td>
                    @endfor
                </tr>

                <!-- Spacer -->
                <tr><td colspan="13" style="height: 10px;"></td></tr>

                <!-- 3. LABA KOTOR (Pendapatan - HPP) -->
                <tr class="subtotal-row" style="background-color: #f1f5f9;">
                    <td style="font-weight: bold; text-transform: uppercase;">LABA KOTOR</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right" style="font-weight: bold;">
                            @php
                                $totP = 0;
                                foreach ($pendapatanTree as $node) {
                                    $totP += ($node['monthly_balances'][$m] ?? 0);
                                }
                                $totH = 0;
                                foreach ($hppTree as $node) {
                                    $totH += ($node['monthly_balances'][$m] ?? 0);
                                }
                                $labaKotor = $totP - $totH;
                                echo formatLRTahunanValue($labaKotor);
                            @endphp
                        </td>
                    @endfor
                </tr>

                <!-- Spacer -->
                <tr><td colspan="13" style="height: 10px;"></td></tr>

                <!-- 4. BEBAN OPERASIONAL (6) -->
                <tr class="section-header">
                    <td style="font-weight: bold; font-size: 11px; text-transform: uppercase;">BEBAN OPERASIONAL</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td></td>
                    @endfor
                </tr>
                @if (!empty($bebanTree))
                    @php renderTreeLRTahunan($bebanTree, 1); @endphp
                @endif

                <!-- Total Beban Operasional -->
                <tr class="subtotal-row">
                    <td style="font-weight: bold;">TOTAL BEBAN OPERASIONAL</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right" style="font-weight: bold;">
                            @php
                                $totalBeban = 0;
                                foreach ($bebanTree as $node) {
                                    $totalBeban += ($node['monthly_balances'][$m] ?? 0);
                                }
                                echo formatLRTahunanValue($totalBeban);
                            @endphp
                        </td>
                    @endfor
                </tr>

                <!-- Spacer -->
                <tr><td colspan="13" style="height: 15px;"></td></tr>

                <!-- 5. LABA / RUGI BERSIH (Laba Kotor - Total Beban) -->
                <tr class="subtotal-row-grand">
                    <td style="font-weight: bold; text-transform: uppercase;">LABA (RUGI) BERSIH</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="text-right" style="font-weight: bold;">
                            @php
                                $totP = 0;
                                foreach ($pendapatanTree as $node) {
                                    $totP += ($node['monthly_balances'][$m] ?? 0);
                                }
                                $totH = 0;
                                foreach ($hppTree as $node) {
                                    $totH += ($node['monthly_balances'][$m] ?? 0);
                                }
                                $totB = 0;
                                foreach ($bebanTree as $node) {
                                    $totB += ($node['monthly_balances'][$m] ?? 0);
                                }
                                $labaBersih = ($totP - $totH) - $totB;
                                echo formatLRTahunanValue($labaBersih);
                            @endphp
                        </td>
                    @endfor
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
