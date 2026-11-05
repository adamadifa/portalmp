<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekapitulasi Penjualan Marketing - {{ date('d-m-Y H:i') }}</title>
    
    <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
    <script src="{{ asset('assets/vendor/libs/freeze/js/freeze-table.min.js') }}"></script>
    
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            background-color: #ffffff;
            margin: 0;
            padding: 20px;
        }

        /* Report Header */
        .report-header {
            margin-bottom: 20px;
            border-bottom: 2px solid #162a5b;
            padding-bottom: 12px;
        }

        .report-title {
            font-size: 16px;
            font-weight: 800;
            color: #162a5b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 6px 0;
        }

        .report-meta-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-top: 8px;
        }

        .report-meta-table td {
            padding: 2px 4px;
            vertical-align: top;
        }

        .report-meta-table td.label {
            font-weight: 700;
            color: #475569;
            width: 130px;
        }

        .report-meta-table td.separator {
            width: 10px;
            text-align: center;
        }

        .report-meta-table td.value {
            color: #0f172a;
            font-weight: 600;
        }

        /* Freeze & Table Container */
        .freeze-table {
            height: auto;
            max-height: 820px;
            overflow: auto;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
        }

        /* Datatable Styling */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            white-space: nowrap;
        }

        .report-table thead th {
            background-color: #162a5b !important;
            color: #ffffff !important;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 9px 8px;
            border: 1px solid #1e3a7a;
            font-size: 10.5px;
            position: sticky;
            top: 0;
            z-index: 20;
        }

        .report-table tbody td {
            padding: 6px 8px;
            border: 1px solid #e2e8f0;
            font-size: 11px;
            color: #334155;
            vertical-align: middle;
        }

        /* Alternating row colors */
        .report-table tbody tr.row-even {
            background-color: #ffffff;
        }
        .report-table tbody tr.row-odd {
            background-color: #f8fafc;
        }

        .report-table tbody tr:hover {
            background-color: #f1f5f9;
        }

        /* Grand Total Row */
        .report-table tfoot th {
            background-color: #162a5b !important;
            color: #ffffff !important;
            font-weight: 800;
            padding: 9px 8px;
            border: 1px solid #1e3a7a;
            font-size: 11px;
        }

        /* Alignment Utilities */
        .center {
            text-align: center !important;
        }
        .right {
            text-align: right !important;
        }
        .left {
            text-align: left !important;
        }
        .font-mono {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace !important;
        }
        .font-bold {
            font-weight: 700 !important;
        }

        /* Badge for Satuan & Kode */
        .badge-satuan {
            display: inline-block;
            padding: 1px 5px;
            border-radius: 4px;
            font-size: 9.5px;
            font-weight: 700;
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
            text-transform: uppercase;
        }

        /* Floating Action Bar (Screen Only) */
        .action-bar {
            position: fixed;
            bottom: 24px;
            right: 24px;
            display: flex;
            gap: 10px;
            z-index: 9999;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 18px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.2s ease;
            border: none;
        }

        .btn-print {
            background-color: #162a5b;
            color: #ffffff;
        }
        .btn-print:hover {
            background-color: #1f3a7a;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(22, 42, 91, 0.3);
        }

        .btn-close {
            background-color: #64748b;
            color: #ffffff;
        }
        .btn-close:hover {
            background-color: #475569;
            transform: translateY(-2px);
        }

        /* Print Media Styles */
        @media print {
            body {
                padding: 0;
                background-color: #ffffff;
                font-size: 9.5px;
            }

            .action-bar {
                display: none !important;
            }

            .freeze-table {
                max-height: none !important;
                overflow: visible !important;
                border: none !important;
            }

            .report-header {
                margin-bottom: 12px;
            }

            .report-title {
                font-size: 14px;
            }

            .report-table thead th {
                position: static !important;
                background-color: #f1f5f9 !important;
                color: #0f172a !important;
                border: 1px solid #94a3b8 !important;
                padding: 6px 4px;
                font-size: 9px;
            }

            .report-table tbody td {
                padding: 4px;
                border: 1px solid #cbd5e1 !important;
                font-size: 9px;
            }

            .report-table tfoot th {
                background-color: #f1f5f9 !important;
                color: #0f172a !important;
                border: 1px solid #94a3b8 !important;
                padding: 6px 4px;
                font-size: 9px;
            }

            @page {
                size: landscape;
                margin: 8mm 6mm;
            }
        }
    </style>
</head>

<body>
    <!-- Floating Quick Actions -->
    <div class="action-bar">
        <button type="button" class="btn-action btn-print" onclick="window.print()">
            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            <span>Cetak / Cetak PDF</span>
        </button>
        <button type="button" class="btn-action btn-close" onclick="window.close()">
            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            <span>Tutup</span>
        </button>
    </div>

    <!-- Letterhead & Report Metadata -->
    <div class="report-header">
        <h1 class="report-title">Rekapitulasi Penjualan Marketing</h1>
        
        <table class="report-meta-table">
            <tr>
                <td class="label">Periode Transaksi</td>
                <td class="separator">:</td>
                <td class="value">{{ DateToIndo($dari) }} s/d {{ DateToIndo($sampai) }}</td>
                <td class="label" style="text-align: right; width: 100px;">Waktu Cetak</td>
                <td class="separator">:</td>
                <td class="value" style="width: 160px;">{{ date('d-m-Y H:i:s') }}</td>
            </tr>
            <tr>
                <td class="label">Filter Pelanggan</td>
                <td class="separator">:</td>
                <td class="value">
                    @if ($selected_pelanggan != null)
                        <strong>{{ $selected_pelanggan->kode_pelanggan }}</strong> - {{ $selected_pelanggan->nama_pelanggan }}
                    @else
                        <em>Semua Pelanggan</em>
                    @endif
                </td>
                <td class="label" style="text-align: right;">Dicetak Oleh</td>
                <td class="separator">:</td>
                <td class="value">{{ auth()->user()->name ?? 'Administrator' }}</td>
            </tr>
        </table>
    </div>

    <!-- Main Data Table Container -->
    <div class="freeze-table">
        <table class="report-table" id="tabel_rekap_cetak">
            <thead>
                <tr>
                    <th style="width: 35px;" class="center">No</th>
                    <th style="width: 90px;" class="center">Kode Produk</th>
                    <th style="width: 260px;" class="left">Nama Produk</th>
                    <th style="width: 65px;" class="center">Satuan</th>
                    <th style="width: 100px;" class="right">Total Qty (Dus)</th>
                    <th style="width: 130px;" class="right">Total DPP</th>
                    <th style="width: 120px;" class="right">Total PPN (11%)</th>
                    <th style="width: 140px;" class="right">Grand Total (+PPN)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grand_qty = 0;
                    $grand_dpp = 0;
                    $grand_ppn = 0;
                    $grand_total = 0;
                @endphp

                @forelse ($rekap as $index => $d)
                    @php
                        $grand_qty += $d->total_qty;
                        $grand_dpp += $d->total_dpp;
                        $grand_ppn += $d->total_ppn;
                        $grand_total += $d->total_jumlah;
                        $row_class = ($index % 2 == 0) ? 'row-even' : 'row-odd';
                    @endphp
                    <tr class="{{ $row_class }}">
                        <td class="center">{{ $index + 1 }}</td>
                        <td class="center font-mono font-bold">{{ $d->kode_produk }}</td>
                        <td class="left font-semibold">{{ $d->nama_produk }}</td>
                        <td class="center">
                            <span class="badge-satuan">{{ $d->satuan }}</span>
                        </td>
                        <td class="right font-bold">{{ formatAngkaDesimal($d->total_qty) }}</td>
                        <td class="right font-mono">{{ formatAngkaDesimal($d->total_dpp) }}</td>
                        <td class="right font-mono">{{ formatAngkaDesimal($d->total_ppn) }}</td>
                        <td class="right font-mono font-bold">{{ formatAngkaDesimal($d->total_jumlah) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="center" style="padding: 30px; color: #94a3b8;">
                            Tidak ada data rekapitulasi produk pada periode ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="center">TOTAL KESELURUHAN</th>
                    <th class="right font-bold">{{ formatAngkaDesimal($grand_qty) }}</th>
                    <th class="right font-mono">{{ formatAngkaDesimal($grand_dpp) }}</th>
                    <th class="right font-mono">{{ formatAngkaDesimal($grand_ppn) }}</th>
                    <th class="right font-mono font-bold">{{ formatAngkaDesimal($grand_total) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $(".freeze-table").freezeTable({
                'scrollable': true,
                'columnNum': 3,
                'shadow': true
            });
        });
    </script>
</body>
</html>
