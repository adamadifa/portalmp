<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\Detailsaldoawalbukubesar;
use App\Models\Saldoawalbukubesar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SaldoawalbukubesarController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('saldoawalbukubesar.index'), 403);

        $data['list_bulan'] = config('global.list_bulan');
        $data['nama_bulan'] = config('global.nama_bulan');
        $data['start_year'] = config('global.start_year');

        $query = Saldoawalbukubesar::query();

        if (!empty($request->bulan)) {
            $query->where('bulan', $request->bulan);
        }
        if (!empty($request->tahun)) {
            $query->where('tahun', $request->tahun);
        } else {
            $query->where('tahun', date('Y'));
        }

        $query->orderBy('tahun', 'desc');
        $query->orderBy('bulan', 'asc');

        $data['saldoawalbukubesar'] = $query->get();

        return view('accounting.saldoawalbukubesar.index', $data);
    }

    public function create()
    {
        abort_if(!auth()->user()->can('saldoawalbukubesar.create'), 403);

        $data['list_bulan'] = config('global.list_bulan');
        $data['start_year'] = config('global.start_year');
        $data['cek_saldo_awal'] = Saldoawalbukubesar::count();

        $data['coa'] = Coa::where('level', '>=', 2)
            ->orderBy('kode_akun', 'asc')
            ->get();

        return view('accounting.saldoawalbukubesar.create', $data);
    }

    public function getsaldo(Request $request)
    {
        $bulan_dipilih = (int) $request->bulan;
        $tahun_dipilih = (int) $request->tahun;
        $nama_bulan = config('global.nama_bulan');

        // Tentukan bulan dan tahun sebelumnya
        if ($bulan_dipilih === 1) {
            $bulan_sebelumnya = 12;
            $tahun_sebelumnya = $tahun_dipilih - 1;
        } else {
            $bulan_sebelumnya = $bulan_dipilih - 1;
            $tahun_sebelumnya = $tahun_dipilih;
        }

        $cek_saldo_sebelumnya = Saldoawalbukubesar::where('bulan', $bulan_sebelumnya)
            ->where('tahun', $tahun_sebelumnya)
            ->count();

        $cek_total_saldo_awal = Saldoawalbukubesar::count();

        // Jika belum ada data sama sekali, load seluruh akun COA dengan nilai 0 untuk inisialisasi
        $is_initial = ($cek_total_saldo_awal === 0);

        if (!$is_initial && $cek_saldo_sebelumnya === 0) {
            $nama_bln_prev = $nama_bulan[$bulan_sebelumnya] ?? $bulan_sebelumnya;
            return response()->json([
                'success' => false,
                'message' => "Saldo awal bulan $nama_bln_prev $tahun_sebelumnya belum dibuat. Silakan buat saldo awal periode sebelumnya terlebih dahulu."
            ], 400);
        }

        // Ambil saldo awal bulan sebelumnya jika ada
        $saldo_map = [];
        if (!$is_initial) {
            $kode_sa_prev = sprintf('SA%02d%d', $bulan_sebelumnya, $tahun_sebelumnya);
            $prevDetails = Detailsaldoawalbukubesar::where('kode_saldo_awal', $kode_sa_prev)->get();
            foreach ($prevDetails as $pd) {
                $saldo_map[$pd->kode_akun] = (float) $pd->jumlah;
            }

            // Hitung mutasi selama periode bulan sebelumnya
            $start_date = sprintf('%04d-%02d-01', $tahun_sebelumnya, $bulan_sebelumnya);
            $end_date = date('Y-m-t', strtotime($start_date));

            // Mutasi dari Biaya Operasional
            $biayaRows = DB::table('biaya_detail')
                ->join('biaya', 'biaya_detail.no_bukti', '=', 'biaya.no_bukti')
                ->whereBetween('biaya.tanggal', [$start_date, $end_date])
                ->select('biaya_detail.kode_akun', DB::raw('SUM((jumlah * harga) + penyesuaian) as total'))
                ->groupBy('biaya_detail.kode_akun')
                ->get();
            foreach ($biayaRows as $br) {
                $saldo_map[$br->kode_akun] = ($saldo_map[$br->kode_akun] ?? 0) + (float) $br->total;
            }

            // Mutasi dari Pembelian (Hanya DPP)
            $pembelianRows = DB::table('pembelian_detail')
                ->join('pembelian', 'pembelian_detail.no_bukti', '=', 'pembelian.no_bukti')
                ->whereBetween('pembelian.tanggal', [$start_date, $end_date])
                ->select(
                    'pembelian_detail.kode_akun',
                    DB::raw('SUM(CASE WHEN pembelian.ppn = "1" THEN ((jumlah * harga) * 100 / 111) ELSE ((jumlah * harga) + penyesuaian) END) as total')
                )
                ->groupBy('pembelian_detail.kode_akun')
                ->get();
            foreach ($pembelianRows as $pr) {
                $saldo_map[$pr->kode_akun] = ($saldo_map[$pr->kode_akun] ?? 0) + (float) $pr->total;
            }

            // Mutasi dari Penjualan Marketing (Hanya DPP ke akun 4-11101)
            $penjualanTotal = DB::table('marketing_penjualan_detail')
                ->join('marketing_penjualan', 'marketing_penjualan_detail.no_bukti', '=', 'marketing_penjualan.no_bukti')
                ->whereBetween('marketing_penjualan.tanggal', [$start_date, $end_date])
                ->sum(DB::raw('harga_dus * jumlah'));
            if ($penjualanTotal > 0) {
                $saldo_map['4-11101'] = ($saldo_map['4-11101'] ?? 0) + (float) $penjualanTotal;
            }

            // Mutasi PPN Keluaran (ke akun Kewajiban 2-11301)
            $ppnKeluaranTotal = DB::table('marketing_penjualan_detail')
                ->join('marketing_penjualan', 'marketing_penjualan_detail.no_bukti', '=', 'marketing_penjualan.no_bukti')
                ->whereBetween('marketing_penjualan.tanggal', [$start_date, $end_date])
                ->sum(DB::raw('subtotal - (harga_dus * jumlah)'));
            if ($ppnKeluaranTotal > 0) {
                $saldo_map['2-11301'] = ($saldo_map['2-11301'] ?? 0) + (float) $ppnKeluaranTotal;
            }

            // Mutasi Piutang Usaha (1-11201) dari Total Netto Penjualan (Debet) dikurangi Pelunasan (Kredit)
            $nettoPenjualanTotal = DB::table('marketing_penjualan_detail')
                ->join('marketing_penjualan', 'marketing_penjualan_detail.no_bukti', '=', 'marketing_penjualan.no_bukti')
                ->whereBetween('marketing_penjualan.tanggal', [$start_date, $end_date])
                ->sum('subtotal');
            $pelunasanPiutangTotal = DB::table('marketing_penjualan_historibayar')
                ->whereBetween('tanggal', [$start_date, $end_date])
                ->sum('jumlah');

            $mutasiPiutang = (float)$nettoPenjualanTotal - (float)$pelunasanPiutangTotal;
            if ($mutasiPiutang != 0) {
                $saldo_map['1-11201'] = ($saldo_map['1-11201'] ?? 0) + $mutasiPiutang;
            }
        }

        // Ambil struktur akun Neraca (1-Aktiva, 2-Kewajiban, 3-Ekuitas) untuk saldo awal
        $accounts = Coa::whereRaw('LEFT(kode_akun, 1) IN (1, 2, 3)')
            ->orderBy('kode_akun', 'asc')
            ->get();

        $data['accounts'] = $accounts;
        $data['saldo_map'] = $saldo_map;

        return view('accounting.saldoawalbukubesar.getsaldo', $data);
    }

    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('saldoawalbukubesar.create'), 403);

        $request->validate([
            'bulan' => 'required',
            'tahun' => 'required',
            'kode_akun' => 'required|array|min:1',
            'jumlah' => 'required|array|min:1',
        ]);

        $bln = sprintf('%02d', $request->bulan);
        $kode_saldo_awal = "SA" . $bln . $request->tahun;
        $tanggal = $request->tahun . "-" . $bln . "-01";

        DB::beginTransaction();
        try {
            // Update or create header
            $saldoAwal = Saldoawalbukubesar::updateOrCreate(
                ['kode_saldo_awal' => $kode_saldo_awal],
                [
                    'tanggal' => $tanggal,
                    'bulan' => $request->bulan,
                    'tahun' => $request->tahun,
                ]
            );

            // Clean previous detail
            Detailsaldoawalbukubesar::where('kode_saldo_awal', $kode_saldo_awal)->delete();

            $kode_akun = $request->kode_akun;
            $jumlah = $request->jumlah;

            foreach ($kode_akun as $key => $akun) {
                $val = isset($jumlah[$key]) ? toNumber($jumlah[$key]) : 0;
                if ($val != 0) {
                    Detailsaldoawalbukubesar::create([
                        'kode_saldo_awal' => $kode_saldo_awal,
                        'kode_akun' => $akun,
                        'jumlah' => $val,
                    ]);
                }
            }

            DB::commit();
            return Redirect::route('saldoawalbukubesar.index')->with(['success' => 'Saldo Awal Buku Besar Periode Berhasil Disimpan.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withInput()->with(['error' => 'Gagal menyimpan saldo awal: ' . $e->getMessage()]);
        }
    }

    public function show($kode_saldo_awal)
    {
        abort_if(!auth()->user()->can('saldoawalbukubesar.show'), 403);

        try {
            $kode_decrypted = Crypt::decrypt($kode_saldo_awal);
        } catch (\Exception $e) {
            $kode_decrypted = $kode_saldo_awal;
        }

        $data['saldoawal'] = Saldoawalbukubesar::where('kode_saldo_awal', $kode_decrypted)->firstOrFail();
        $data['details'] = Detailsaldoawalbukubesar::where('kode_saldo_awal', $kode_decrypted)
            ->join('coa', 'bukubesar_saldoawal_detail.kode_akun', '=', 'coa.kode_akun')
            ->select('bukubesar_saldoawal_detail.*', 'coa.nama_akun', 'coa.level')
            ->orderBy('bukubesar_saldoawal_detail.kode_akun', 'asc')
            ->get();
        $data['nama_bulan'] = config('global.nama_bulan');

        return view('accounting.saldoawalbukubesar.show', $data);
    }

    public function edit($kode_saldo_awal)
    {
        abort_if(!auth()->user()->can('saldoawalbukubesar.edit'), 403);

        try {
            $kode_decrypted = Crypt::decrypt($kode_saldo_awal);
        } catch (\Exception $e) {
            $kode_decrypted = $kode_saldo_awal;
        }

        $data['saldoawal'] = Saldoawalbukubesar::where('kode_saldo_awal', $kode_decrypted)->firstOrFail();
        $details = Detailsaldoawalbukubesar::where('kode_saldo_awal', $kode_decrypted)->pluck('jumlah', 'kode_akun')->toArray();

        $data['accounts'] = Coa::whereRaw('LEFT(kode_akun, 1) IN (1, 2, 3)')
            ->orderBy('kode_akun', 'asc')
            ->get();
        $data['saldo_map'] = $details;
        $data['nama_bulan'] = config('global.nama_bulan');

        return view('accounting.saldoawalbukubesar.edit', $data);
    }

    public function destroy($kode_saldo_awal)
    {
        abort_if(!auth()->user()->can('saldoawalbukubesar.delete'), 403);

        try {
            $kode_decrypted = Crypt::decrypt($kode_saldo_awal);
        } catch (\Exception $e) {
            $kode_decrypted = $kode_saldo_awal;
        }

        DB::beginTransaction();
        try {
            Detailsaldoawalbukubesar::where('kode_saldo_awal', $kode_decrypted)->delete();
            Saldoawalbukubesar::where('kode_saldo_awal', $kode_decrypted)->delete();
            DB::commit();

            return Redirect::back()->with(['success' => 'Saldo Awal Berhasil Dihapus.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(['error' => 'Gagal menghapus saldo awal: ' . $e->getMessage()]);
        }
    }
}
