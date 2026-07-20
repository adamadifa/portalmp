<?php

namespace App\Http\Controllers;

use App\Models\Detailmutasigudangjadi;
use App\Models\Detailmutasiproduksi;
use App\Models\Mutasigudangjadi;
use App\Models\Mutasiproduksi;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class FsthpController extends Controller
{
    public function index(Request $request)
    {
        $start_year = config('global.start_year') ?? 2020;
        $start_date = config('global.start_date') ?? '2020-01-01';
        $end_date = config('global.end_date') ?? '2027-12-31';

        $query = Mutasiproduksi::query();
        $query->orderBy('tanggal_mutasi', 'desc');
        $query->orderBy('created_at', 'desc');
        if (!empty($request->tanggal_mutasi_search)) {
            $query->where('tanggal_mutasi', $request->tanggal_mutasi_search);
        } else {
            $query->whereBetween('tanggal_mutasi', [$start_date, $end_date]);
        }
        $query->where('jenis_mutasi', 'FSTHP');
        $fsthp = $query->paginate(20);
        $fsthp->appends(request()->all());
        return view('produksi.fsthp.index', compact('fsthp'));
    }

    public function index_gudang(Request $request)
    {
        $start_year = config('global.start_year') ?? 2020;
        $start_date = config('global.start_date') ?? '2020-01-01';
        $end_date = config('global.end_date') ?? '2027-12-31';

        $query = Mutasiproduksi::query();
        $query->orderBy('tanggal_mutasi', 'desc');
        $query->orderBy('created_at', 'desc');
        if (!empty($request->tanggal_mutasi_search)) {
            $query->where('tanggal_mutasi', $request->tanggal_mutasi_search);
        } else {
            $query->whereBetween('tanggal_mutasi', [$start_date, $end_date]);
        }
        $query->where('jenis_mutasi', 'FSTHP');
        $fsthp = $query->paginate(20);
        $fsthp->appends(request()->all());
        return view('produksi.fsthp.index_gudang', compact('fsthp'));
    }

    public function show($no_mutasi)
    {
        $no_mutasi = Crypt::decrypt($no_mutasi);
        $fsthp = Mutasiproduksi::where('no_mutasi', $no_mutasi)->first();
        $detail = Detailmutasiproduksi::where('no_mutasi', $no_mutasi)
            ->join('produk', 'produksi_mutasi_detail.kode_produk', '=', 'produk.kode_produk')
            ->get();

        return view('produksi.fsthp.show', compact('fsthp', 'detail'));
    }

    public function create()
    {
        $produk = Produk::where('status_aktif_produk', 1)->orderBy('kode_produk')->get();
        return view('produksi.fsthp.create', compact('produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_mutasi' => 'required',
            'tanggal_mutasi' => 'required',
            'unit' => 'required',
            'kode_produk' => 'required',
            'shift' => 'required',
            'jumlah' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $cektutuplaporan = cektutupLaporan($request->tanggal_mutasi, "produksi");
            if ($cektutuplaporan > 0) {
                return Redirect::back()->with(messageError('Periode Laporan Sudah Ditutup !'));
            }

            $cekfsthp = Mutasiproduksi::where('no_mutasi', $request->no_mutasi)->count();
            if ($cekfsthp > 0) {
                return Redirect::back()->with(messageError('Data Sudah Ada !'));
            }

            $jumlah = function_exists('toNumber') ? toNumber($request->jumlah) : (int)str_replace(['.', ','], '', $request->jumlah);

            Mutasiproduksi::create([
                'no_mutasi' => $request->no_mutasi,
                'tanggal_mutasi' => $request->tanggal_mutasi,
                'in_out' => 'OUT',
                'jenis_mutasi' => 'FSTHP',
                'unit' => $request->unit
            ]);

            Detailmutasiproduksi::create([
                'no_mutasi' => $request->no_mutasi,
                'kode_produk' => $request->kode_produk,
                'shift' => $request->shift,
                'jumlah' => $jumlah
            ]);

            DB::commit();
            return redirect()->route('fsthp.index')->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function destroy($no_mutasi)
    {
        $no_mutasi = Crypt::decrypt($no_mutasi);
        $fsthp = Mutasiproduksi::where('no_mutasi', $no_mutasi)->first();
        try {
            $cektutuplaporan = cektutupLaporan($fsthp->tanggal_mutasi, "produksi");
            if ($cektutuplaporan > 0) {
                return Redirect::back()->with(messageError('Periode Laporan Sudah Ditutup !'));
            }
            Mutasiproduksi::where('no_mutasi', $no_mutasi)->delete();
            return Redirect::back()->with(messageSuccess('Data Berhasil Dihapus'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function generatenofsthp(Request $request)
    {
        $namabulan = config('global.nama_bulan_singkat') ?? [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'];
        $tanggal = explode("-", $request->tanggal_mutasi);
        $hari = $tanggal[2];
        $bulan = $tanggal[1] + 0;
        $tahun = $tanggal[0];
        $tgl = "/" . $hari . "/" . $namabulan[$bulan] . "/" . $tahun;

        $no_fsthp = "F" . $request->kode_produk . "/0" . $request->shift . $tgl;
        return $no_fsthp;
    }

    public function approve($no_mutasi)
    {
        $no_mutasi = Crypt::decrypt($no_mutasi);
        DB::beginTransaction();
        try {
            $fsthp = Mutasiproduksi::where('no_mutasi', $no_mutasi)->first();
            $detail = Detailmutasiproduksi::where('no_mutasi', $no_mutasi)->get();

            $cektutuplaporan = cektutupLaporan($fsthp->tanggal_mutasi, "produksi");
            if ($cektutuplaporan > 0) {
                return Redirect::back()->with(messageError('Periode Laporan Sudah Ditutup !'));
            }

            $cek_fsthp_gudang = Mutasigudangjadi::where('no_mutasi', $no_mutasi)->count();
            if ($cek_fsthp_gudang > 0) {
                return Redirect::back()->with(messageError('Data Sudah Ada'));
            }

            Mutasigudangjadi::create([
                'no_mutasi' => $no_mutasi,
                'tanggal' => $fsthp->tanggal_mutasi,
                'in_out' => 'I',
                'jenis_mutasi' => 'FS',
                'id_user' => auth()->user()->id
            ]);

            $detail_fsthp = [];
            foreach ($detail as $d) {
                $detail_fsthp[] = [
                    'no_mutasi' => $no_mutasi,
                    'kode_produk'  => $d->kode_produk,
                    'jumlah' => $d->jumlah
                ];
            }

            Detailmutasigudangjadi::insert($detail_fsthp);

            Mutasiproduksi::where('no_mutasi', $no_mutasi)->update(['status' => 1]);
            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil Diterima'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function cancel($no_mutasi)
    {
        $no_mutasi = Crypt::decrypt($no_mutasi);
        DB::beginTransaction();
        try {
            Mutasigudangjadi::where('no_mutasi', $no_mutasi)->delete();
            Mutasiproduksi::where('no_mutasi', $no_mutasi)->update(['status' => NULL]);
            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil Dibatalkan'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }
}
