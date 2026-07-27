<?php

namespace App\Http\Controllers;

use App\Models\Barangpembelian;
use App\Models\Detailbarangkeluargudanglogistik;
use App\Models\Detailbarangmasukgudanglogistik;
use App\Models\Detailsaldoawalgudanglogistik;
use App\Models\Kategoribarangpembelian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class LaporangudanglogistikController extends Controller
{
    public function index()
    {
        $data['list_bulan'] = config('global.list_bulan');
        $data['start_year'] = config('global.start_year');
        $data['barang'] = Barangpembelian::where('kode_group', 'GDL')->orderBy('nama_barang')->get();
        $data['list_jenis_pengeluaran'] = config('gudanglogistik.list_jenis_pengeluaran');
        $data['kategori'] = Kategoribarangpembelian::where('kode_group', 'GDL')->orderBy('kode_kategori')->get();
        return view('gudanglogistik.laporan.index', $data);
    }

    public function cetakbarangmasuk(Request $request)
    {
        if (lockreport($request->dari) == "error") {
            return Redirect::back()->with(messageError('Data Tidak Ditemukan'));
        }

        $query = Detailbarangmasukgudanglogistik::query();
        $query->select('gudang_logistik_barang_masuk_detail.*', 'tanggal', 'nama_barang', 'satuan');
        $query->join('gudang_logistik_barang_masuk', 'gudang_logistik_barang_masuk_detail.no_bukti', '=', 'gudang_logistik_barang_masuk.no_bukti');
        $query->join('pembelian_barang', 'gudang_logistik_barang_masuk_detail.kode_barang', '=', 'pembelian_barang.kode_barang');
        $query->whereBetween('tanggal', [$request->dari, $request->sampai]);
        if (!empty($request->kode_barang_masuk)) {
            $query->where('gudang_logistik_barang_masuk_detail.kode_barang', $request->kode_barang_masuk);
        }
        $query->orderBy('tanggal');
        $query->orderBy('gudang_logistik_barang_masuk.no_bukti');
        $query->orderByRaw('cast(substr(gudang_logistik_barang_masuk_detail.kode_barang FROM 4) AS UNSIGNED)');
        
        $data['dari'] = $request->dari;
        $data['sampai'] = $request->sampai;
        $data['barangmasuk'] = $query->get();
        $data['barang'] = Barangpembelian::where('kode_barang', $request->kode_barang_masuk)->first();
        
        $time = date('H:i:s');
        if (isset($_POST['exportButton'])) {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Laporan Barang Masuk Gudang Logistik $request->dari-$request->sampai - $time.xls");
        }
        return view('gudanglogistik.laporan.barangmasuk_cetak', $data);
    }

    public function cetakbarangkeluar(Request $request)
    {
        if (lockreport($request->dari) == "error") {
            return Redirect::back()->with(messageError('Data Tidak Ditemukan'));
        }

        $query = Detailbarangkeluargudanglogistik::query();
        $query->select('gudang_logistik_barang_keluar_detail.*', 'tanggal', 'nama_barang', 'satuan', 'kode_jenis_pengeluaran');
        $query->join('gudang_logistik_barang_keluar', 'gudang_logistik_barang_keluar_detail.no_bukti', '=', 'gudang_logistik_barang_keluar.no_bukti');
        $query->join('pembelian_barang', 'gudang_logistik_barang_keluar_detail.kode_barang', '=', 'pembelian_barang.kode_barang');
        $query->whereBetween('tanggal', [$request->dari, $request->sampai]);
        if (!empty($request->kode_barang_keluar)) {
            $query->where('gudang_logistik_barang_keluar_detail.kode_barang', $request->kode_barang_keluar);
        }
        if (!empty($request->kode_jenis_pengeluaran)) {
            $query->where('gudang_logistik_barang_keluar.kode_jenis_pengeluaran', $request->kode_jenis_pengeluaran);
        }
        $query->orderBy('tanggal');
        $query->orderBy('gudang_logistik_barang_keluar.no_bukti');
        $query->orderByRaw('cast(substr(gudang_logistik_barang_keluar_detail.kode_barang FROM 4) AS UNSIGNED)');
        
        $data['dari'] = $request->dari;
        $data['sampai'] = $request->sampai;
        $data['barangkeluar'] = $query->get();
        $data['barang'] = Barangpembelian::where('kode_barang', $request->kode_barang_keluar)->first();
        $data['jenis_pengeluaran'] = config('gudanglogistik.jenis_pengeluaran');
        
        $time = date('H:i:s');
        if (isset($_POST['exportButton'])) {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Laporan Barang Keluar Gudang Logistik $request->dari-$request->sampai - $time.xls");
        }
        return view('gudanglogistik.laporan.barangkeluar_cetak', $data);
    }

    public function cetakpersediaan(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $dari = $tahun . "-" . $bulan . "-01";
        $sampai = date("Y-m-t", strtotime($dari));
        if (lockreport($dari) == "error") {
            return Redirect::back()->with(messageError('Data Tidak Ditemukan'));
        }

        $data['persediaan'] = Barangpembelian::select(
            'pembelian_barang.kode_barang',
            'nama_barang',
            'satuan',
            'kode_jenis_barang',
            'saldo_awal_qty',
            'opname_qty',
            'bm_qty',
            'bk_qty',
            DB::raw('IFNULL(saldo_awal_qty,0) + IFNULL(bm_qty,0) - IFNULL(bk_qty,0) as saldo_akhir_qty')
        )
        ->leftJoin(
            DB::raw("(
                SELECT gd.kode_barang, SUM(jumlah) AS saldo_awal_qty
                FROM gudang_logistik_saldoawal_detail gd
                INNER JOIN gudang_logistik_saldoawal g ON gd.kode_saldo_awal=g.kode_saldo_awal
                WHERE bulan = '$bulan' AND tahun = '$tahun'
                GROUP BY gd.kode_barang
            ) saldo_awal"),
            function ($join) {
                $join->on('pembelian_barang.kode_barang', '=', 'saldo_awal.kode_barang');
            }
        )
        ->leftJoin(
            DB::raw("(
                SELECT go.kode_barang, SUM(jumlah) AS opname_qty
                FROM gudang_logistik_opname_detail go
                INNER JOIN gudang_logistik_opname g ON go.kode_opname=g.kode_opname
                WHERE bulan = '$bulan' AND tahun = '$tahun'
                GROUP BY go.kode_barang
            ) opname"),
            function ($join) {
                $join->on('pembelian_barang.kode_barang', '=', 'opname.kode_barang');
            }
        )
        ->leftJoin(
            DB::raw("(
                SELECT gbd.kode_barang, SUM(jumlah) as bm_qty
                FROM gudang_logistik_barang_masuk_detail gbd
                INNER JOIN gudang_logistik_barang_masuk gb ON gbd.no_bukti = gb.no_bukti
                WHERE tanggal BETWEEN '$dari' AND '$sampai'
                GROUP BY gbd.kode_barang
            ) barangmasuk"),
            function ($join) {
                $join->on('pembelian_barang.kode_barang', '=', 'barangmasuk.kode_barang');
            }
        )
        ->leftJoin(
            DB::raw("(
                SELECT gkd.kode_barang, SUM(jumlah) as bk_qty
                FROM gudang_logistik_barang_keluar_detail gkd
                INNER JOIN gudang_logistik_barang_keluar gk ON gkd.no_bukti = gk.no_bukti
                WHERE tanggal BETWEEN '$dari' AND '$sampai'
                GROUP BY gkd.kode_barang
            ) barangkeluar"),
            function ($join) {
                $join->on('pembelian_barang.kode_barang', '=', 'barangkeluar.kode_barang');
            }
        )
        ->where(function ($query) {
            $query->where(function ($query) {
                $query->whereNotNull('saldo_awal_qty')
                    ->where('saldo_awal_qty', '<>', 0.0);
            })
            ->orWhere(function ($query) {
                $query->whereNotNull('opname_qty')
                    ->where('opname_qty', '<>', 0.0);
            })
            ->orWhere(function ($query) {
                $query->whereNotNull('bm_qty')
                    ->where('bm_qty', '<>', 0.0);
            })
            ->orWhere(function ($query) {
                $query->whereNotNull('bk_qty')
                    ->where('bk_qty', '<>', 0.0);
            });
        })
        ->where('pembelian_barang.kode_group', 'GDL')
        ->where('pembelian_barang.kode_kategori', $request->kode_kategori)
        ->orderBy('kode_jenis_barang')
        ->orderByRaw('cast(substr(pembelian_barang.kode_barang from 4) AS UNSIGNED)')
        ->orderBy('nama_barang')
        ->get();

        $data['dari'] = $dari;
        $data['sampai'] = $sampai;
        $data['kategori'] = Kategoribarangpembelian::where('kode_kategori', $request->kode_kategori)->first();
        
        $time = date('H:i:s');
        if (isset($_POST['exportButton'])) {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Laporan Persediaan Gudang Logistik $dari-$sampai- $time.xls");
        }
        return view('gudanglogistik.laporan.persediaan_cetak', $data);
    }

    public function cetakrekappersediaan(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $dari = $tahun . "-" . $bulan . "-01";
        $sampai = date("Y-m-t", strtotime($dari));
        if (lockreport($dari) == "error") {
            return Redirect::back()->with(messageError('Data Tidak Ditemukan'));
        }
        
        $data['dari'] = $dari;
        $data['sampai'] = $sampai;
        $data['kategori'] = Kategoribarangpembelian::where('kode_kategori', $request->kode_kategori)->first();
        $time = date('H:i:s');
        if (isset($_POST['exportButton'])) {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Laporan Persediaan Gudang Logistik $dari-$sampai- $time.xls");
        }

        $data['rekappersediaan'] = Barangpembelian::select(
            'pembelian_barang.kode_barang',
            'nama_barang',
            'satuan',
            'kode_jenis_barang',
            'saldo_awal_qty',
            'saldo_awal_harga',
            'opname_qty',
            'bm_qty',
            'bm_totalharga',
            'bk_qty',
            DB::raw('IFNULL(saldo_awal_qty,0) + IFNULL(bm_qty,0) - IFNULL(bk_qty,0) as saldo_akhir_qty')
        )
        ->leftJoin(
            DB::raw("(
                SELECT gd.kode_barang, SUM(jumlah) AS saldo_awal_qty, AVG(harga) AS saldo_awal_harga
                FROM gudang_logistik_saldoawal_detail gd
                INNER JOIN gudang_logistik_saldoawal g ON gd.kode_saldo_awal=g.kode_saldo_awal
                WHERE bulan = '$bulan' AND tahun = '$tahun'
                GROUP BY gd.kode_barang
            ) saldo_awal"),
            function ($join) {
                $join->on('pembelian_barang.kode_barang', '=', 'saldo_awal.kode_barang');
            }
        )
        ->leftJoin(
            DB::raw("(
                SELECT go.kode_barang, SUM(jumlah) AS opname_qty
                FROM gudang_logistik_opname_detail go
                INNER JOIN gudang_logistik_opname g ON go.kode_opname=g.kode_opname
                WHERE bulan = '$bulan' AND tahun = '$tahun'
                GROUP BY go.kode_barang
            ) opname"),
            function ($join) {
                $join->on('pembelian_barang.kode_barang', '=', 'opname.kode_barang');
            }
        )
        ->leftJoin(
            DB::raw("(
                SELECT gbd.kode_barang, SUM(jumlah) as bm_qty, SUM(ROUND(jumlah*harga, 2) + penyesuaian) as bm_totalharga
                FROM gudang_logistik_barang_masuk_detail gbd
                INNER JOIN gudang_logistik_barang_masuk gb ON gbd.no_bukti = gb.no_bukti
                WHERE tanggal BETWEEN '$dari' AND '$sampai'
                GROUP BY gbd.kode_barang
            ) barangmasuk"),
            function ($join) {
                $join->on('pembelian_barang.kode_barang', '=', 'barangmasuk.kode_barang');
            }
        )
        ->leftJoin(
            DB::raw("(
                SELECT gkd.kode_barang, SUM(jumlah) as bk_qty
                FROM gudang_logistik_barang_keluar_detail gkd
                INNER JOIN gudang_logistik_barang_keluar gk ON gkd.no_bukti = gk.no_bukti
                WHERE tanggal BETWEEN '$dari' AND '$sampai'
                GROUP BY gkd.kode_barang
            ) barangkeluar"),
            function ($join) {
                $join->on('pembelian_barang.kode_barang', '=', 'barangkeluar.kode_barang');
            }
        )
        ->where(function ($query) {
            $query->where(function ($query) {
                $query->whereNotNull('saldo_awal_qty')
                    ->where('saldo_awal_qty', '<>', 0.0);
            })
            ->orWhere(function ($query) {
                $query->whereNotNull('opname_qty')
                    ->where('opname_qty', '<>', 0.0);
            })
            ->orWhere(function ($query) {
                $query->whereNotNull('bm_qty')
                    ->where('bm_qty', '<>', 0.0);
            })
            ->orWhere(function ($query) {
                $query->whereNotNull('bk_qty')
                    ->where('bk_qty', '<>', 0.0);
            });
        })
        ->where('pembelian_barang.kode_group', 'GDL')
        ->where('pembelian_barang.kode_kategori', $request->kode_kategori)
        ->orderBy('kode_jenis_barang')
        ->orderByRaw('cast(substr(pembelian_barang.kode_barang from 4) AS UNSIGNED)')
        ->orderBy('nama_barang')
        ->get();

        $user = User::findOrFail(auth()->user()->id);
        if ($user->can('pembelian.harga')) {
            return view('gudanglogistik.laporan.rekappersediaan_cetak', $data);
        } else {
            return view('gudanglogistik.laporan.rekappersediaan_tanpaharga_cetak', $data);
        }
    }

    public function cetakkartugudang(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $dari = $tahun . "-" . $bulan . "-01";
        $sampai = date("Y-m-t", strtotime($dari));
        if (lockreport($dari) == "error") {
            return Redirect::back()->with(messageError('Data Tidak Ditemukan'));
        }
        $data['dari'] = $dari;
        $data['sampai'] = $sampai;
        
        $results = Detailbarangmasukgudanglogistik::select(
            'tanggal',
            DB::raw('SUM(jumlah) as qty_masuk'),
            DB::raw('0 as qty_keluar'),
            'gudang_logistik_barang_masuk_detail.keterangan'
        )
        ->join('gudang_logistik_barang_masuk', 'gudang_logistik_barang_masuk_detail.no_bukti', '=', 'gudang_logistik_barang_masuk.no_bukti')
        ->whereBetween('tanggal', [$dari, $sampai])
        ->where('gudang_logistik_barang_masuk_detail.kode_barang', $request->kode_barang_kartugudang)
        ->groupBy('tanggal', 'gudang_logistik_barang_masuk_detail.kode_barang', 'gudang_logistik_barang_masuk_detail.keterangan');

        $results->unionAll(Detailbarangkeluargudanglogistik::select(
            'tanggal',
            DB::raw('0 as qty_masuk'),
            DB::raw('SUM(jumlah) as qty_keluar'),
            'gudang_logistik_barang_keluar_detail.keterangan'
        )
        ->join('gudang_logistik_barang_keluar', 'gudang_logistik_barang_keluar_detail.no_bukti', '=', 'gudang_logistik_barang_keluar.no_bukti')
        ->whereBetween('tanggal', [$dari, $sampai])
        ->where('gudang_logistik_barang_keluar_detail.kode_barang', $request->kode_barang_kartugudang)
        ->groupBy('tanggal', 'gudang_logistik_barang_keluar_detail.kode_barang', 'gudang_logistik_barang_keluar_detail.keterangan'));

        $kartu_gudang = $results->orderBy('tanggal')->get();
        $data['kartu_gudang'] = $kartu_gudang;
        $data['barang'] = Barangpembelian::where('kode_barang', $request->kode_barang_kartugudang)->first();
        
        $data['saldo_awal'] = Detailsaldoawalgudanglogistik::join('gudang_logistik_saldoawal', 'gudang_logistik_saldoawal_detail.kode_saldo_awal', '=', 'gudang_logistik_saldoawal.kode_saldo_awal')
            ->where('kode_barang', $request->kode_barang_kartugudang)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        $time = date('H:i:s');
        if (isset($_POST['exportButton'])) {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Kartu Gudang Logistik $request->kode_barang_kartugudang - $time.xls");
        }
        return view('gudanglogistik.laporan.kartugudang_cetak', $data);
    }
}
