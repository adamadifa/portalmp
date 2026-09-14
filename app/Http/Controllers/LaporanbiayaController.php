<?php

namespace App\Http\Controllers;

use App\Models\Biaya;
use App\Models\Detailbiaya;
use App\Models\Historibayarbiaya;
use App\Models\Supplier;
use App\Models\Bank;
use App\Models\Cabang;
use App\Models\Coa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class LaporanbiayaController extends Controller
{
    public function index()
    {
        $data['supplier'] = Supplier::orderBy('nama_supplier')->get();
        $data['bank'] = Bank::orderBy('kode_bank')->get();
        $data['cabang'] = Cabang::orderBy('kode_cabang')->get();
        $data['coa'] = Coa::orderBy('kode_akun')->get();
        $data['akun'] = DB::table('biaya_detail')
            ->join('coa', 'biaya_detail.kode_akun', '=', 'coa.kode_akun')
            ->select('biaya_detail.kode_akun', 'coa.nama_akun')
            ->groupBy('biaya_detail.kode_akun', 'coa.nama_akun')
            ->orderBy('biaya_detail.kode_akun')
            ->get();

        return view('biaya.laporan.index', $data);
    }

    public function cetakbiaya(Request $request)
    {
        $request->validate([
            'dari' => 'required|date',
            'sampai' => 'required|date',
        ]);

        $query = Detailbiaya::query();
        $query->select(
            'biaya_detail.*',
            'biaya.tanggal',
            'biaya.kode_supplier',
            'biaya.ppn',
            'biaya.no_fak_pajak',
            'biaya.tanggal_jatuh_tempo',
            'biaya.created_at as created_at_header',
            'supplier.nama_supplier',
            'coa.nama_akun'
        );
        $query->join('biaya', 'biaya_detail.no_bukti', '=', 'biaya.no_bukti');
        $query->leftJoin('supplier', 'biaya.kode_supplier', '=', 'supplier.kode_supplier');
        $query->join('coa', 'biaya_detail.kode_akun', '=', 'coa.kode_akun');
        $query->whereBetween('biaya.tanggal', [$request->dari, $request->sampai]);

        if (!empty($request->kode_supplier)) {
            $query->where('biaya.kode_supplier', $request->kode_supplier);
        }

        if (!empty($request->kode_akun)) {
            $query->where('biaya_detail.kode_akun', $request->kode_akun);
        }

        if (!empty($request->kode_cabang)) {
            $query->where('biaya_detail.kode_cabang', $request->kode_cabang);
        }

        if ($request->ppn !== null && $request->ppn !== '') {
            $query->where('biaya.ppn', $request->ppn);
        }

        $query->orderBy('biaya.tanggal', 'asc');
        $query->orderBy('biaya.no_bukti', 'asc');
        $data['biaya'] = $query->get();

        $data['dari'] = $request->dari;
        $data['sampai'] = $request->sampai;
        $data['supplier'] = !empty($request->kode_supplier) ? Supplier::where('kode_supplier', $request->kode_supplier)->first() : null;

        if ($request->has('exportButton')) {
            $filename = 'Laporan_Biaya_' . date('Ymd_His') . '.xls';
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header("Cache-Control: max-age=0");
        }

        return view('biaya.laporan.biaya_cetak', $data);
    }

    public function cetakpembayaran(Request $request)
    {
        $request->validate([
            'dari' => 'required|date',
            'sampai' => 'required|date',
        ]);

        $query = Historibayarbiaya::query();
        $query->select(
            'biaya_historibayar.*',
            'biaya.tanggal as tanggal_biaya',
            'biaya.kode_supplier',
            'supplier.nama_supplier',
            'bank.nama_bank'
        );
        $query->join('biaya', 'biaya_historibayar.no_bukti', '=', 'biaya.no_bukti');
        $query->leftJoin('supplier', 'biaya.kode_supplier', '=', 'supplier.kode_supplier');
        $query->join('bank', 'biaya_historibayar.kode_bank', '=', 'bank.kode_bank');
        $query->whereBetween('biaya_historibayar.tanggal', [$request->dari, $request->sampai]);

        if (!empty($request->kode_supplier)) {
            $query->where('biaya.kode_supplier', $request->kode_supplier);
        }

        if (!empty($request->kode_bank)) {
            $query->where('biaya_historibayar.kode_bank', $request->kode_bank);
        }

        if (!empty($request->kode_cabang)) {
            $query->where('biaya_historibayar.kode_cabang', $request->kode_cabang);
        }

        $query->orderBy('biaya_historibayar.tanggal', 'asc');
        $data['pembayaran'] = $query->get();

        $data['dari'] = $request->dari;
        $data['sampai'] = $request->sampai;
        $data['bank'] = Bank::orderBy('kode_bank')->get();
        $data['supplier'] = !empty($request->kode_supplier) ? Supplier::where('kode_supplier', $request->kode_supplier)->first() : null;

        if ($request->has('exportButton')) {
            $filename = 'Laporan_Pembayaran_Biaya_' . date('Ymd_His') . '.xls';
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header("Cache-Control: max-age=0");
        }

        return view('biaya.laporan.pembayaran_cetak', $data);
    }

    public function cetakrekapakun(Request $request)
    {
        $request->validate([
            'dari' => 'required|date',
            'sampai' => 'required|date',
        ]);

        $query = DB::table('biaya_detail')
            ->join('biaya', 'biaya_detail.no_bukti', '=', 'biaya.no_bukti')
            ->join('coa', 'biaya_detail.kode_akun', '=', 'coa.kode_akun')
            ->whereBetween('biaya.tanggal', [$request->dari, $request->sampai])
            ->select(
                'biaya_detail.kode_akun',
                'coa.nama_akun',
                DB::raw('SUM((biaya_detail.jumlah * biaya_detail.harga) + biaya_detail.penyesuaian) as total_biaya'),
                DB::raw('COUNT(DISTINCT biaya_detail.no_bukti) as jumlah_transaksi')
            )
            ->groupBy('biaya_detail.kode_akun', 'coa.nama_akun')
            ->orderBy('biaya_detail.kode_akun');

        if (!empty($request->kode_cabang)) {
            $query->where('biaya_detail.kode_cabang', $request->kode_cabang);
        }

        $data['rekap'] = $query->get();
        $data['dari'] = $request->dari;
        $data['sampai'] = $request->sampai;

        if ($request->has('exportButton')) {
            $filename = 'Laporan_Rekap_Akun_Biaya_' . date('Ymd_His') . '.xls';
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header("Cache-Control: max-age=0");
        }

        return view('biaya.laporan.rekapakun_cetak', $data);
    }
}
