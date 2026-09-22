<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\Jurnalumum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class JurnalumumController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('jurnalumum.index'), 403);

        $query = Jurnalumum::query();
        $query->select('accounting_jurnalumum.*', 'coa.nama_akun');
        $query->join('coa', 'accounting_jurnalumum.kode_akun', '=', 'coa.kode_akun');

        if (!empty($request->dari) && !empty($request->sampai)) {
            $query->whereBetween('accounting_jurnalumum.tanggal', [$request->dari, $request->sampai]);
        } else {
            $dari = date('Y-m-01');
            $sampai = date('Y-m-t');
            $query->whereBetween('accounting_jurnalumum.tanggal', [$dari, $sampai]);
        }

        if (!empty($request->kode_akun_search)) {
            $query->where('accounting_jurnalumum.kode_akun', $request->kode_akun_search);
        }

        $query->orderBy('accounting_jurnalumum.tanggal', 'desc');
        $query->orderBy('accounting_jurnalumum.kode_ju', 'desc');
        $data['jurnalumum'] = $query->get();

        $data['coa'] = Coa::orderBy('kode_akun')->get();

        return view('accounting.jurnalumum.index', $data);
    }

    public function create()
    {
        abort_if(!auth()->user()->can('jurnalumum.create'), 403);

        $data['coa'] = Coa::orderBy('kode_akun')->whereNotIn('kode_akun', ['1', '2'])->get();

        return view('accounting.jurnalumum.create', $data);
    }

    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('jurnalumum.create'), 403);

        $tanggal = $request->tanggal_item;
        $kode_akun = $request->kode_akun_item;
        $keterangan = $request->keterangan_item;
        $jumlah = $request->jumlah_item;
        $debet_kredit = $request->debet_kredit_item;
        $kode_dept = 'AKT';

        if (empty($kode_akun) || count($kode_akun) === 0) {
            return Redirect::back()->with(messageError('Data Masih Kosong'));
        }

        DB::beginTransaction();
        try {
            for ($i = 0; $i < count($kode_akun); $i++) {
                $cektutuplaporan = cektutupLaporan($tanggal[$i], "jurnalumum");
                if ($cektutuplaporan > 0) {
                    DB::rollBack();
                    return Redirect::back()->with(messageError('Periode Laporan Sudah Ditutup'));
                }

                $prefix = 'JL' . date('ym', strtotime($tanggal[$i]));
                $lastjurnalumum = Jurnalumum::select('kode_ju')
                    ->whereRaw('LEFT(kode_ju, 6) = ?', [$prefix])
                    ->orderBy('kode_ju', 'desc')
                    ->first();

                $last_kode_ju = $lastjurnalumum != null ? $lastjurnalumum->kode_ju : '';
                $kode_ju = buatkode($last_kode_ju, $prefix, 3);

                Jurnalumum::create([
                    'kode_ju' => $kode_ju,
                    'tanggal' => $tanggal[$i],
                    'kode_akun' => $kode_akun[$i],
                    'keterangan' => $keterangan[$i],
                    'debet_kredit' => $debet_kredit[$i],
                    'kode_dept' => $kode_dept,
                    'jumlah' => toNumber($jumlah[$i]),
                    'id_user' => auth()->user()->id
                ]);
            }

            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function edit($kode_ju)
    {
        abort_if(!auth()->user()->can('jurnalumum.edit'), 403);

        try {
            $kode_ju = Crypt::decrypt($kode_ju);
        } catch (\Exception $e) {
            // fallback plain
        }

        $data['coa'] = Coa::orderBy('kode_akun')->whereNotIn('kode_akun', ['1', '2'])->get();
        $data['jurnalumum'] = Jurnalumum::where('kode_ju', $kode_ju)->firstOrFail();

        return view('accounting.jurnalumum.edit', $data);
    }

    public function update($kode_ju, Request $request)
    {
        abort_if(!auth()->user()->can('jurnalumum.edit'), 403);

        try {
            $kode_ju = Crypt::decrypt($kode_ju);
        } catch (\Exception $e) {
            // fallback plain
        }

        $jurnalumum = Jurnalumum::where('kode_ju', $kode_ju)->first();
        if (!$jurnalumum) {
            return Redirect::back()->with(messageError('Data tidak ditemukan'));
        }

        $request->validate([
            'tanggal' => 'required|date',
            'kode_akun' => 'required',
            'keterangan' => 'required',
            'jumlah' => 'required',
            'debet_kredit' => 'required|in:D,K',
        ]);

        DB::beginTransaction();
        try {
            $cektutuplaporan = cektutupLaporan($request->tanggal, "jurnalumum");
            if ($cektutuplaporan > 0) {
                return Redirect::back()->with(messageError('Periode Laporan Sudah Ditutup'));
            }

            $cektutuplaporanjurnalumum = cektutupLaporan($jurnalumum->tanggal, "jurnalumum");
            if ($cektutuplaporanjurnalumum > 0) {
                return Redirect::back()->with(messageError('Periode Laporan Sudah Ditutup'));
            }

            $jurnalumum->update([
                'tanggal' => $request->tanggal,
                'kode_akun' => $request->kode_akun,
                'keterangan' => $request->keterangan,
                'jumlah' => toNumber($request->jumlah),
                'debet_kredit' => $request->debet_kredit,
            ]);

            DB::commit();
            return Redirect::back()->with(messageSuccess('Data berhasil diupdate'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function destroy($kode_ju)
    {
        abort_if(!auth()->user()->can('jurnalumum.delete'), 403);

        try {
            $kode_ju = Crypt::decrypt($kode_ju);
        } catch (\Exception $e) {
            // fallback plain
        }

        DB::beginTransaction();
        try {
            $jurnalumum = Jurnalumum::where('kode_ju', $kode_ju)->first();
            if (!$jurnalumum) {
                return Redirect::back()->with(messageError('Data tidak ditemukan'));
            }

            $cektutuplaporan = cektutupLaporan($jurnalumum->tanggal, "jurnalumum");
            if ($cektutuplaporan > 0) {
                return Redirect::back()->with(messageError('Periode Laporan Sudah Ditutup'));
            }

            $jurnalumum->delete();
            DB::commit();
            return Redirect::back()->with(messageSuccess('Data berhasil dihapus'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }
}
