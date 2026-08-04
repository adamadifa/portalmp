<?php

namespace App\Http\Controllers;

use App\Models\MarketingPenjualan;
use App\Models\MarketingPenjualanDetail;
use App\Models\MarketingPenjualanHistoribayar;
use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\ProdukHarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;

class PenjualanMarketingController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('penjualanmarketing.view'), 403);

        $query = DB::table('marketing_penjualan')
            ->select(
                'marketing_penjualan.*',
                'pelanggan.nama_pelanggan'
            )
            ->selectRaw('(SELECT SUM(subtotal) FROM marketing_penjualan_detail WHERE no_bukti = marketing_penjualan.no_bukti) as total')
            ->leftJoin('pelanggan', 'marketing_penjualan.kode_pelanggan', '=', 'pelanggan.kode_pelanggan');

        if (!empty($request->dari) && !empty($request->sampai)) {
            $query->whereBetween('marketing_penjualan.tanggal', [$request->dari, $request->sampai]);
        }

        if (!empty($request->no_bukti_search)) {
            $query->where('marketing_penjualan.no_bukti', 'like', '%' . $request->no_bukti_search . '%');
        }

        if (!empty($request->nama_pelanggan_search)) {
            $query->where('pelanggan.nama_pelanggan', 'like', '%' . $request->nama_pelanggan_search . '%');
        }

        $query->orderBy('marketing_penjualan.tanggal', 'desc');
        $query->orderBy('marketing_penjualan.no_bukti', 'desc');

        $penjualan = $query->paginate(15);
        $penjualan->appends($request->all());

        return view('marketing.penjualan.index', compact('penjualan'));
    }

    public function create()
    {
        abort_if(!auth()->user()->can('penjualanmarketing.create'), 403);

        $pelanggan = Pelanggan::orderBy('nama_pelanggan')->get();
        return view('marketing.penjualan.create', compact('pelanggan'));
    }

    public function getProduk()
    {
        $produk = Produk::orderBy('kode_produk')
            ->join('produk_harga', 'produk.kode_produk', '=', 'produk_harga.kode_produk')
            ->select('produk.*', 'produk_harga.harga as harga')
            ->where('status_aktif_produk', 1)
            ->get();

        return view('marketing.penjualan.getproduk', compact('produk'));
    }

    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('penjualanmarketing.create'), 403);

        $request->validate([
            'no_bukti' => 'required',
            'tanggal' => 'required',
            'kode_pelanggan' => 'required',
            'jenis_transaksi' => 'required',
            'jenis_bayar' => 'required_if:jenis_transaksi,T',
            'kode_produk' => 'required|array|min:1',
            'kode_produk.*' => 'required',
            'harga_dus_produk' => 'required|array',
            'harga_dus_produk.*' => 'required',
            'jumlah_produk' => 'required|array',
            'jumlah_produk.*' => 'required',
            'subtotal' => 'required|array',
            'subtotal.*' => 'required'
        ]);

        $no_bukti = $request->no_bukti;
        $tanggal = $request->tanggal;
        $kode_pelanggan = $request->kode_pelanggan;
        $jenis_transaksi = $request->jenis_transaksi;
        $jenis_bayar = $jenis_transaksi == 'T' ? $request->jenis_bayar : 'TP';

        $kode_produk = $request->kode_produk;
        $harga_dus = $request->harga_dus_produk;
        $jumlah = $request->jumlah_produk;
        $subtotal = $request->subtotal;

        DB::beginTransaction();
        try {
            // Cek duplikat no_bukti
            $cekNoBukti = MarketingPenjualan::where('no_bukti', $no_bukti)->count();
            if ($cekNoBukti > 0) {
                DB::rollBack();
                return Redirect::back()->with(messageError('No. Bukti Sudah Ada'));
            }

            $detail = [];
            for ($i = 0; $i < count($kode_produk); $i++) {
                $detail[] = [
                    'no_bukti' => $no_bukti,
                    'kode_produk' => $kode_produk[$i],
                    'harga_dus' => toNumber($harga_dus[$i]),
                    'jumlah' => toNumber($jumlah[$i]),
                    'subtotal' => toNumber($subtotal[$i]),
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            MarketingPenjualan::create([
                'no_bukti' => $no_bukti,
                'tanggal' => $tanggal,
                'kode_pelanggan' => $kode_pelanggan,
                'jenis_transaksi' => $jenis_transaksi,
                'jenis_bayar' => $jenis_bayar,
                'status' => '0',
                'kode_cabang' => auth()->user()->kode_cabang ?? 'PST',
                'id_user' => auth()->user()->id
            ]);

            MarketingPenjualanDetail::insert($detail);

            if ($jenis_transaksi == "T") {
                $total_penjualan = array_sum(array_map(function($subtotal) {
                    return toNumber($subtotal);
                }, $subtotal));

                $kode_cabang = auth()->user()->kode_cabang ?? 'PST';
                $tahun = date('y', strtotime($tanggal));
                
                $lasthistoribayar = MarketingPenjualanHistoribayar::select('no_bukti')
                    ->whereRaw('LEFT(no_bukti,6) = "' . $kode_cabang . $tahun . '-"')
                    ->orderBy("no_bukti", "desc")
                    ->first();

                $last_no_bukti = $lasthistoribayar != null ? $lasthistoribayar->no_bukti : '';
                $no_bukti_bayar = buatkode($last_no_bukti, $kode_cabang . $tahun . "-", 6);

                MarketingPenjualanHistoribayar::create([
                    'no_bukti' => $no_bukti_bayar,
                    'tanggal' => $tanggal,
                    'no_bukti_penjualan' => $no_bukti,
                    'jenis_bayar' => $jenis_bayar,
                    'jumlah' => $total_penjualan,
                    'kode_akun' => $jenis_bayar == 'TN' ? '1-1100' : '1-1200',
                    'id_user' => auth()->user()->id
                ]);
                
                // Set lunas
                MarketingPenjualan::where('no_bukti', $no_bukti)->update(['status' => '1']);
            }

            DB::commit();
            return Redirect::route('penjualanmarketing.index')->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function show($no_bukti)
    {
        abort_if(!auth()->user()->can('penjualanmarketing.view'), 403);

        $no_bukti = Crypt::decrypt($no_bukti);
        $penjualan = MarketingPenjualan::select(
            'marketing_penjualan.*',
            'pelanggan.nama_pelanggan',
            'pelanggan.alamat_pelanggan'
        )
        ->leftJoin('pelanggan', 'marketing_penjualan.kode_pelanggan', '=', 'pelanggan.kode_pelanggan')
        ->where('marketing_penjualan.no_bukti', $no_bukti)
        ->firstOrFail();

        $detail = MarketingPenjualanDetail::select(
            'marketing_penjualan_detail.*',
            'produk.nama_produk',
            'produk.satuan'
        )
        ->join('produk', 'marketing_penjualan_detail.kode_produk', '=', 'produk.kode_produk')
        ->where('marketing_penjualan_detail.no_bukti', $no_bukti)
        ->get();

        return view('marketing.penjualan.show', compact('penjualan', 'detail'));
    }

    public function edit($no_bukti)
    {
        abort_if(!auth()->user()->can('penjualanmarketing.edit'), 403);

        $no_bukti = Crypt::decrypt($no_bukti);
        $penjualan = MarketingPenjualan::select(
            'marketing_penjualan.*',
            'pelanggan.nama_pelanggan'
        )
        ->leftJoin('pelanggan', 'marketing_penjualan.kode_pelanggan', '=', 'pelanggan.kode_pelanggan')
        ->where('marketing_penjualan.no_bukti', $no_bukti)
        ->firstOrFail();

        $detail = MarketingPenjualanDetail::select(
            'marketing_penjualan_detail.*',
            'produk.nama_produk'
        )
        ->join('produk', 'marketing_penjualan_detail.kode_produk', '=', 'produk.kode_produk')
        ->where('marketing_penjualan_detail.no_bukti', $no_bukti)
        ->get();

        $pelanggan = Pelanggan::orderBy('nama_pelanggan')->get();

        return view('marketing.penjualan.edit', compact('penjualan', 'detail', 'pelanggan'));
    }

    public function update(Request $request, $no_bukti)
    {
        abort_if(!auth()->user()->can('penjualanmarketing.edit'), 403);

        $no_bukti = Crypt::decrypt($no_bukti);
        $request->validate([
            'tanggal' => 'required',
            'kode_pelanggan' => 'required',
            'jenis_transaksi' => 'required',
            'jenis_bayar' => 'required_if:jenis_transaksi,T',
            'kode_produk' => 'required|array|min:1',
            'kode_produk.*' => 'required',
            'harga_dus_produk' => 'required|array',
            'harga_dus_produk.*' => 'required',
            'jumlah_produk' => 'required|array',
            'jumlah_produk.*' => 'required',
            'subtotal' => 'required|array',
            'subtotal.*' => 'required'
        ]);

        $tanggal = $request->tanggal;
        $kode_pelanggan = $request->kode_pelanggan;
        $jenis_transaksi = $request->jenis_transaksi;
        $jenis_bayar = $jenis_transaksi == 'T' ? $request->jenis_bayar : 'TP';

        $kode_produk = $request->kode_produk;
        $harga_dus = $request->harga_dus_produk;
        $jumlah = $request->jumlah_produk;
        $subtotal = $request->subtotal;

        DB::beginTransaction();
        try {
            // Delete old details
            MarketingPenjualanDetail::where('no_bukti', $no_bukti)->delete();
            
            // Insert new details
            $detail = [];
            for ($i = 0; $i < count($kode_produk); $i++) {
                $detail[] = [
                    'no_bukti' => $no_bukti,
                    'kode_produk' => $kode_produk[$i],
                    'harga_dus' => toNumber($harga_dus[$i]),
                    'jumlah' => toNumber($jumlah[$i]),
                    'subtotal' => toNumber($subtotal[$i]),
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            MarketingPenjualanDetail::insert($detail);

            // Update header
            MarketingPenjualan::where('no_bukti', $no_bukti)->update([
                'tanggal' => $tanggal,
                'kode_pelanggan' => $kode_pelanggan,
                'jenis_transaksi' => $jenis_transaksi,
                'jenis_bayar' => $jenis_bayar
            ]);

            // Re-sync cash payment if TUNAI
            MarketingPenjualanHistoribayar::where('no_bukti_penjualan', $no_bukti)->delete();
            if ($jenis_transaksi == "T") {
                $total_penjualan = array_sum(array_map(function($subtotal) {
                    return toNumber($subtotal);
                }, $subtotal));

                $kode_cabang = auth()->user()->kode_cabang ?? 'PST';
                $tahun = date('y', strtotime($tanggal));
                
                $lasthistoribayar = MarketingPenjualanHistoribayar::select('no_bukti')
                    ->whereRaw('LEFT(no_bukti,6) = "' . $kode_cabang . $tahun . '-"')
                    ->orderBy("no_bukti", "desc")
                    ->first();

                $last_no_bukti = $lasthistoribayar != null ? $lasthistoribayar->no_bukti : '';
                $no_bukti_bayar = buatkode($last_no_bukti, $kode_cabang . $tahun . "-", 6);

                MarketingPenjualanHistoribayar::create([
                    'no_bukti' => $no_bukti_bayar,
                    'tanggal' => $tanggal,
                    'no_bukti_penjualan' => $no_bukti,
                    'jenis_bayar' => $jenis_bayar,
                    'jumlah' => $total_penjualan,
                    'kode_akun' => $jenis_bayar == 'TN' ? '1-1100' : '1-1200',
                    'id_user' => auth()->user()->id
                ]);

                MarketingPenjualan::where('no_bukti', $no_bukti)->update(['status' => '1']);
            } else {
                MarketingPenjualan::where('no_bukti', $no_bukti)->update(['status' => '0']);
            }

            DB::commit();
            return Redirect::route('penjualanmarketing.index')->with(messageSuccess('Data Berhasil Diupdate'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function destroy($no_bukti)
    {
        abort_if(!auth()->user()->can('penjualanmarketing.delete'), 403);

        $no_bukti = Crypt::decrypt($no_bukti);
        DB::beginTransaction();
        try {
            MarketingPenjualanHistoribayar::where('no_bukti_penjualan', $no_bukti)->delete();
            MarketingPenjualanDetail::where('no_bukti', $no_bukti)->delete();
            MarketingPenjualan::where('no_bukti', $no_bukti)->delete();

            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil Dihapus'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError('Data Gagal Dihapus: ' . $e->getMessage()));
        }
    }
}
