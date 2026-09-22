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
            'dari'          => 'required_if:formatlaporan,1,2,3|date',
            'sampai'        => 'required_if:formatlaporan,1,2,3|date',
        ]);

        $format = $request->formatlaporan;
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

        // 8. Pembayaran Hutang Pembelian (Kas/Bank keluar)
        $bayarPembelianSub = DB::table('pembelian_historibayar')
            ->leftJoin('bank', 'pembelian_historibayar.kode_bank', '=', 'bank.kode_bank')
            ->whereBetween('pembelian_historibayar.tanggal', [sprintf('%04d-%02d-01', $tahun, $bulan), $sampai])
            ->select(
                DB::raw("COALESCE(bank.kode_akun, '1-11101') as kode_akun"),
                'pembelian_historibayar.tanggal',
                'pembelian_historibayar.no_bukti',
                DB::raw("'BAYAR PEMBELIAN' as sumber"),
                DB::raw("'Pembayaran Hutang Pembelian' as keterangan"),
                DB::raw('0 as jml_debet'),
                'pembelian_historibayar.jumlah as jml_kredit',
                DB::raw('0 as saldo_awal_val'),
                DB::raw('3 as urutan')
            );

        // 9. Pembayaran Biaya (Kas/Bank keluar)
        $bayarBiayaSub = DB::table('biaya_historibayar')
            ->leftJoin('bank', 'biaya_historibayar.kode_bank', '=', 'bank.kode_bank')
            ->whereBetween('biaya_historibayar.tanggal', [sprintf('%04d-%02d-01', $tahun, $bulan), $sampai])
            ->select(
                DB::raw("COALESCE(bank.kode_akun, '1-11101') as kode_akun"),
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

        // Satukan semua aliran data
        $unionQuery = $saldoAwalSub
            ->unionAll($biayaSub)
            ->unionAll($pembelianSub)
            ->unionAll($penjualanSub)
            ->unionAll($ppnKeluaranSub)
            ->unionAll($piutangPenjualanSub)
            ->unionAll($bayarPiutangSub)
            ->unionAll($bayarPembelianSub)
            ->unionAll($bayarBiayaSub)
            ->unionAll($jurnalUmumSub)
            ->unionAll($ppnMasukanSub)
            ->unionAll($hutangPembelianSub);

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
