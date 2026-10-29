<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\Detailsaldoawalbukubesar;
use App\Models\Saldoawalbukubesar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanaccountingController extends Controller
{
    public function index()
    {
        $data['coa'] = Coa::orderBy('kode_akun', 'asc')->get();
        $data['start_year'] = config('global.start_year');
        $data['list_bulan'] = config('global.list_bulan');

        return view('accounting.laporan.index', $data);
    }

    public function cetakbukubesar(Request $request)
    {
        $request->validate([
            'formatlaporan' => 'required',
            'dari'          => 'required_if:formatlaporan,1,2,3|nullable|date',
            'sampai'        => 'required_if:formatlaporan,1,2,3|nullable|date',
            'tahun'         => 'required_if:formatlaporan,4,5',
        ]);

        $format = $request->formatlaporan;

        // FORMAT 4: NERACA TAHUNAN (HORIZONTAL) & FORMAT 5: LABA RUGI TAHUNAN (HORIZONTAL)
        if (in_array($format, ['4', '5'])) {
            $tahun = (int) $request->tahun;
            $data['tahun'] = $tahun;

            // Kumpulkan data mutasi dan saldo awal untuk seluruh 12 bulan
            // 1. Saldo Awal semua bulan di tahun terpilih
            $saldoAwalYearSub = DB::table('bukubesar_saldoawal_detail')
                ->join('bukubesar_saldoawal', 'bukubesar_saldoawal_detail.kode_saldo_awal', '=', 'bukubesar_saldoawal.kode_saldo_awal')
                ->where('bukubesar_saldoawal.tahun', $tahun)
                ->select(
                    'bukubesar_saldoawal_detail.kode_akun',
                    'bukubesar_saldoawal.bulan',
                    DB::raw("CONCAT(bukubesar_saldoawal.tahun, '-', LPAD(bukubesar_saldoawal.bulan, 2, '0'), '-01') as tanggal"),
                    'bukubesar_saldoawal_detail.kode_saldo_awal as no_bukti',
                    DB::raw("'SALDO AWAL' as sumber"),
                    DB::raw('0 as jml_debet'),
                    DB::raw('0 as jml_kredit'),
                    'bukubesar_saldoawal_detail.jumlah as saldo_awal_val'
                );

            // 2. Biaya
            $biayaYearSub = DB::table('biaya_detail')
                ->join('biaya', 'biaya_detail.no_bukti', '=', 'biaya.no_bukti')
                ->whereYear('biaya.tanggal', $tahun)
                ->select(
                    'biaya_detail.kode_akun',
                    DB::raw('MONTH(biaya.tanggal) as bulan'),
                    'biaya.tanggal',
                    'biaya.no_bukti',
                    DB::raw("'BIAYA OPERASIONAL' as sumber"),
                    DB::raw('((biaya_detail.jumlah * biaya_detail.harga) + biaya_detail.penyesuaian) as jml_debet'),
                    DB::raw('0 as jml_kredit'),
                    DB::raw('0 as saldo_awal_val')
                );

            // 3. Pembelian
            $pembelianYearSub = DB::table('pembelian_detail')
                ->join('pembelian', 'pembelian_detail.no_bukti', '=', 'pembelian.no_bukti')
                ->whereYear('pembelian.tanggal', $tahun)
                ->select(
                    'pembelian_detail.kode_akun',
                    DB::raw('MONTH(pembelian.tanggal) as bulan'),
                    'pembelian.tanggal',
                    'pembelian.no_bukti',
                    DB::raw("'PEMBELIAN' as sumber"),
                    DB::raw('CASE WHEN pembelian.ppn = "1" THEN ((pembelian_detail.jumlah * pembelian_detail.harga) * 100 / 111) ELSE ((pembelian_detail.jumlah * pembelian_detail.harga) + pembelian_detail.penyesuaian) END as jml_debet'),
                    DB::raw('0 as jml_kredit'),
                    DB::raw('0 as saldo_awal_val')
                );

            // 4. Penjualan Marketing
            $penjualanYearSub = DB::table('marketing_penjualan_detail')
                ->join('marketing_penjualan', 'marketing_penjualan_detail.no_bukti', '=', 'marketing_penjualan.no_bukti')
                ->whereYear('marketing_penjualan.tanggal', $tahun)
                ->select(
                    DB::raw("'4-11101' as kode_akun"),
                    DB::raw('MONTH(marketing_penjualan.tanggal) as bulan'),
                    'marketing_penjualan.tanggal',
                    'marketing_penjualan.no_bukti',
                    DB::raw("'PENJUALAN' as sumber"),
                    DB::raw('0 as jml_debet'),
                    DB::raw('(marketing_penjualan_detail.harga_dus * marketing_penjualan_detail.jumlah) as jml_kredit'),
                    DB::raw('0 as saldo_awal_val')
                );

            // 5. PPN Keluaran
            $ppnKeluaranYearSub = DB::table('marketing_penjualan_detail')
                ->join('marketing_penjualan', 'marketing_penjualan_detail.no_bukti', '=', 'marketing_penjualan.no_bukti')
                ->whereYear('marketing_penjualan.tanggal', $tahun)
                ->select(
                    DB::raw("'2-11301' as kode_akun"),
                    DB::raw('MONTH(marketing_penjualan.tanggal) as bulan'),
                    'marketing_penjualan.tanggal',
                    'marketing_penjualan.no_bukti',
                    DB::raw("'PENJUALAN' as sumber"),
                    DB::raw('0 as jml_debet'),
                    DB::raw('(marketing_penjualan_detail.subtotal - (marketing_penjualan_detail.harga_dus * marketing_penjualan_detail.jumlah)) as jml_kredit'),
                    DB::raw('0 as saldo_awal_val')
                );

            // 6. Piutang Usaha Penjualan (Debet)
            $piutangPenjualanYearSub = DB::table('marketing_penjualan_detail')
                ->join('marketing_penjualan', 'marketing_penjualan_detail.no_bukti', '=', 'marketing_penjualan.no_bukti')
                ->whereYear('marketing_penjualan.tanggal', $tahun)
                ->select(
                    DB::raw("'1-11201' as kode_akun"),
                    DB::raw('MONTH(marketing_penjualan.tanggal) as bulan'),
                    'marketing_penjualan.tanggal',
                    'marketing_penjualan.no_bukti',
                    DB::raw("'PENJUALAN' as sumber"),
                    'marketing_penjualan_detail.subtotal as jml_debet',
                    DB::raw('0 as jml_kredit'),
                    DB::raw('0 as saldo_awal_val')
                );

            // 7. Bayar Piutang
            $bayarPiutangYearSub = DB::table('marketing_penjualan_historibayar')
                ->whereYear('marketing_penjualan_historibayar.tanggal', $tahun)
                ->select(
                    DB::raw("'1-11201' as kode_akun"),
                    DB::raw('MONTH(marketing_penjualan_historibayar.tanggal) as bulan'),
                    'marketing_penjualan_historibayar.tanggal',
                    'marketing_penjualan_historibayar.no_bukti',
                    DB::raw("'PELUNASAN PIUTANG' as sumber"),
                    DB::raw('0 as jml_debet'),
                    'marketing_penjualan_historibayar.jumlah as jml_kredit',
                    DB::raw('0 as saldo_awal_val')
                );

            // 7b. Penerimaan Kas/Bank dari Piutang Penjualan (Debet Kas/Bank)
            $kasBankPiutangYearSub = DB::table('marketing_penjualan_historibayar')
                ->leftJoin('bank', 'marketing_penjualan_historibayar.kode_bank', '=', 'bank.kode_bank')
                ->whereYear('marketing_penjualan_historibayar.tanggal', $tahun)
                ->select(
                    DB::raw("CASE 
                        WHEN bank.kode_akun IN ('1-11101', '1-11102', '1-11103', '1-11104', '1-11105') THEN bank.kode_akun
                        WHEN bank.nama_bank LIKE '%BCA%' THEN '1-11103'
                        WHEN bank.nama_bank LIKE '%BNI%' THEN '1-11104'
                        WHEN bank.nama_bank LIKE '%BSI%' THEN '1-11105'
                        WHEN bank.nama_bank LIKE '%KAS KECIL%' THEN '1-11102'
                        WHEN marketing_penjualan_historibayar.jenis_bayar = 'TN' THEN '1-11101'
                        ELSE '1-11103'
                    END as kode_akun"),
                    DB::raw('MONTH(marketing_penjualan_historibayar.tanggal) as bulan'),
                    'marketing_penjualan_historibayar.tanggal',
                    'marketing_penjualan_historibayar.no_bukti',
                    DB::raw("'PELUNASAN PIUTANG' as sumber"),
                    'marketing_penjualan_historibayar.jumlah as jml_debet',
                    DB::raw('0 as jml_kredit'),
                    DB::raw('0 as saldo_awal_val')
                );

            // 8. Bayar Pembelian (Kas/Bank keluar)
            $bayarPembelianYearSub = DB::table('pembelian_historibayar')
                ->leftJoin('bank', 'pembelian_historibayar.kode_bank', '=', 'bank.kode_bank')
                ->whereYear('pembelian_historibayar.tanggal', $tahun)
                ->select(
                    DB::raw("CASE 
                        WHEN bank.kode_akun IN ('1-11101', '1-11102', '1-11103', '1-11104', '1-11105') THEN bank.kode_akun
                        WHEN bank.nama_bank LIKE '%BCA%' THEN '1-11103'
                        WHEN bank.nama_bank LIKE '%BNI%' THEN '1-11104'
                        WHEN bank.nama_bank LIKE '%BSI%' THEN '1-11105'
                        WHEN bank.nama_bank LIKE '%KAS KECIL%' THEN '1-11102'
                        ELSE '1-11101'
                    END as kode_akun"),
                    DB::raw('MONTH(pembelian_historibayar.tanggal) as bulan'),
                    'pembelian_historibayar.tanggal',
                    'pembelian_historibayar.no_bukti',
                    DB::raw("'BAYAR PEMBELIAN' as sumber"),
                    DB::raw('0 as jml_debet'),
                    'pembelian_historibayar.jumlah as jml_kredit',
                    DB::raw('0 as saldo_awal_val')
                );

            // 8b. Pelunasan Hutang Pembelian (Debet Hutang Usaha 2-11101)
            $bayarHutangPembelianYearSub = DB::table('pembelian_historibayar')
                ->join('pembelian', 'pembelian_historibayar.no_bukti', '=', 'pembelian.no_bukti')
                ->whereYear('pembelian_historibayar.tanggal', $tahun)
                ->where('pembelian.jenis_transaksi', 'K')
                ->where(function($q) {
                    $q->whereNull('pembelian.kategori_pembelian')
                      ->orWhere('pembelian.kategori_pembelian', '!=', 'I');
                })
                ->where(function($q) {
                    $q->whereNull('pembelian.status_uang_muka')
                      ->orWhere('pembelian.status_uang_muka', '!=', 1);
                })
                ->select(
                    DB::raw("'2-11101' as kode_akun"),
                    DB::raw('MONTH(pembelian_historibayar.tanggal) as bulan'),
                    'pembelian_historibayar.tanggal',
                    'pembelian_historibayar.no_bukti',
                    DB::raw("'BAYAR PEMBELIAN' as sumber"),
                    'pembelian_historibayar.jumlah as jml_debet',
                    DB::raw('0 as jml_kredit'),
                    DB::raw('0 as saldo_awal_val')
                );

            // 9. Bayar Biaya (Kas/Bank keluar)
            $bayarBiayaYearSub = DB::table('biaya_historibayar')
                ->leftJoin('bank', 'biaya_historibayar.kode_bank', '=', 'bank.kode_bank')
                ->whereYear('biaya_historibayar.tanggal', $tahun)
                ->select(
                    DB::raw("CASE 
                        WHEN bank.kode_akun IN ('1-11101', '1-11102', '1-11103', '1-11104', '1-11105') THEN bank.kode_akun
                        WHEN bank.nama_bank LIKE '%BCA%' THEN '1-11103'
                        WHEN bank.nama_bank LIKE '%BNI%' THEN '1-11104'
                        WHEN bank.nama_bank LIKE '%BSI%' THEN '1-11105'
                        WHEN bank.nama_bank LIKE '%KAS KECIL%' THEN '1-11102'
                        ELSE '1-11101'
                    END as kode_akun"),
                    DB::raw('MONTH(biaya_historibayar.tanggal) as bulan'),
                    'biaya_historibayar.tanggal',
                    'biaya_historibayar.no_bukti',
                    DB::raw("'BAYAR BIAYA' as sumber"),
                    DB::raw('0 as jml_debet'),
                    'biaya_historibayar.jumlah as jml_kredit',
                    DB::raw('0 as saldo_awal_val')
                );

            // 10. Jurnal Umum
            $jurnalUmumYearSub = DB::table('accounting_jurnalumum')
                ->whereYear('accounting_jurnalumum.tanggal', $tahun)
                ->select(
                    'accounting_jurnalumum.kode_akun',
                    DB::raw('MONTH(accounting_jurnalumum.tanggal) as bulan'),
                    'accounting_jurnalumum.tanggal',
                    'accounting_jurnalumum.kode_ju as no_bukti',
                    DB::raw("'JURNAL UMUM' as sumber"),
                    DB::raw("CASE WHEN accounting_jurnalumum.debet_kredit = 'D' THEN accounting_jurnalumum.jumlah ELSE 0 END as jml_debet"),
                    DB::raw("CASE WHEN accounting_jurnalumum.debet_kredit = 'K' THEN accounting_jurnalumum.jumlah ELSE 0 END as jml_kredit"),
                    DB::raw('0 as saldo_awal_val')
                );

            // 11. PPN Masukan Pembelian
            $ppnMasukanYearSub = DB::table('pembelian_detail')
                ->join('pembelian', 'pembelian_detail.no_bukti', '=', 'pembelian.no_bukti')
                ->whereYear('pembelian.tanggal', $tahun)
                ->where('pembelian.ppn', '1')
                ->where('pembelian_detail.kode_transaksi', 'PMB')
                ->select(
                    DB::raw("'1-11501' as kode_akun"),
                    DB::raw('MONTH(pembelian.tanggal) as bulan'),
                    'pembelian.tanggal',
                    'pembelian.no_bukti',
                    DB::raw("'PEMBELIAN' as sumber"),
                    DB::raw('((((pembelian_detail.jumlah * pembelian_detail.harga) * 100 / 111) * 11 / 12) * 0.12) as jml_debet'),
                    DB::raw('0 as jml_kredit'),
                    DB::raw('0 as saldo_awal_val')
                );

            // 12. Hutang Pembelian
            $hutangPembelianYearSub = DB::table('pembelian_detail')
                ->join('pembelian', 'pembelian_detail.no_bukti', '=', 'pembelian.no_bukti')
                ->whereYear('pembelian.tanggal', $tahun)
                ->where('pembelian.jenis_transaksi', 'K')
                ->where(function($q) {
                    $q->whereNull('pembelian.kategori_pembelian')
                      ->orWhere('pembelian.kategori_pembelian', '!=', 'I');
                })
                ->where(function($q) {
                    $q->whereNull('pembelian.status_uang_muka')
                      ->orWhere('pembelian.status_uang_muka', '!=', 1);
                })
                ->where('pembelian_detail.kode_transaksi', 'PMB')
                ->select(
                    DB::raw("'2-11101' as kode_akun"),
                    DB::raw('MONTH(pembelian.tanggal) as bulan'),
                    'pembelian.tanggal',
                    'pembelian.no_bukti',
                    DB::raw("'PEMBELIAN' as sumber"),
                    DB::raw('0 as jml_debet'),
                    DB::raw('CASE WHEN pembelian.kategori_pembelian = "I" AND pembelian.ppn = "1"
                        THEN ((pembelian_detail.jumlah * pembelian_detail.harga) * 100 / 111)
                        ELSE ((pembelian_detail.jumlah * pembelian_detail.harga) + pembelian_detail.penyesuaian)
                    END as jml_kredit'),
                    DB::raw('0 as saldo_awal_val')
                );

            // 13. PPN Masukan Biaya
            $ppnMasukanBiayaYearSub = DB::table('biaya_detail')
                ->join('biaya', 'biaya_detail.no_bukti', '=', 'biaya.no_bukti')
                ->whereYear('biaya.tanggal', $tahun)
                ->where('biaya.ppn', '1')
                ->select(
                    DB::raw("'1-11501' as kode_akun"),
                    DB::raw('MONTH(biaya.tanggal) as bulan'),
                    'biaya.tanggal',
                    'biaya.no_bukti',
                    DB::raw("'BIAYA' as sumber"),
                    DB::raw('((((biaya_detail.jumlah * biaya_detail.harga) * 100 / 111) * 11 / 12) * 0.12) as jml_debet'),
                    DB::raw('0 as jml_kredit'),
                    DB::raw('0 as saldo_awal_val')
                );

            $unionYear = $saldoAwalYearSub
                ->unionAll($biayaYearSub)
                ->unionAll($pembelianYearSub)
                ->unionAll($penjualanYearSub)
                ->unionAll($ppnKeluaranYearSub)
                ->unionAll($piutangPenjualanYearSub)
                ->unionAll($bayarPiutangYearSub)
                ->unionAll($kasBankPiutangYearSub)
                ->unionAll($bayarPembelianYearSub)
                ->unionAll($bayarHutangPembelianYearSub)
                ->unionAll($bayarBiayaYearSub)
                ->unionAll($jurnalUmumYearSub)
                ->unionAll($ppnMasukanYearSub)
                ->unionAll($hutangPembelianYearSub)
                ->unionAll($ppnMasukanBiayaYearSub);

            // Group by kode_akun and bulan
            $monthlySums = DB::query()->fromSub($unionYear, 'uy')
                ->selectRaw('kode_akun, bulan, SUM(saldo_awal_val) as sa, SUM(jml_debet) as debet, SUM(jml_kredit) as kredit')
                ->groupBy('kode_akun', 'bulan')
                ->get();

            $monthlyMatrix = [];
            foreach ($monthlySums as $row) {
                $m = (int) $row->bulan;
                if ($m >= 1 && $m <= 12) {
                    $monthlyMatrix[$row->kode_akun][$m] = [
                        'sa' => (float) $row->sa,
                        'debet' => (float) $row->debet,
                        'kredit' => (float) $row->kredit,
                    ];
                }
            }

            if ($format == '4') {
                // FORMAT 4: NERACA TAHUNAN (HORIZONTAL)
                $balances_N = [];
                $net_profit_loss = array_fill(1, 12, 0.0);

                // Hitung laba berjalan kumulatif untuk tiap bulan (m = 1 s/d 12)
                for ($m = 1; $m <= 12; $m++) {
                    $cumPendapatan = 0;
                    $cumHpp = 0;
                    $cumBiaya = 0;

                    foreach ($monthlyMatrix as $k => $mMap) {
                        $prefix = substr($k, 0, 1);
                        if (in_array($prefix, ['4', '5', '6'])) {
                            // Hitung kumulatif transaksi dari bulan 1 sampai bulan m
                            $totDebet = 0;
                            $totKredit = 0;
                            for ($subM = 1; $subM <= $m; $subM++) {
                                if (isset($mMap[$subM])) {
                                    $totDebet += $mMap[$subM]['debet'];
                                    $totKredit += $mMap[$subM]['kredit'];
                                }
                            }
                            if ($prefix === '4') {
                                $cumPendapatan += ($totKredit - $totDebet);
                            } elseif ($prefix === '5') {
                                $cumHpp += ($totDebet - $totKredit);
                            } elseif ($prefix === '6') {
                                $cumBiaya += ($totDebet - $totKredit);
                            }
                        }
                    }
                    $net_profit_loss[$m] = $cumPendapatan - $cumHpp - $cumBiaya;
                }

                // Hitung saldo kumulatif Neraca per bulan
                $neracaAccounts = Coa::whereRaw('LEFT(kode_akun, 1) IN (1, 2, 3)')
                    ->orderBy('kode_akun', 'asc')
                    ->get();

                foreach ($neracaAccounts as $acc) {
                    $prefix = substr($acc->kode_akun, 0, 1);
                    for ($m = 1; $m <= 12; $m++) {
                        // Cek apakah ada saldo awal tersimpan di bulan m (misal SA012026)
                        $saVal = $monthlyMatrix[$acc->kode_akun][$m]['sa'] ?? null;
                        
                        // Hitung akumulasi dari bulan 1 sampai bulan m
                        $cumDebet = 0;
                        $cumKredit = 0;
                        $baseSa = 0;
                        
                        // Cari saldo awal paling mutakhir di bulan <= m jika ada
                        for ($subM = $m; $subM >= 1; $subM--) {
                            if (isset($monthlyMatrix[$acc->kode_akun][$subM]['sa']) && $monthlyMatrix[$acc->kode_akun][$subM]['sa'] != 0) {
                                $baseSa = $monthlyMatrix[$acc->kode_akun][$subM]['sa'];
                                // Hanya hitung mutasi dari bulan subM sampai bulan m
                                for ($mutM = $subM; $mutM <= $m; $mutM++) {
                                    if (isset($monthlyMatrix[$acc->kode_akun][$mutM])) {
                                        $cumDebet += $monthlyMatrix[$acc->kode_akun][$mutM]['debet'];
                                        $cumKredit += $monthlyMatrix[$acc->kode_akun][$mutM]['kredit'];
                                    }
                                }
                                break;
                            }
                        }

                        if ($baseSa == 0) {
                            for ($mutM = 1; $mutM <= $m; $mutM++) {
                                if (isset($monthlyMatrix[$acc->kode_akun][$mutM])) {
                                    $cumDebet += $monthlyMatrix[$acc->kode_akun][$mutM]['debet'];
                                    $cumKredit += $monthlyMatrix[$acc->kode_akun][$mutM]['kredit'];
                                }
                            }
                        }

                        if ($prefix === '1') {
                            $saldo = $baseSa + $cumDebet - $cumKredit;
                        } else {
                            $saldo = $baseSa + $cumKredit - $cumDebet;
                        }

                        $balances_N[$acc->kode_akun][$m] = $saldo;
                    }
                }

                $data['neraca'] = $neracaAccounts;
                $data['balances'] = $balances_N;
                $data['net_profit_loss'] = $net_profit_loss;

                if (isset($_POST['exportButton'])) {
                    header("Content-type: application/vnd-ms-excel");
                    header("Content-Disposition: attachment; filename=Neraca_Tahunan_{$tahun}.xls");
                }
                return view('accounting.laporan.lk.neraca_tahunan_cetak', $data);

            } elseif ($format == '5') {
                // FORMAT 5: LABA RUGI TAHUNAN (HORIZONTAL)
                $balances_LR = [];
                $lrAccounts = Coa::whereRaw('LEFT(kode_akun, 1) IN (4, 5, 6)')
                    ->orderBy('kode_akun', 'asc')
                    ->get();

                foreach ($lrAccounts as $acc) {
                    $prefix = substr($acc->kode_akun, 0, 1);
                    for ($m = 1; $m <= 12; $m++) {
                        $mRow = $monthlyMatrix[$acc->kode_akun][$m] ?? null;
                        if ($mRow) {
                            if ($prefix === '4') {
                                $balances_LR[$acc->kode_akun][$m] = (float) $mRow['kredit'] - (float) $mRow['debet'];
                            } else {
                                $balances_LR[$acc->kode_akun][$m] = (float) $mRow['debet'] - (float) $mRow['kredit'];
                            }
                        } else {
                            $balances_LR[$acc->kode_akun][$m] = 0.0;
                        }
                    }
                }

                // Hitung Saldo Awal & Saldo Akhir Persediaan (1-11302 & 1-11303)
                $calcPersediaanTahunan = function($kodeAkun) use ($monthlyMatrix) {
                    $sa = [];
                    $ak = [];
                    for ($m = 1; $m <= 12; $m++) {
                        $cumDebet = 0;
                        $cumKredit = 0;
                        $baseSa = 0;
                        
                        for ($subM = $m; $subM >= 1; $subM--) {
                            if (isset($monthlyMatrix[$kodeAkun][$subM]['sa']) && $monthlyMatrix[$kodeAkun][$subM]['sa'] != 0) {
                                $baseSa = $monthlyMatrix[$kodeAkun][$subM]['sa'];
                                for ($mutM = $subM; $mutM <= $m; $mutM++) {
                                    if (isset($monthlyMatrix[$kodeAkun][$mutM])) {
                                        $cumDebet += $monthlyMatrix[$kodeAkun][$mutM]['debet'];
                                        $cumKredit += $monthlyMatrix[$kodeAkun][$mutM]['kredit'];
                                    }
                                }
                                break;
                            }
                        }

                        if ($baseSa == 0) {
                            for ($mutM = 1; $mutM <= $m; $mutM++) {
                                if (isset($monthlyMatrix[$kodeAkun][$mutM])) {
                                    $cumDebet += $monthlyMatrix[$kodeAkun][$mutM]['debet'];
                                    $cumKredit += $monthlyMatrix[$kodeAkun][$mutM]['kredit'];
                                }
                            }
                        }

                        $ak[$m] = $baseSa + $cumDebet - $cumKredit;
                        if ($m == 1) {
                            $sa[$m] = $baseSa;
                        } else {
                            $sa[$m] = $ak[$m - 1];
                        }
                    }
                    return ['sa' => $sa, 'ak' => $ak];
                };

                $ps_bb = $calcPersediaanTahunan('1-11302');
                $ps_bk = $calcPersediaanTahunan('1-11303');

                $hppBahanTahunan = [
                    'bb' => [
                        'sa' => $ps_bb['sa'],
                        'pemb' => $balances_LR['5-11101'] ?? array_fill(1, 12, 0.0),
                        'ak' => $ps_bb['ak'],
                        'used' => [],
                    ],
                    'bk' => [
                        'sa' => $ps_bk['sa'],
                        'pemb' => $balances_LR['5-11102'] ?? array_fill(1, 12, 0.0),
                        'ak' => $ps_bk['ak'],
                        'used' => [],
                    ],
                ];

                for ($m = 1; $m <= 12; $m++) {
                    $hppBahanTahunan['bb']['used'][$m] = $hppBahanTahunan['bb']['sa'][$m] + $hppBahanTahunan['bb']['pemb'][$m] - $hppBahanTahunan['bb']['ak'][$m];
                    $hppBahanTahunan['bk']['used'][$m] = $hppBahanTahunan['bk']['sa'][$m] + $hppBahanTahunan['bk']['pemb'][$m] - $hppBahanTahunan['bk']['ak'][$m];
                }

                $data['labarugi'] = $lrAccounts;
                $data['balances'] = $balances_LR;
                $data['hppBahanTahunan'] = $hppBahanTahunan;

                if (isset($_POST['exportButton'])) {
                    header("Content-type: application/vnd-ms-excel");
                    header("Content-Disposition: attachment; filename=Laba_Rugi_Tahunan_{$tahun}.xls");
                }
                return view('accounting.laporan.lk.labarugi_tahunan_cetak', $data);
            }
        }

        $dari = $request->dari;
        $sampai = $request->sampai;

        $data['dari'] = $dari;
        $data['sampai'] = $sampai;

        // Tentukan periode awal bulan untuk saldo awal
        $bulan = (int) date('m', strtotime($dari));
        $tahun = (int) date('Y', strtotime($dari));
        $kode_sa = sprintf('SA%02d%d', $bulan, $tahun);

        // 1. Saldo Awal per Akun
        $saldoAwalSub = DB::table('bukubesar_saldoawal_detail')
            ->join('bukubesar_saldoawal', 'bukubesar_saldoawal_detail.kode_saldo_awal', '=', 'bukubesar_saldoawal.kode_saldo_awal')
            ->where('bukubesar_saldoawal.kode_saldo_awal', $kode_sa)
            ->select(
                'bukubesar_saldoawal_detail.kode_akun',
                DB::raw("CONCAT('$tahun-', LPAD('$bulan', 2, '0'), '-01') as tanggal"),
                'bukubesar_saldoawal_detail.kode_saldo_awal as no_bukti',
                DB::raw("'SALDO AWAL' as sumber"),
                DB::raw("'Saldo Awal Buku Besar' as keterangan"),
                DB::raw('0 as jml_debet'),
                DB::raw('0 as jml_kredit'),
                'bukubesar_saldoawal_detail.jumlah as saldo_awal_val',
                DB::raw('0 as urutan')
            );

        // 2. Transaksi Biaya Operasional
        $biayaSub = DB::table('biaya_detail')
            ->join('biaya', 'biaya_detail.no_bukti', '=', 'biaya.no_bukti')
            ->whereBetween('biaya.tanggal', [sprintf('%04d-%02d-01', $tahun, $bulan), $sampai])
            ->select(
                'biaya_detail.kode_akun',
                'biaya.tanggal',
                'biaya.no_bukti',
                DB::raw("'BIAYA OPERASIONAL' as sumber"),
                DB::raw("CONCAT(COALESCE(biaya_detail.keterangan, 'Biaya'), ' - ', COALESCE(biaya.keterangan, '')) as keterangan"),
                DB::raw('((biaya_detail.jumlah * biaya_detail.harga) + biaya_detail.penyesuaian) as jml_debet'),
                DB::raw('0 as jml_kredit'),
                DB::raw('0 as saldo_awal_val'),
                DB::raw('2 as urutan')
            );

        // 3. Transaksi Pembelian (Hanya DPP yang dicatat ke akun HPP/Beban)
        $pembelianSub = DB::table('pembelian_detail')
            ->join('pembelian', 'pembelian_detail.no_bukti', '=', 'pembelian.no_bukti')
            ->whereBetween('pembelian.tanggal', [sprintf('%04d-%02d-01', $tahun, $bulan), $sampai])
            ->select(
                'pembelian_detail.kode_akun',
                'pembelian.tanggal',
                'pembelian.no_bukti',
                DB::raw("'PEMBELIAN' as sumber"),
                DB::raw("COALESCE(pembelian_detail.keterangan, 'Pembelian Barang') as keterangan"),
                DB::raw('CASE WHEN pembelian.ppn = "1" THEN ((pembelian_detail.jumlah * pembelian_detail.harga) * 100 / 111) ELSE ((pembelian_detail.jumlah * pembelian_detail.harga) + pembelian_detail.penyesuaian) END as jml_debet'),
                DB::raw('0 as jml_kredit'),
                DB::raw('0 as saldo_awal_val'),
                DB::raw('2 as urutan')
            );

        // 4. Transaksi Penjualan Marketing (Hanya DPP = harga_dus * jumlah yang dicatat ke akun Pendapatan)
        $penjualanSub = DB::table('marketing_penjualan_detail')
            ->join('marketing_penjualan', 'marketing_penjualan_detail.no_bukti', '=', 'marketing_penjualan.no_bukti')
            ->leftJoin('pelanggan', 'marketing_penjualan.kode_pelanggan', '=', 'pelanggan.kode_pelanggan')
            ->whereBetween('marketing_penjualan.tanggal', [sprintf('%04d-%02d-01', $tahun, $bulan), $sampai])
            ->select(
                DB::raw("'4-11101' as kode_akun"),
                'marketing_penjualan.tanggal',
                'marketing_penjualan.no_bukti',
                DB::raw("'PENJUALAN' as sumber"),
                DB::raw("CONCAT('Penjualan ', COALESCE(pelanggan.nama_pelanggan, '')) as keterangan"),
                DB::raw('0 as jml_debet'),
                DB::raw('(marketing_penjualan_detail.harga_dus * marketing_penjualan_detail.jumlah) as jml_kredit'),
                DB::raw('0 as saldo_awal_val'),
                DB::raw('2 as urutan')
            );

        // 5. Transaksi PPN Keluaran (2-11301) dari Penjualan Marketing
        $ppnKeluaranSub = DB::table('marketing_penjualan_detail')
            ->join('marketing_penjualan', 'marketing_penjualan_detail.no_bukti', '=', 'marketing_penjualan.no_bukti')
            ->leftJoin('pelanggan', 'marketing_penjualan.kode_pelanggan', '=', 'pelanggan.kode_pelanggan')
            ->whereBetween('marketing_penjualan.tanggal', [sprintf('%04d-%02d-01', $tahun, $bulan), $sampai])
            ->select(
                DB::raw("'2-11301' as kode_akun"),
                'marketing_penjualan.tanggal',
                'marketing_penjualan.no_bukti',
                DB::raw("'PENJUALAN' as sumber"),
                DB::raw("CONCAT('PPN Keluaran ', COALESCE(pelanggan.nama_pelanggan, '')) as keterangan"),
                DB::raw('0 as jml_debet'),
                DB::raw('(marketing_penjualan_detail.subtotal - (marketing_penjualan_detail.harga_dus * marketing_penjualan_detail.jumlah)) as jml_kredit'),
                DB::raw('0 as saldo_awal_val'),
                DB::raw('2 as urutan')
            );

        // 6. Transaksi Piutang Usaha (1-11201) dari Total Netto Penjualan Marketing (Debet)
        $piutangPenjualanSub = DB::table('marketing_penjualan_detail')
            ->join('marketing_penjualan', 'marketing_penjualan_detail.no_bukti', '=', 'marketing_penjualan.no_bukti')
            ->leftJoin('pelanggan', 'marketing_penjualan.kode_pelanggan', '=', 'pelanggan.kode_pelanggan')
            ->whereBetween('marketing_penjualan.tanggal', [sprintf('%04d-%02d-01', $tahun, $bulan), $sampai])
            ->select(
                DB::raw("'1-11201' as kode_akun"),
                'marketing_penjualan.tanggal',
                'marketing_penjualan.no_bukti',
                DB::raw("'PENJUALAN' as sumber"),
                DB::raw("CONCAT('Piutang Penjualan ', COALESCE(pelanggan.nama_pelanggan, '')) as keterangan"),
                'marketing_penjualan_detail.subtotal as jml_debet',
                DB::raw('0 as jml_kredit'),
                DB::raw('0 as saldo_awal_val'),
                DB::raw('2 as urutan')
            );

        // 7. Penerimaan Pembayaran Piutang Penjualan (Kredit pada Piutang Usaha 1-11201)
        $bayarPiutangSub = DB::table('marketing_penjualan_historibayar')
            ->whereBetween('marketing_penjualan_historibayar.tanggal', [sprintf('%04d-%02d-01', $tahun, $bulan), $sampai])
            ->select(
                DB::raw("'1-11201' as kode_akun"),
                'marketing_penjualan_historibayar.tanggal',
                'marketing_penjualan_historibayar.no_bukti',
                DB::raw("'PELUNASAN PIUTANG' as sumber"),
                DB::raw("CONCAT('Penerimaan Piutang Penjualan ', COALESCE(marketing_penjualan_historibayar.no_bukti_penjualan, '')) as keterangan"),
                DB::raw('0 as jml_debet'),
                'marketing_penjualan_historibayar.jumlah as jml_kredit',
                DB::raw('0 as saldo_awal_val'),
                DB::raw('3 as urutan')
            );

        // 7b. Penerimaan Kas/Bank dari Piutang Penjualan (Debet Kas/Bank)
        $kasBankPiutangSub = DB::table('marketing_penjualan_historibayar')
            ->leftJoin('bank', 'marketing_penjualan_historibayar.kode_bank', '=', 'bank.kode_bank')
            ->leftJoin('marketing_penjualan', 'marketing_penjualan_historibayar.no_bukti_penjualan', '=', 'marketing_penjualan.no_bukti')
            ->leftJoin('pelanggan', 'marketing_penjualan.kode_pelanggan', '=', 'pelanggan.kode_pelanggan')
            ->whereBetween('marketing_penjualan_historibayar.tanggal', [sprintf('%04d-%02d-01', $tahun, $bulan), $sampai])
            ->select(
                DB::raw("CASE 
                    WHEN bank.kode_akun IN ('1-11101', '1-11102', '1-11103', '1-11104', '1-11105') THEN bank.kode_akun
                    WHEN bank.nama_bank LIKE '%BCA%' THEN '1-11103'
                    WHEN bank.nama_bank LIKE '%BNI%' THEN '1-11104'
                    WHEN bank.nama_bank LIKE '%BSI%' THEN '1-11105'
                    WHEN bank.nama_bank LIKE '%KAS KECIL%' THEN '1-11102'
                    WHEN marketing_penjualan_historibayar.jenis_bayar = 'TN' THEN '1-11101'
                    ELSE '1-11103'
                END as kode_akun"),
                'marketing_penjualan_historibayar.tanggal',
                'marketing_penjualan_historibayar.no_bukti',
                DB::raw("CONCAT('KAS / BANK - ', COALESCE(bank.nama_bank, 'KAS')) as sumber"),
                DB::raw("CONCAT('Penerimaan Piutang ', COALESCE(pelanggan.nama_pelanggan, ''), ' via ', COALESCE(bank.nama_bank, 'Kas/Bank')) as keterangan"),
                'marketing_penjualan_historibayar.jumlah as jml_debet',
                DB::raw('0 as jml_kredit'),
                DB::raw('0 as saldo_awal_val'),
                DB::raw('3 as urutan')
            );

        // 8. Pembayaran Hutang Pembelian (Kas/Bank keluar)
        $bayarPembelianSub = DB::table('pembelian_historibayar')
            ->leftJoin('bank', 'pembelian_historibayar.kode_bank', '=', 'bank.kode_bank')
            ->whereBetween('pembelian_historibayar.tanggal', [sprintf('%04d-%02d-01', $tahun, $bulan), $sampai])
            ->select(
                DB::raw("CASE 
                    WHEN bank.kode_akun IN ('1-11101', '1-11102', '1-11103', '1-11104', '1-11105') THEN bank.kode_akun
                    WHEN bank.nama_bank LIKE '%BCA%' THEN '1-11103'
                    WHEN bank.nama_bank LIKE '%BNI%' THEN '1-11104'
                    WHEN bank.nama_bank LIKE '%BSI%' THEN '1-11105'
                    WHEN bank.nama_bank LIKE '%KAS KECIL%' THEN '1-11102'
                    ELSE '1-11101'
                END as kode_akun"),
                'pembelian_historibayar.tanggal',
                'pembelian_historibayar.no_bukti',
                DB::raw("CONCAT('KAS / BANK - ', COALESCE(bank.nama_bank, 'KAS')) as sumber"),
                DB::raw("CONCAT('Pembayaran Hutang Pembelian ', pembelian_historibayar.no_bukti, ' via ', COALESCE(bank.nama_bank, 'Kas/Bank')) as keterangan"),
                DB::raw('0 as jml_debet'),
                'pembelian_historibayar.jumlah as jml_kredit',
                DB::raw('0 as saldo_awal_val'),
                DB::raw('3 as urutan')
            );

        // 8b. Pelunasan Hutang Pembelian (Debet Hutang Usaha 2-11101)
        $bayarHutangPembelianSub = DB::table('pembelian_historibayar')
            ->join('pembelian', 'pembelian_historibayar.no_bukti', '=', 'pembelian.no_bukti')
            ->leftJoin('supplier', 'pembelian.kode_supplier', '=', 'supplier.kode_supplier')
            ->leftJoin('bank', 'pembelian_historibayar.kode_bank', '=', 'bank.kode_bank')
            ->whereBetween('pembelian_historibayar.tanggal', [sprintf('%04d-%02d-01', $tahun, $bulan), $sampai])
            ->where('pembelian.jenis_transaksi', 'K')
            ->where(function($q) {
                $q->whereNull('pembelian.kategori_pembelian')
                  ->orWhere('pembelian.kategori_pembelian', '!=', 'I');
            })
            ->where(function($q) {
                $q->whereNull('pembelian.status_uang_muka')
                  ->orWhere('pembelian.status_uang_muka', '!=', 1);
            })
            ->select(
                DB::raw("'2-11101' as kode_akun"),
                'pembelian_historibayar.tanggal',
                'pembelian_historibayar.no_bukti',
                DB::raw("CONCAT('KAS / BANK - ', COALESCE(bank.nama_bank, 'KAS')) as sumber"),
                DB::raw("CONCAT('Pelunasan Hutang ', COALESCE(supplier.nama_supplier, ''), ' via ', COALESCE(bank.nama_bank, 'Kas/Bank')) as keterangan"),
                'pembelian_historibayar.jumlah as jml_debet',
                DB::raw('0 as jml_kredit'),
                DB::raw('0 as saldo_awal_val'),
                DB::raw('3 as urutan')
            );

        // 9. Pembayaran Biaya (Kas/Bank keluar)
        $bayarBiayaSub = DB::table('biaya_historibayar')
            ->leftJoin('bank', 'biaya_historibayar.kode_bank', '=', 'bank.kode_bank')
            ->whereBetween('biaya_historibayar.tanggal', [sprintf('%04d-%02d-01', $tahun, $bulan), $sampai])
            ->select(
                DB::raw("CASE 
                    WHEN bank.kode_akun IN ('1-11101', '1-11102', '1-11103', '1-11104', '1-11105') THEN bank.kode_akun
                    WHEN bank.nama_bank LIKE '%BCA%' THEN '1-11103'
                    WHEN bank.nama_bank LIKE '%BNI%' THEN '1-11104'
                    WHEN bank.nama_bank LIKE '%BSI%' THEN '1-11105'
                    WHEN bank.nama_bank LIKE '%KAS KECIL%' THEN '1-11102'
                    ELSE '1-11101'
                END as kode_akun"),
                'biaya_historibayar.tanggal',
                'biaya_historibayar.no_bukti',
                DB::raw("'BAYAR BIAYA' as sumber"),
                DB::raw("CONCAT('Pembayaran Biaya ', COALESCE(biaya_historibayar.keterangan, '')) as keterangan"),
                DB::raw('0 as jml_debet'),
                'biaya_historibayar.jumlah as jml_kredit',
                DB::raw('0 as saldo_awal_val'),
                DB::raw('3 as urutan')
            );

        // 10. Transaksi Jurnal Umum
        $jurnalUmumSub = DB::table('accounting_jurnalumum')
            ->whereBetween('accounting_jurnalumum.tanggal', [sprintf('%04d-%02d-01', $tahun, $bulan), $sampai])
            ->select(
                'accounting_jurnalumum.kode_akun',
                'accounting_jurnalumum.tanggal',
                'accounting_jurnalumum.kode_ju as no_bukti',
                DB::raw("'JURNAL UMUM' as sumber"),
                'accounting_jurnalumum.keterangan',
                DB::raw("CASE WHEN accounting_jurnalumum.debet_kredit = 'D' THEN accounting_jurnalumum.jumlah ELSE 0 END as jml_debet"),
                DB::raw("CASE WHEN accounting_jurnalumum.debet_kredit = 'K' THEN accounting_jurnalumum.jumlah ELSE 0 END as jml_kredit"),
                DB::raw('0 as saldo_awal_val'),
                DB::raw('2 as urutan')
            );

        // 11. PPN Masukan (1-11501) dari Pembelian yang PPN Aktif
        // Rumus: dpp = (jumlah*harga) * 100/111
        //        dpp_lain = dpp * 11/12
        //        ppn = dpp_lain * 0.12
        $ppnMasukanSub = DB::table('pembelian_detail')
            ->join('pembelian', 'pembelian_detail.no_bukti', '=', 'pembelian.no_bukti')
            ->whereBetween('pembelian.tanggal', [sprintf('%04d-%02d-01', $tahun, $bulan), $sampai])
            ->where('pembelian.ppn', '1')
            ->where('pembelian_detail.kode_transaksi', 'PMB')
            ->select(
                DB::raw("'1-11501' as kode_akun"),
                'pembelian.tanggal',
                'pembelian.no_bukti',
                DB::raw("'PEMBELIAN' as sumber"),
                DB::raw("CONCAT('PPN Masukan - ', COALESCE(pembelian_detail.keterangan, 'Pembelian Barang')) as keterangan"),
                DB::raw('((((pembelian_detail.jumlah * pembelian_detail.harga) * 100 / 111) * 11 / 12) * 0.12) as jml_debet'),
                DB::raw('0 as jml_kredit'),
                DB::raw('0 as saldo_awal_val'),
                DB::raw('2 as urutan')
            );

        // 12. Hutang Usaha (2-11101) dari Pembelian Kredit
        // Untuk Import + PPN: hutang = DPP (subtotal * 100/111)
        // Untuk Lokal / non-PPN: hutang = subtotal + penyesuaian
        $hutangPembelianSub = DB::table('pembelian_detail')
            ->join('pembelian', 'pembelian_detail.no_bukti', '=', 'pembelian.no_bukti')
            ->leftJoin('supplier', 'pembelian.kode_supplier', '=', 'supplier.kode_supplier')
            ->whereBetween('pembelian.tanggal', [sprintf('%04d-%02d-01', $tahun, $bulan), $sampai])
            ->where('pembelian.jenis_transaksi', 'K')
            ->where(function($q) {
                $q->whereNull('pembelian.kategori_pembelian')
                  ->orWhere('pembelian.kategori_pembelian', '!=', 'I');
            })
            ->where(function($q) {
                $q->whereNull('pembelian.status_uang_muka')
                  ->orWhere('pembelian.status_uang_muka', '!=', 1);
            })
            ->where('pembelian_detail.kode_transaksi', 'PMB')
            ->select(
                DB::raw("'2-11101' as kode_akun"),
                'pembelian.tanggal',
                'pembelian.no_bukti',
                DB::raw("'PEMBELIAN' as sumber"),
                DB::raw("CONCAT('Hutang Pembelian - ', COALESCE(supplier.nama_supplier, '')) as keterangan"),
                DB::raw('0 as jml_debet'),
                DB::raw('CASE WHEN pembelian.kategori_pembelian = "I" AND pembelian.ppn = "1"
                    THEN ((pembelian_detail.jumlah * pembelian_detail.harga) * 100 / 111)
                    ELSE ((pembelian_detail.jumlah * pembelian_detail.harga) + pembelian_detail.penyesuaian)
                END as jml_kredit'),
                DB::raw('0 as saldo_awal_val'),
                DB::raw('2 as urutan')
            );

        // 13. PPN Masukan (1-11501) dari Biaya yang PPN Aktif
        // Rumus sama: dpp_lain * 0.12 = ((jumlah*harga) * 100/111 * 11/12) * 0.12
        $ppnMasukanBiayaSub = DB::table('biaya_detail')
            ->join('biaya', 'biaya_detail.no_bukti', '=', 'biaya.no_bukti')
            ->whereBetween('biaya.tanggal', [sprintf('%04d-%02d-01', $tahun, $bulan), $sampai])
            ->where('biaya.ppn', '1')
            ->select(
                DB::raw("'1-11501' as kode_akun"),
                'biaya.tanggal',
                'biaya.no_bukti',
                DB::raw("'BIAYA' as sumber"),
                DB::raw("CONCAT('PPN Masukan Biaya - ', COALESCE(biaya_detail.keterangan, 'Biaya Operasional')) as keterangan"),
                DB::raw('((((biaya_detail.jumlah * biaya_detail.harga) * 100 / 111) * 11 / 12) * 0.12) as jml_debet'),
                DB::raw('0 as jml_kredit'),
                DB::raw('0 as saldo_awal_val'),
                DB::raw('2 as urutan')
            );

        // Satukan semua aliran data
        $unionQuery = $saldoAwalSub
            ->unionAll($biayaSub)
            ->unionAll($pembelianSub)
            ->unionAll($penjualanSub)
            ->unionAll($ppnKeluaranSub)
            ->unionAll($piutangPenjualanSub)
            ->unionAll($bayarPiutangSub)
            ->unionAll($kasBankPiutangSub)
            ->unionAll($bayarPembelianSub)
            ->unionAll($bayarHutangPembelianSub)
            ->unionAll($bayarBiayaSub)
            ->unionAll($jurnalUmumSub)
            ->unionAll($ppnMasukanSub)
            ->unionAll($hutangPembelianSub)
            ->unionAll($ppnMasukanBiayaSub);


        // FORMAT 1: BUKU BESAR
        if ($format == '1') {
            $parents = DB::table('coa')->whereNotNull('sub_akun')->where('sub_akun', '!=', '')->pluck('sub_akun')->unique()->toArray();
            $coaQuery = Coa::whereNotIn('kode_akun', $parents)->orderBy('kode_akun', 'asc');
            if (!empty($request->kode_akun_dari) && !empty($request->kode_akun_sampai)) {
                $coaQuery->whereBetween('kode_akun', [$request->kode_akun_dari, $request->kode_akun_sampai]);
            }
            $coaList = $coaQuery->get();

            // Ambil data Saldo Awal periode (kode_sa: SA{bulan}{tahun})
            $saldoAwalMap = DB::table('bukubesar_saldoawal_detail')
                ->join('bukubesar_saldoawal', 'bukubesar_saldoawal_detail.kode_saldo_awal', '=', 'bukubesar_saldoawal.kode_saldo_awal')
                ->where('bukubesar_saldoawal.kode_saldo_awal', $kode_sa)
                ->pluck('bukubesar_saldoawal_detail.jumlah', 'bukubesar_saldoawal_detail.kode_akun')
                ->toArray();

            // Ambil mutasi transaksi sebelum tanggal 'dari' (jika filter 'dari' bukan tanggal 1)
            $mutasiSebelum = DB::query()->fromSub($unionQuery, 'u')
                ->where('sumber', '!=', 'SALDO AWAL')
                ->where('tanggal', '<', $dari)
                ->selectRaw('kode_akun, SUM(jml_debet) as total_debet_prev, SUM(jml_kredit) as total_kredit_prev')
                ->groupBy('kode_akun')
                ->get()
                ->keyBy('kode_akun');

            // Ambil mutasi dalam periode 'dari' s/d 'sampai'
            $mutasiPeriode = DB::query()->fromSub($unionQuery, 'u')
                ->whereBetween('tanggal', [$dari, $sampai])
                ->where('sumber', '!=', 'SALDO AWAL')
                ->orderBy('kode_akun')
                ->orderBy('tanggal')
                ->orderBy('urutan')
                ->orderBy('no_bukti')
                ->get()
                ->groupBy('kode_akun');

            $data['coaList'] = $coaList;
            $data['saldoAwalMap'] = $saldoAwalMap;
            $data['mutasiSebelum'] = $mutasiSebelum;
            $data['mutasiPeriode'] = $mutasiPeriode;

            if (isset($_POST['exportButton'])) {
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition: attachment; filename=Buku_Besar_{$dari}_{$sampai}.xls");
            }
            return view('accounting.laporan.lk.bukubesar_cetak', $data);
        }

        // FORMAT 2: NERACA
        if ($format == '2') {
            // Hitung akumulasi per kode akun sampai periode $sampai
            $allSums = DB::query()->fromSub($unionQuery, 'u')
                ->where('tanggal', '<=', $sampai)
                ->selectRaw('kode_akun, SUM(saldo_awal_val) as sa, SUM(jml_debet) as debet, SUM(jml_kredit) as kredit')
                ->groupBy('kode_akun')
                ->get()
                ->keyBy('kode_akun');

            // Hitung Laba Bersih Tahun Berjalan (4 - 5 - 6)
            $pendapatanTotal = 0;
            $hppTotal = 0;
            $biayaTotal = 0;

            foreach ($allSums as $k => $row) {
                $prefix = substr($k, 0, 1);
                $net = ((float) $row->sa) + ((float) $row->debet) - ((float) $row->kredit);
                if ($prefix === '4') {
                    $pendapatanTotal += ((float)$row->kredit - (float)$row->debet);
                } elseif ($prefix === '5') {
                    $hppTotal += ((float)$row->debet - (float)$row->kredit);
                } elseif ($prefix === '6') {
                    $biayaTotal += ((float)$row->debet - (float)$row->kredit);
                }
            }

            $labaBerjalan = $pendapatanTotal - $hppTotal - $biayaTotal;

            $parents = DB::table('coa')->whereNotNull('sub_akun')->where('sub_akun', '!=', '')->pluck('sub_akun')->unique()->toArray();
            $allParentsMap = array_flip($parents);

            // Ambil akun Aktiva (1), Kewajiban (2), Ekuitas (3)
            $neracaAccounts = Coa::whereRaw('LEFT(kode_akun, 1) IN (1, 2, 3)')
                ->orderBy('kode_akun', 'asc')
                ->get()
                ->map(function ($acc) use ($allSums, $labaBerjalan, $allParentsMap) {
                    $row = $allSums[$acc->kode_akun] ?? null;
                    $prefix = substr($acc->kode_akun, 0, 1);
                    if ($prefix === '1') {
                        // Saldo normal Aktiva: Debet
                        $saldo = $row ? ((float)$row->sa + (float)$row->debet - (float)$row->kredit) : 0;
                    } else {
                        // Saldo normal Kewajiban & Ekuitas: Kredit
                        $saldo = $row ? ((float)$row->sa + (float)$row->kredit - (float)$row->debet) : 0;
                    }

                    // Akun Laba Tahun Berjalan (3-11300)
                    if ($acc->kode_akun === '3-11300') {
                        $saldo += $labaBerjalan;
                    }

                    $acc->saldo_akhir = $saldo;
                    $acc->is_leaf = !isset($allParentsMap[$acc->kode_akun]);
                    return $acc;
                });

            $data['neraca'] = $neracaAccounts;
            $data['labaBerjalan'] = $labaBerjalan;

            if (isset($_POST['exportButton'])) {
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition: attachment; filename=Neraca_{$sampai}.xls");
            }
            return view('accounting.laporan.lk.neraca_cetak', $data);
        }

        // FORMAT 3: LABA RUGI
        if ($format == '3') {
            $parents = DB::table('coa')->whereNotNull('sub_akun')->where('sub_akun', '!=', '')->pluck('sub_akun')->unique()->toArray();
            $allParentsMap = array_flip($parents);

            $mutasiLR = DB::query()->fromSub($unionQuery, 'u')
                ->whereBetween('tanggal', [$dari, $sampai])
                ->selectRaw('kode_akun, SUM(jml_debet) as debet, SUM(jml_kredit) as kredit')
                ->groupBy('kode_akun')
                ->get()
                ->keyBy('kode_akun');

            $lrAccounts = Coa::whereRaw('LEFT(kode_akun, 1) IN (4, 5, 6)')
                ->orderBy('kode_akun', 'asc')
                ->get()
                ->map(function ($acc) use ($mutasiLR, $allParentsMap) {
                    $row = $mutasiLR[$acc->kode_akun] ?? null;
                    $prefix = substr($acc->kode_akun, 0, 1);
                    if ($prefix === '4') {
                        // Pendapatan (Kredit - Debet)
                        $acc->total = $row ? ((float)$row->kredit - (float)$row->debet) : 0;
                    } else {
                        // Beban / HPP (Debet - Kredit)
                        $acc->total = $row ? ((float)$row->debet - (float)$row->kredit) : 0;
                    }
                    $acc->is_leaf = !isset($allParentsMap[$acc->kode_akun]);
                    return $acc;
                });

            // Perhitungan Persediaan Awal & Akhir Bahan Baku dan Kemasan (1-11302 & 1-11303)
            $saldoAwalMap = DB::table('bukubesar_saldoawal_detail')
                ->join('bukubesar_saldoawal', 'bukubesar_saldoawal_detail.kode_saldo_awal', '=', 'bukubesar_saldoawal.kode_saldo_awal')
                ->where('bukubesar_saldoawal.kode_saldo_awal', $kode_sa)
                ->whereIn('bukubesar_saldoawal_detail.kode_akun', ['1-11302', '1-11303'])
                ->pluck('bukubesar_saldoawal_detail.jumlah', 'bukubesar_saldoawal_detail.kode_akun')
                ->toArray();

            $mutasiSebelumPersediaan = DB::query()->fromSub($unionQuery, 'u')
                ->where('sumber', '!=', 'SALDO AWAL')
                ->whereIn('kode_akun', ['1-11302', '1-11303'])
                ->where('tanggal', '<', $dari)
                ->selectRaw('kode_akun, SUM(jml_debet) as debet, SUM(jml_kredit) as kredit')
                ->groupBy('kode_akun')
                ->get()
                ->keyBy('kode_akun');

            $mutasiPeriodePersediaan = DB::query()->fromSub($unionQuery, 'u')
                ->where('sumber', '!=', 'SALDO AWAL')
                ->whereIn('kode_akun', ['1-11302', '1-11303'])
                ->whereBetween('tanggal', [$dari, $sampai])
                ->selectRaw('kode_akun, SUM(jml_debet) as debet, SUM(jml_kredit) as kredit')
                ->groupBy('kode_akun')
                ->get()
                ->keyBy('kode_akun');

            // 1-11302 (Bahan Baku)
            $sa_bb = ($saldoAwalMap['1-11302'] ?? 0) + ($mutasiSebelumPersediaan['1-11302']->debet ?? 0) - ($mutasiSebelumPersediaan['1-11302']->kredit ?? 0);
            $ak_bb = $sa_bb + ($mutasiPeriodePersediaan['1-11302']->debet ?? 0) - ($mutasiPeriodePersediaan['1-11302']->kredit ?? 0);
            $pemb_bb = isset($mutasiLR['5-11101']) ? ((float)$mutasiLR['5-11101']->debet - (float)$mutasiLR['5-11101']->kredit) : 0;
            $used_bb = $sa_bb + $pemb_bb - $ak_bb;

            // 1-11303 (Bahan Kemasan)
            $sa_bk = ($saldoAwalMap['1-11303'] ?? 0) + ($mutasiSebelumPersediaan['1-11303']->debet ?? 0) - ($mutasiSebelumPersediaan['1-11303']->kredit ?? 0);
            $ak_bk = $sa_bk + ($mutasiPeriodePersediaan['1-11303']->debet ?? 0) - ($mutasiPeriodePersediaan['1-11303']->kredit ?? 0);
            $pemb_bk = isset($mutasiLR['5-11102']) ? ((float)$mutasiLR['5-11102']->debet - (float)$mutasiLR['5-11102']->kredit) : 0;
            $used_bk = $sa_bk + $pemb_bk - $ak_bk;

            $data['hppBahan'] = [
                'sa_bb' => $sa_bb,
                'pemb_bb' => $pemb_bb,
                'ak_bb' => $ak_bb,
                'used_bb' => $used_bb,
                'sa_bk' => $sa_bk,
                'pemb_bk' => $pemb_bk,
                'ak_bk' => $ak_bk,
                'used_bk' => $used_bk,
            ];

            $data['lrAccounts'] = $lrAccounts;

            if (isset($_POST['exportButton'])) {
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition: attachment; filename=Laba_Rugi_{$dari}_{$sampai}.xls");
            }
            return view('accounting.laporan.lk.labarugi_cetak', $data);
        }

        return redirect()->back()->with(['error' => 'Format laporan tidak valid.']);
    }

    public function cetakjurnalumum(Request $request)
    {
        $request->validate([
            'dari' => 'required|date',
            'sampai' => 'required|date',
        ]);

        $query = DB::table('accounting_jurnalumum')
            ->join('coa', 'accounting_jurnalumum.kode_akun', '=', 'coa.kode_akun')
            ->whereBetween('accounting_jurnalumum.tanggal', [$request->dari, $request->sampai]);

        if (!empty($request->kode_akun)) {
            $query->where('accounting_jurnalumum.kode_akun', $request->kode_akun);
        }

        $query->orderBy('accounting_jurnalumum.tanggal', 'asc');
        $query->orderBy('accounting_jurnalumum.kode_ju', 'asc');
        $jurnalumum = $query->select('accounting_jurnalumum.*', 'coa.nama_akun')->get();

        $data['jurnalumum'] = $jurnalumum;
        $data['dari'] = $request->dari;
        $data['sampai'] = $request->sampai;

        if (isset($_POST['exportButton'])) {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Jurnal_Umum_{$request->dari}_{$request->sampai}.xls");
        }

        return view('accounting.laporan.jurnalumum_cetak', $data);
    }
}
