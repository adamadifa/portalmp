<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\MarketingPenjualanDetail;
use App\Models\MarketingPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class LaporanmarketingController extends Controller
{
    public function index()
    {
        abort_if(!auth()->user()->can('laporanmarketing.index'), 403);

        $data['pelanggan'] = Pelanggan::orderBy('nama_pelanggan')->get();
        $data['produk'] = Produk::orderBy('nama_produk')->get();
        
        return view('marketing.laporan.index', $data);
    }

    public function cetakpenjualan(Request $request)
    {
        abort_if(!auth()->user()->can('laporanmarketing.index'), 403);

        $request->validate([
            'dari' => 'required|date',
            'sampai' => 'required|date',
        ]);

        $query = DB::table('marketing_penjualan_detail as d')
            ->select(
                'd.no_bukti',
                'p.tanggal',
                'p.kode_pelanggan',
                'cust.nama_pelanggan',
                'd.kode_produk',
                'prod.nama_produk',
                'prod.satuan',
                'd.jumlah as qty',
                'd.harga_dus as harga',
                'd.subtotal'
            )
            ->join('marketing_penjualan as p', 'd.no_bukti', '=', 'p.no_bukti')
            ->join('pelanggan as cust', 'p.kode_pelanggan', '=', 'cust.kode_pelanggan')
            ->join('produk as prod', 'd.kode_produk', '=', 'prod.kode_produk')
            ->whereBetween('p.tanggal', [$request->dari, $request->sampai]);

        if (!empty($request->kode_pelanggan)) {
            $query->where('p.kode_pelanggan', $request->kode_pelanggan);
        }

        if (!empty($request->kode_produk)) {
            $query->where('d.kode_produk', $request->kode_produk);
        }

        $query->orderBy('p.tanggal')
            ->orderBy('d.no_bukti');

        $data['penjualan'] = $query->get();
        $data['dari'] = $request->dari;
        $data['sampai'] = $request->sampai;
        $data['selected_pelanggan'] = !empty($request->kode_pelanggan) ? Pelanggan::where('kode_pelanggan', $request->kode_pelanggan)->first() : null;

        if ($request->has('exportButton')) {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Laporan Penjualan Marketing $request->dari-$request->sampai.xls");
        }

        return view('marketing.laporan.penjualan_cetak', $data);
    }

    public function cetakrekap(Request $request)
    {
        abort_if(!auth()->user()->can('laporanmarketing.index'), 403);

        $request->validate([
            'dari' => 'required|date',
            'sampai' => 'required|date',
        ]);

        $query = DB::table('marketing_penjualan_detail as d')
            ->select(
                'd.kode_produk',
                'prod.nama_produk',
                'prod.satuan',
                DB::raw('SUM(d.jumlah) as total_qty'),
                DB::raw('SUM(d.harga_dus * d.jumlah) as total_dpp'),
                DB::raw('SUM((d.harga_dus * d.jumlah) * 0.11) as total_ppn'),
                DB::raw('SUM((d.harga_dus * d.jumlah) * 1.11) as total_jumlah')
            )
            ->join('marketing_penjualan as p', 'd.no_bukti', '=', 'p.no_bukti')
            ->join('produk as prod', 'd.kode_produk', '=', 'prod.kode_produk')
            ->whereBetween('p.tanggal', [$request->dari, $request->sampai]);

        if (!empty($request->kode_pelanggan)) {
            $query->where('p.kode_pelanggan', $request->kode_pelanggan);
        }

        $query->groupBy('d.kode_produk', 'prod.nama_produk', 'prod.satuan')
            ->orderBy('prod.nama_produk');

        $data['rekap'] = $query->get();
        $data['dari'] = $request->dari;
        $data['sampai'] = $request->sampai;
        $data['selected_pelanggan'] = !empty($request->kode_pelanggan) ? Pelanggan::where('kode_pelanggan', $request->kode_pelanggan)->first() : null;

        if ($request->has('exportButton')) {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Rekap Penjualan Marketing $request->dari-$request->sampai.xls");
        }

        return view('marketing.laporan.rekap_cetak', $data);
    }
}
