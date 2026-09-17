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

        // 3. Transaksi Pembelian
        $pembelianSub = DB::table('pembelian_detail')
            ->join('pembelian', 'pembelian_detail.no_bukti', '=', 'pembelian.no_bukti')
            ->whereBetween('pembelian.tanggal', [sprintf('%04d-%02d-01', $tahun, $bulan), $sampai])
            ->select(
                'pembelian_detail.kode_akun',
                'pembelian.tanggal',
                'pembelian.no_bukti',
                DB::raw("'PEMBELIAN' as sumber"),
                DB::raw("COALESCE(pembelian_detail.keterangan, 'Pembelian Barang') as keterangan"),
                DB::raw('((pembelian_detail.jumlah * pembelian_detail.harga) + pembelian_detail.penyesuaian) as jml_debet'),
                DB::raw('0 as jml_kredit'),
                DB::raw('0 as saldo_awal_val'),
                DB::raw('2 as urutan')
            );

        // 4. Transaksi Penjualan Marketing
        $penjualanSub = DB::table('marketing_penjualan_detail')
            ->join('marketing_penjualan', 'marketing_penjualan_detail.no_bukti', '=', 'marketing_penjualan.no_bukti')
            ->whereBetween('marketing_penjualan.tanggal', [sprintf('%04d-%02d-01', $tahun, $bulan), $sampai])
            ->select(
                DB::raw("'4-11101' as kode_akun"),
                'marketing_penjualan.tanggal',
                'marketing_penjualan.no_bukti',
                DB::raw("'PENJUALAN' as sumber"),
                DB::raw("'Penjualan Produk Marketing' as keterangan"),
                DB::raw('0 as jml_debet'),
                'marketing_penjualan_detail.subtotal as jml_kredit',
                DB::raw('0 as saldo_awal_val'),
                DB::raw('2 as urutan')
            );

        // 5. Pembayaran Hutang Pembelian (Kas/Bank keluar)
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

        // 6. Pembayaran Biaya (Kas/Bank keluar)
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

        // Satukan semua aliran data
        $unionQuery = $saldoAwalSub
            ->unionAll($biayaSub)
            ->unionAll($pembelianSub)
            ->unionAll($penjualanSub)
            ->unionAll($bayarPembelianSub)
            ->unionAll($bayarBiayaSub);

        // FORMAT 1: BUKU BESAR
        if ($format == '1') {
            $coaQuery = Coa::orderBy('kode_akun', 'asc');
            if (!empty($request->kode_akun_dari) && !empty($request->kode_akun_sampai)) {
                $coaQuery->whereBetween('kode_akun', [$request->kode_akun_dari, $request->kode_akun_sampai]);
            }
            $coaList = $coaQuery->get();

            // Ambil mutasi sebelum tanggal 'dari' (untuk saldo awal berjalan)
            $mutasiSebelum = DB::query()->fromSub($unionQuery, 'u')
                ->where('tanggal', '<', $dari)
                ->selectRaw('kode_akun, SUM(saldo_awal_val) as init_val, SUM(jml_debet) as total_debet_prev, SUM(jml_kredit) as total_kredit_prev')
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

            // Ambil akun Aktiva (1), Kewajiban (2), Ekuitas (3)
            $neracaAccounts = Coa::whereRaw('LEFT(kode_akun, 1) IN (1, 2, 3)')
                ->orderBy('kode_akun', 'asc')
                ->get()
                ->map(function ($acc) use ($allSums, $labaBerjalan) {
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
            $mutasiLR = DB::query()->fromSub($unionQuery, 'u')
                ->whereBetween('tanggal', [$dari, $sampai])
                ->selectRaw('kode_akun, SUM(jml_debet) as debet, SUM(jml_kredit) as kredit')
                ->groupBy('kode_akun')
                ->get()
                ->keyBy('kode_akun');

            $lrAccounts = Coa::whereRaw('LEFT(kode_akun, 1) IN (4, 5, 6)')
                ->orderBy('kode_akun', 'asc')
                ->get()
                ->map(function ($acc) use ($mutasiLR) {
                    $row = $mutasiLR[$acc->kode_akun] ?? null;
                    $prefix = substr($acc->kode_akun, 0, 1);
                    if ($prefix === '4') {
                        // Pendapatan (Kredit - Debet)
                        $acc->total = $row ? ((float)$row->kredit - (float)$row->debet) : 0;
                    } else {
                        // Beban / HPP (Debet - Kredit)
                        $acc->total = $row ? ((float)$row->debet - (float)$row->kredit) : 0;
                    }
                    return $acc;
                });

            $data['lrAccounts'] = $lrAccounts;

            if (isset($_POST['exportButton'])) {
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition: attachment; filename=Laba_Rugi_{$dari}_{$sampai}.xls");
            }
            return view('accounting.laporan.lk.labarugi_cetak', $data);
        }

        return Redirect::back()->with(['error' => 'Format laporan tidak valid.']);
    }
}
