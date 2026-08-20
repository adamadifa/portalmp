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

    public function cetakkartupiutang(Request $request)
    {
        abort_if(!auth()->user()->can('laporanmarketing.index'), 403);

        $request->validate([
            'dari' => 'required|date',
            'sampai' => 'required|date',
        ]);

        $query = DB::table('marketing_penjualan as p')
            ->select(
                'p.no_bukti',
                'p.tanggal',
                'p.kode_pelanggan',
                'cust.nama_pelanggan',
                'cust.alamat_pelanggan as alamat',
                'p.kode_cabang'
            )
            ->join('pelanggan as cust', 'p.kode_pelanggan', '=', 'cust.kode_pelanggan')
            ->where('p.jenis_transaksi', 'K'); // Hanya Kredit (Piutang)

        if (!empty($request->kode_pelanggan)) {
            $query->where('p.kode_pelanggan', $request->kode_pelanggan);
        }

        // Ambil invoice sebelum atau selama periode
        $query->where(function($q) use ($request) {
            $q->whereBetween('p.tanggal', [$request->dari, $request->sampai])
              ->orWhere('p.tanggal', '<', $request->dari);
        });

        $penjualan = $query->orderBy('p.tanggal')->orderBy('p.no_bukti')->get();

        $kartupiutang = [];
        foreach ($penjualan as $p) {
            // Hitung total DPP
            $dpp = DB::table('marketing_penjualan_detail')
                ->where('no_bukti', $p->no_bukti)
                ->sum('subtotal') ?? 0;
            
            $ppn = $dpp * 0.11;
            $total_piutang = $dpp + $ppn;

            // Hitung pembayaran lalu (sebelum $dari)
            $bayar_lalu = DB::table('marketing_penjualan_historibayar')
                ->where('no_bukti_penjualan', $p->no_bukti)
                ->where('tanggal', '<', $request->dari)
                ->sum('jumlah') ?? 0;

            // Hitung pembayaran kini (selama periode)
            $bayar_kini = DB::table('marketing_penjualan_historibayar')
                ->where('no_bukti_penjualan', $p->no_bukti)
                ->whereBetween('tanggal', [$request->dari, $request->sampai])
                ->sum('jumlah') ?? 0;

            $is_within_period = ($p->tanggal >= $request->dari && $p->tanggal <= $request->sampai);

            $saldo_awal = 0;
            if ($p->tanggal < $request->dari) {
                $saldo_awal = $total_piutang - $bayar_lalu;
            }

            // Jika invoice lama dan sudah lunas sebelum periode mulai, lewati
            if ($p->tanggal < $request->dari && $saldo_awal <= 0.01) {
                continue;
            }

            $bruto = $is_within_period ? $dpp : 0;
            $ppn_kini = $is_within_period ? $ppn : 0;
            $netto = $is_within_period ? $total_piutang : 0;
            $saldo_akhir = $saldo_awal + $netto - $bayar_kini;

            $kartupiutang[] = (object)[
                'no_bukti' => $p->no_bukti,
                'tanggal' => $p->tanggal,
                'kode_pelanggan' => $p->kode_pelanggan,
                'nama_pelanggan' => $p->nama_pelanggan,
                'alamat' => $p->alamat,
                'kode_cabang' => $p->kode_cabang ?? 'PST',
                'total_piutang' => $total_piutang,
                'saldo_awal' => $saldo_awal,
                'bruto' => $bruto,
                'ppn' => $ppn_kini,
                'netto' => $netto,
                'jmlbayar' => $bayar_kini,
                'saldo_akhir' => $saldo_akhir
            ];
        }

        $data['kartupiutang'] = $kartupiutang;
        $data['dari'] = $request->dari;
        $data['sampai'] = $request->sampai;
        $data['selected_pelanggan'] = !empty($request->kode_pelanggan) ? Pelanggan::where('kode_pelanggan', $request->kode_pelanggan)->first() : null;

        if ($request->has('exportButton')) {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Kartu Piutang Marketing $request->dari-$request->sampai.xls");
        }

        return view('marketing.laporan.kartupiutang_cetak', $data);
    }
}
