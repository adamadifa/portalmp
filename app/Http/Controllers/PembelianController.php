<?php

namespace App\Http\Controllers;

use App\Models\Barangmasukgudanglogistik;
use App\Models\Barangmasukmaintenance;
use App\Models\Barangpembelian;
use App\Models\Cabang;
use App\Models\Coa;
use App\Models\Coadepartemen;
use App\Models\Costratio;
use App\Models\Detailbarangmasukgudanglogistik;
use App\Models\Detailbarangmasukmaintenance;
use App\Models\Detailkontrabonpembelian;
use App\Models\Detailpembelian;
use App\Models\Kontrabonpembelian;
use App\Models\Pembelian;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PembelianController extends Controller
{
    public function index(Request $request)
    {

        if (!empty($request->dari) && !empty($request->sampai)) {
            if (lockreport($request->dari) == "error") {
                return Redirect::back()->with(messageError('Data Tidak Ditemukan'));
            }
        }

        $pmb = new Pembelian();
        $pembelian = $pmb->getPembelian(request: $request)->paginate(15);
        $pembelian->appends(request()->all());
        $data['pembelian'] = $pembelian;

        $data['asal_ajuan'] = config('pembelian.list_asal_pengajuan');
        $data['supplier'] = Supplier::orderBy('nama_supplier')->get();
        $cbg = new Cabang();
        $cabang = $cbg->getCabang();
        $data['cabang'] = $cabang;
        return view('pembelian.index', $data);
    }


    public function show($no_bukti)
    {
        $no_bukti = Crypt::decrypt($no_bukti);
        $pmb = new Pembelian();
        $data['pembelian'] = $pmb->getPembelian(no_bukti: $no_bukti)->first();

        $data['detail'] = Detailpembelian::select('pembelian_detail.*', 'nama_barang')
            ->join('pembelian_barang', 'pembelian_detail.kode_barang', '=', 'pembelian_barang.kode_barang')
            ->where('no_bukti', $no_bukti)
            ->where('pembelian_detail.kode_transaksi', 'PMB')
            ->get();

        $data['potongan'] = Detailpembelian::select('pembelian_detail.*', 'nama_barang')
            ->join('pembelian_barang', 'pembelian_detail.kode_barang', '=', 'pembelian_barang.kode_barang')
            ->where('no_bukti', $no_bukti)
            ->where('pembelian_detail.kode_transaksi', 'PNJ')
            ->get();

        $data['kontrabon'] = Detailkontrabonpembelian::select(
            'pembelian_kontrabon_detail.*',
            'pembelian_kontrabon.tanggal as tanggal_kontrabon',
            'kategori',
            'pembelian_historibayar.tanggal as tanggal_bayar'
        )
            ->join('pembelian_kontrabon', 'pembelian_kontrabon_detail.no_kontrabon', '=', 'pembelian_kontrabon.no_kontrabon')
            ->leftjoin('pembelian_historibayar', 'pembelian_historibayar.no_kontrabon', '=', 'pembelian_kontrabon.no_kontrabon')
            ->where('no_bukti', $no_bukti)
            ->orderBy('pembelian_kontrabon.tanggal', 'desc')
            ->get();


        $data['asal_pengajuan'] = config('pembelian.asal_pengajuan');
        return view('pembelian.show', $data);
    }

    public function cetak($no_bukti)
    {
        $no_bukti = Crypt::decrypt($no_bukti);
        $pmb = new Pembelian();
        $data['pembelian'] = $pmb->getPembelian(no_bukti: $no_bukti)->first();

        $data['detail'] = Detailpembelian::select('pembelian_detail.*', 'nama_barang')
            ->join('pembelian_barang', 'pembelian_detail.kode_barang', '=', 'pembelian_barang.kode_barang')
            ->where('no_bukti', $no_bukti)
            ->where('pembelian_detail.kode_transaksi', 'PMB')
            ->get();

        $data['potongan'] = Detailpembelian::select('pembelian_detail.*', 'nama_barang')
            ->join('pembelian_barang', 'pembelian_detail.kode_barang', '=', 'pembelian_barang.kode_barang')
            ->where('no_bukti', $no_bukti)
            ->where('pembelian_detail.kode_transaksi', 'PNJ')
            ->get();

        return view('pembelian.cetak', $data);
    }


    public function create()
    {
        $data['supplier'] = Supplier::orderBy('nama_supplier')->get();
        $data['asal_ajuan'] = config('pembelian.list_asal_pengajuan');
        $data['coa'] = Coadepartemen::where('kode_dept', 'PMB')
            ->join('coa', 'coa_departemen.kode_akun', '=', 'coa.kode_akun')
            ->orderBy('coa_departemen.kode_akun')
            ->get();

        $data['cabang'] = Cabang::orderBy('kode_cabang')->get();
        return view('pembelian.create', $data);
    }



    public function store(Request $request)
    {
        $request->validate([
            'no_bukti' => 'required',
            'tanggal' => 'required',
            'kode_supplier' => 'required',
            'kode_asal_pengajuan' => 'required',
            'jenis_transaksi' => 'required',
            'jatuh_tempo' => 'required_if:jenis_transaksi,K',
            'ppn' => 'required'
        ]);

        $kode_barang = $request->kode_barang_item;
        $jumlah = $request->jumlah_item;
        $harga = $request->harga_item;
        $penyesuaian = $request->penyesuaian_item;
        $kode_akun = $request->kode_akun_item;
        $keterangan = $request->keterangan_item;
        $kode_cabang = $request->kode_cabang_item;
        $no_po = $request->no_po;
        $kode_akun_cr = ['6-1', '6-2'];
        DB::beginTransaction();
        try {
            $cektutuplaporan = cektutupLaporan($request->tanggal, "pembelian");
            if ($cektutuplaporan > 0) {
                return Redirect::back()->with(messageError('Periode Laporan Sudah Ditutup'));
            }

            if (count($kode_barang) == 0) {
                return Redirect::back()->with(messageError('Detail Pembelian Masih Kosong'));
            }

            $total_pembelian = 0;
            $lastkodecr = '';
            for ($i = 0; $i < count($kode_barang); $i++) {
                $subtotal = toNumber($jumlah[$i]) * toNumber($harga[$i]) + toNumber($penyesuaian[$i]);
                $total_pembelian += $subtotal;

                //Jika Masuk kategori Cost Ratio
                if (in_array(substr($kode_akun[$i], 0, 3), $kode_akun_cr) && !empty($kode_cabang[$i])) {
                    $bulan_cr = date("m", strtotime($request->tanggal));
                    $tahun_cr = date("y", strtotime($request->tanggal));
                    $kode = "CR" . $bulan_cr . $tahun_cr;
                    $costratio = Costratio::select('kode_cr')
                        ->whereRaw('LEFT(kode_cr,6) ="' . $kode . '"')
                        ->orderBy('kode_cr', 'desc')
                        ->first();


                    if (empty($lastkodecr)) {
                        $last_kode_cr = $costratio != null ? $costratio->kode_cr : '';
                    } else {
                        $last_kode_cr = $lastkodecr;
                    }
                    $kode_cr = buatkode($last_kode_cr, "CR" . $bulan_cr . $tahun_cr, 4);
                    $barangpembelian = Barangpembelian::where('kode_barang', $kode_barang[$i])->first();
                    $data_costratio[] = [
                        'kode_cr' => $kode_cr,
                        'tanggal' => $request->tanggal,
                        'kode_akun' => $kode_akun[$i],
                        'keterangan' => "Pembelian " . $barangpembelian->nama_barang . "(" . $jumlah[$i] . ")",
                        'kode_cabang' => $kode_cabang[$i],
                        'kode_sumber' => 4,
                        'jumlah' => $subtotal
                    ];

                    $lastkodecr = $kode_cr;
                } else {
                    $kode_cr = NULL;
                }


                $detail[] = [
                    'no_bukti' => $request->no_bukti,
                    'kode_barang' => $kode_barang[$i],
                    'jumlah' => toNumber($jumlah[$i]),
                    'harga' => toNumber($harga[$i]),
                    'penyesuaian' => toNumber($penyesuaian[$i]),
                    'kode_akun' => $kode_akun[$i],
                    'keterangan' => $keterangan[$i],
                    'kode_cabang' => $kode_cabang[$i],
                    'kode_transaksi' => 'PMB',
                    'kode_cr' => $kode_cr
                ];
            }


            //Insert Data pembelian
            Pembelian::create([
                'no_bukti' => $request->no_bukti,
                'tanggal' => $request->tanggal,
                'kode_supplier' => $request->kode_supplier,
                'kode_asal_pengajuan' => $request->kode_asal_pengajuan,
                'jenis_transaksi' => $request->jenis_transaksi,
                'jatuh_tempo' => $request->jenis_transaksi == "K" ? $request->jatuh_tempo : $request->tanggal,
                'ppn' => $request->ppn,
                'kategori_transaksi' => $request->kategori_transaksi,
                'kode_akun' => $request->kode_asal_pengajuan == 'GDB' ? '2-1200' : '2-1300',
                'no_po' => $no_po,
                'id_user' => auth()->user()->id
            ]);


            $timestamp = Carbon::now();
            //Insert Detail Pembelian
            Detailpembelian::insert($detail);

            //Jika Ada Data Pembleian Yang Masuk Kategori Cost Ratio
            if (!empty($data_costratio)) {

                foreach ($data_costratio as &$record) {
                    $record['created_at'] = $timestamp;
                    $record['updated_at'] = $timestamp;
                }
                Costratio::insert($data_costratio);
            }

            //Insert Kontrabon Jika Jenis Transaksi Tunai
            if ($request->jenis_transaksi == 'T') {
                $no_kontrabon = "T" . date('dmY', strtotime($request->tanggal)) . rand(10, 99);
                Kontrabonpembelian::create([
                    'no_kontrabon' => $no_kontrabon,
                    'tanggal' => $request->tanggal,
                    'kode_supplier' => $request->kode_supplier,
                    'kategori' => 'TN',
                    'jenis_bayar' => 'TN',
                    'id_user' => auth()->user()->id,
                    'status' => 0,

                ]);

                Detailkontrabonpembelian::create([
                    'no_kontrabon' => $no_kontrabon,
                    'no_bukti' => $request->no_bukti,
                    'jumlah' => $total_pembelian,
                    'keterangan' => 'tunai'
                ]);
            }
            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }


    public function destroy($no_bukti)
    {
        $no_bukti = Crypt::decrypt($no_bukti);
        DB::beginTransaction();
        try {
            $pembelian = Pembelian::where('no_bukti', $no_bukti)->first();
            $detailpembelian = Detailpembelian::where('no_bukti', $no_bukti)->get();
            $cektutuplaporan = cektutupLaporan($pembelian->tanggal, "pembelian");
            $cekkontrabonpembeliansudahbayar = Detailkontrabonpembelian::leftJoin('pembelian_historibayar', 'pembelian_kontrabon_detail.no_kontrabon', '=', 'pembelian_historibayar.no_kontrabon')
                ->whereNotNull('pembelian_historibayar.no_kontrabon')
                ->where('pembelian_kontrabon_detail.no_bukti', $no_bukti)
                ->count();


            if ($cektutuplaporan > 0) {
                return Redirect::back()->with(messageError('Periode Laporan Sudah Ditutup'));
            }

            if ($cekkontrabonpembeliansudahbayar > 0) {
                return Redirect::back()->with(messageError('Data Tidak Dapat DiHapus, Karena Memiliki Kontrabon Yang Sudah Dibayar'));
            }



            //Hapus Cost Ratio
            foreach ($detailpembelian as $d) {
                if (!empty($d->kode_cr)) {
                    Costratio::where('kode_cr', $d->kode_cr)->delete();
                }
            }

            //List Kontrabon Pembelian
            $kontrabonpembelian = Detailkontrabonpembelian::where('no_bukti', $no_bukti)->get();
            foreach ($kontrabonpembelian as $d) {
                //Hapus Detail Kontrabon Pembelian
                Detailkontrabonpembelian::where('no_bukti', $no_bukti)->where('no_kontrabon', $d->no_kontrabon)->delete();
                $cekdetailkontrabon = Detailkontrabonpembelian::where('no_kontrabon', $d->no_kontrabon)->count();
                if (empty($cekdetailkontrabon)) {
                    Kontrabonpembelian::where('no_kontrabon', $d->no_kontrabon)->delete();
                }
            }
            Pembelian::where('no_bukti', $no_bukti)->delete();
            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil Dihapus'));
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }


    public function edit($no_bukti)
    {
        $no_bukti = Crypt::decrypt($no_bukti);
        $pmb = new Pembelian();
        $data['pembelian'] = $pmb->getPembelian(no_bukti: $no_bukti)->first();

        $data['detail'] = Detailpembelian::select('pembelian_detail.*', 'nama_barang', 'nama_akun')
            ->join('pembelian_barang', 'pembelian_detail.kode_barang', '=', 'pembelian_barang.kode_barang')
            ->leftjoin('coa', 'pembelian_detail.kode_akun', '=', 'coa.kode_akun')
            ->where('pembelian_detail.no_bukti', $no_bukti)
            ->where('pembelian_detail.kode_transaksi', 'PMB')
            ->select('pembelian_detail.*', 'pembelian_barang.nama_barang', 'coa.nama_akun')
            ->get();

        $data['potongan'] = Detailpembelian::select('pembelian_detail.*', 'nama_barang', 'nama_akun')
            ->join('pembelian_barang', 'pembelian_detail.kode_barang', '=', 'pembelian_barang.kode_barang')
            ->leftjoin('coa', 'pembelian_detail.kode_akun', '=', 'coa.kode_akun')
            ->where('no_bukti', $no_bukti)
            ->where('pembelian_detail.kode_transaksi', 'PNJ')
            ->get();

        $data['supplier'] = Supplier::orderBy('nama_supplier')->get();
        $data['asal_ajuan'] = config('pembelian.list_asal_pengajuan');
        $data['coa'] = Coadepartemen::where('kode_dept', 'PMB')
            ->join('coa', 'coa_departemen.kode_akun', '=', 'coa.kode_akun')
            ->orderBy('coa_departemen.kode_akun')
            ->get();

        $data['cekhistoribayar'] = Detailkontrabonpembelian::where('no_bukti', $no_bukti)
            ->leftJoin('pembelian_historibayar', 'pembelian_kontrabon_detail.no_kontrabon', '=', 'pembelian_historibayar.no_kontrabon')
            ->whereNotNull('pembelian_historibayar.no_kontrabon')->count();

        //dd($data['cekhistoribayar']);

        $data['cabang'] = Cabang::orderBy('kode_cabang')->get();
        return view('pembelian.edit', $data);
    }


    public function createpotongan()
    {
        $data['coa'] = Coadepartemen::where('kode_dept', 'PMB')
            ->join('coa', 'coa_departemen.kode_akun', '=', 'coa.kode_akun')
            ->orderBy('coa_departemen.kode_akun')
            ->get();

        return view('pembelian.createpotongan', $data);
    }

    public function editpotongan(Request $request)
    {
        $datapotongan = $request->datapotongan;
        $data['datapotongan'] = $datapotongan;
        $data['coa'] = Coadepartemen::where('kode_dept', 'PMB')
            ->join('coa', 'coa_departemen.kode_akun', '=', 'coa.kode_akun')
            ->orderBy('coa_departemen.kode_akun')
            ->get();
        return view('pembelian.editpotongan', $data);
    }

    public function editbarang(Request $request)
    {
        $databarang = $request->databarang;
        $data['databarang'] = $databarang;

        $data['barang'] = Barangpembelian::where('kode_barang', $databarang['kode_barang'])->first();
        $data['coa'] = Coadepartemen::where('kode_dept', 'PMB')
            ->join('coa', 'coa_departemen.kode_akun', '=', 'coa.kode_akun')
            ->orderBy('coa_departemen.kode_akun')
            ->get();
        $data['cabang'] = Cabang::orderBy('kode_cabang')->get();
        return view('pembelian.editbarang', $data);
    }


    public function splitbarang(Request $request)
    {
        $databarang = $request->databarang;
        $data['databarang'] = $databarang;

        $data['barang'] = Barangpembelian::where('kode_barang', $databarang['kode_barang'])->first();
        $data['coa'] = Coadepartemen::where('kode_dept', 'PMB')
            ->join('coa', 'coa_departemen.kode_akun', '=', 'coa.kode_akun')
            ->orderBy('coa_departemen.kode_akun')
            ->get();
        $data['akun'] = Coa::where('kode_akun', $databarang['kode_akun'])->first();
        $data['cabang'] = Cabang::orderBy('kode_cabang')->get();
        return view('pembelian.splitbarang', $data);
    }

    public function update($no_bukti, Request $request)
    {
        $request->validate([
            'no_bukti' => 'required',
            'tanggal' => 'required',
            'kode_supplier' => 'required',
            'jenis_transaksi' => 'required',
            'jatuh_tempo' => 'required_if:jenis_transaksi,K',
            'ppn' => 'required'
        ]);

        $no_bukti = Crypt::decrypt($no_bukti);
        $kode_barang = $request->kode_barang_item;
        $jumlah = $request->jumlah_item;
        $harga = $request->harga_item;
        $penyesuaian = $request->penyesuaian_item;
        $kode_akun = $request->kode_akun_item;
        $keterangan = $request->keterangan_item;
        $kode_cabang = $request->kode_cabang_item;
        $kode_akun_cr = ['6-1', '6-2'];

        //Potongan
        $keterangan_potongan = $request->keterangan_potongan_item;
        $kode_akun_potongan = $request->kode_akun_potongan_item;
        $jumlah_potongan = $request->jumlah_potongan_item;
        $harga_potongan = $request->harga_potongan_item;

        //dd($keterangan_potongan);
        //dd($harga);
        DB::beginTransaction();
        try {

            $cektutuplaporan = cektutupLaporan($request->tanggal, "pembelian");
            if ($cektutuplaporan > 0) {
                return Redirect::back()->with(messageError('Periode Laporan Sudah Ditutup'));
            }

            if (count($kode_barang) == 0) {
                return Redirect::back()->with(messageError('Detail Pembelian Masih Kosong'));
            }


            //dd('test');
            $total_pembelian = 0;
            $lastkodecr = '';

            for ($i = 0; $i < count($kode_barang); $i++) {

                $subtotal = toNumber($jumlah[$i]) * toNumber($harga[$i]) + toNumber($penyesuaian[$i]);
                $total_pembelian += $subtotal;

                //Jika Masuk kategori Cost Ratio
                if (in_array(substr($kode_akun[$i], 0, 3), $kode_akun_cr) && !empty($kode_cabang[$i])) {
                    $bulan_cr = date("m", strtotime($request->tanggal));
                    $tahun_cr = date("y", strtotime($request->tanggal));
                    $kode = "CR" . $bulan_cr . $tahun_cr;
                    $costratio = Costratio::select('kode_cr')
                        ->whereRaw('LEFT(kode_cr,6) ="' . $kode . '"')
                        ->orderBy('kode_cr', 'desc')
                        ->first();


                    if (empty($lastkodecr)) {
                        $last_kode_cr = $costratio != null ? $costratio->kode_cr : '';
                    } else {
                        $last_kode_cr = $lastkodecr;
                    }
                    $kode_cr = buatkode($last_kode_cr, "CR" . $bulan_cr . $tahun_cr, 4);
                    $barangpembelian = Barangpembelian::where('kode_barang', $kode_barang[$i])->first();
                    $data_costratio[] = [
                        'kode_cr' => $kode_cr,
                        'tanggal' => $request->tanggal,
                        'kode_akun' => $kode_akun[$i],
                        'keterangan' => "Pembelian " . $barangpembelian->nama_barang . "(" . $jumlah[$i] . ")",
                        'kode_cabang' => $kode_cabang[$i],
                        'kode_sumber' => 4,
                        'jumlah' => $subtotal
                    ];

                    $lastkodecr = $kode_cr;
                } else {
                    $kode_cr = NULL;
                }


                $detail[] = [
                    'no_bukti' => $request->no_bukti,
                    'kode_barang' => $kode_barang[$i],
                    'jumlah' => toNumber($jumlah[$i]),
                    'harga' => toNumber($harga[$i]),
                    'penyesuaian' => toNumber($penyesuaian[$i]),
                    'kode_akun' => $kode_akun[$i],
                    'keterangan' => $keterangan[$i],
                    'kode_cabang' => $kode_cabang[$i],
                    'kode_transaksi' => 'PMB',
                    'kode_cr' => $kode_cr
                ];
            }


            $pembelian = Pembelian::where('no_bukti', $no_bukti)->first();
            $detailpembelian = Detailpembelian::where('no_bukti', $no_bukti)->get();
            $cekhistoribayar = Detailkontrabonpembelian::where('no_bukti', $no_bukti)
                ->leftJoin('pembelian_historibayar', 'pembelian_kontrabon_detail.no_kontrabon', '=', 'pembelian_historibayar.no_kontrabon')
                ->whereNotNull('pembelian_historibayar.no_kontrabon')
                ->count();

            //Jika Ubah Transaksi dari Kredit ke Tunai
            if ($pembelian->jenis_transaksi == "K" && $request->jenis_transaksi == "T") {
                //Cek Apakah Sudah Ada Kontrabon Yang Di Bayar
                if ($cekhistoribayar > 0) {
                    return Redirect::back()->with(messageError('Tidak Bisa Ubah Jenis Transaksi, Karena Sudah Ada Kontrabon Yang Sudah Dibayar, Silahkan Hubungi Bagian Keuangan. Untuk Membatalkan Pembayaran'));
                }

                $cekkontrabon = Detailkontrabonpembelian::where('no_bukti', $no_bukti)->get();
                foreach ($cekkontrabon as $d) {
                    //Hapus Detail Kontrabon Pembelian
                    Detailkontrabonpembelian::where('no_bukti', $no_bukti)->where('no_kontrabon', $d->no_kontrabon)->delete();
                    $cekdetailkontrabon = Detailkontrabonpembelian::where('no_kontrabon', $d->no_kontrabon)->count();
                    if (empty($cekdetailkontrabon)) {
                        Kontrabonpembelian::where('no_kontrabon', $d->no_kontrabon)->delete();
                    }
                }

                $no_kontrabon = "T" . date('dmY', strtotime($request->tanggal)) . rand(10, 99);
                Kontrabonpembelian::create([
                    'no_kontrabon' => $no_kontrabon,
                    'tanggal' => $request->tanggal,
                    'kode_supplier' => $request->kode_supplier,
                    'kategori' => 'TN',
                    'jenis_bayar' => 'TN',
                    'id_user' => auth()->user()->id,
                    'status' => 0,

                ]);

                Detailkontrabonpembelian::create([
                    'no_kontrabon' => $no_kontrabon,
                    'no_bukti' => $request->no_bukti,
                    'jumlah' => $total_pembelian,
                    'keterangan' => 'tunai'
                ]);
            } else if ($pembelian->jenis_transaksi == 'T' && $request->jenis_transaksi == 'K') {
                //Jika Mengubah Transaksi Kredit Menjadi Tunai
                //Cek Apakah Sudah Ada Kontrabon Yang Di Bayar
                if ($cekhistoribayar > 0) {
                    return Redirect::back()->with(messageError('Tidak Bisa Ubah Jenis Transaksi, Karena Sudah Ada Kontrabon Yang Sudah Dibayar, Silahkan Hubungi Bagian Keuangan. Untuk Membatalkan Pembayaran'));
                }

                $cekkontrabon = Detailkontrabonpembelian::where('no_bukti', $no_bukti)->get();
                foreach ($cekkontrabon as $d) {
                    //Hapus Detail Kontrabon Pembelian
                    Detailkontrabonpembelian::where('no_bukti', $no_bukti)->where('no_kontrabon', $d->no_kontrabon)->delete();
                    $cekdetailkontrabon = Detailkontrabonpembelian::where('no_kontrabon', $d->no_kontrabon)->count();
                    if (empty($cekdetailkontrabon)) {
                        Kontrabonpembelian::where('no_kontrabon', $d->no_kontrabon)->delete();
                    }
                }
            } else {
                //Update Kontrabon
                $kontrabon = Detailkontrabonpembelian::where('no_bukti', $no_bukti)->get();
                $no_kontrabon = [];
                foreach ($kontrabon as $k) {
                    $no_kontrabon[] = $k->no_kontrabon;
                }

                if ($request->jenis_transaksi == 'T') {
                    $data_kb = [
                        'tanggal' => $request->tanggal,
                        'kode_supplier' => $request->kode_supplier,
                    ];
                } else {
                    $data_kb = [
                        'kode_supplier' => $request->kode_supplier,
                    ];
                }

                Kontrabonpembelian::whereIn('no_kontrabon', $no_kontrabon)->update($data_kb);
            }

            //Update Data pembelian
            Pembelian::where('no_bukti', $no_bukti)->update([
                'no_bukti' => $request->no_bukti,
                'tanggal' => $request->tanggal,
                'kode_supplier' => $request->kode_supplier,
                'jenis_transaksi' => $request->jenis_transaksi,
                'jatuh_tempo' => $request->jenis_transaksi == "K" ? $request->jatuh_tempo : $request->tanggal,
                'ppn' => $request->ppn,
                'kategori_transaksi' => $request->kategori_transaksi,
                'id_user' => auth()->user()->id
            ]);


            //Hapus Cost Ratio
            foreach ($detailpembelian as $d) {
                if (!empty($d->kode_cr)) {
                    Costratio::where('kode_cr', $d->kode_cr)->delete();
                }
            }

            //Hapus Detail Pembelian Sebelumnya
            Detailpembelian::where('no_bukti', $request->no_bukti)->delete();

            //Insert Detail Pembelian Baru

            $timestamp = Carbon::now();
            //Insert Detail Pembelian
            Detailpembelian::insert($detail);

            //Jika Ada Data Pembleian Yang Masuk Kategori Cost Ratio
            if (!empty($data_costratio)) {

                foreach ($data_costratio as &$record) {
                    $record['created_at'] = $timestamp;
                    $record['updated_at'] = $timestamp;
                }
                Costratio::insert($data_costratio);
            }

            //Jika Ada Potongan
            $total_potongan = 0;

            if (!empty($keterangan_potongan)) {
                for ($i = 0; $i < count($keterangan_potongan); $i++) {
                    $subtotal_potongan = toNumber($jumlah_potongan[$i]) * toNumber($harga_potongan[$i]);
                    $total_potongan += $subtotal_potongan;
                    $detailpotongan[] = [
                        'no_bukti' => $request->no_bukti,
                        'kode_barang' => 'PNJKR',
                        'keterangan_penjualan' => $keterangan_potongan[$i],
                        'jumlah' => toNumber($jumlah_potongan[$i]),
                        'penyesuaian' => 0.00,
                        'harga' => toNumber($harga_potongan[$i]),
                        'kode_akun' => $kode_akun_potongan[$i],
                        'kode_transaksi' => 'PNJ',
                    ];
                }
                Detailpembelian::insert($detailpotongan);

                $jml_kontrabon = $total_pembelian - $total_potongan;
            } else {
                $jml_kontrabon = $total_pembelian;
            }

            if ($request->jenis_transaksi == 'T') {
                Detailkontrabonpembelian::where('no_bukti', $request->no_bukti)->update([
                    'jumlah' => $jml_kontrabon
                ]);
            }
            DB::commit();
            return redirect(route('pembelian.edit', Crypt::encrypt($request->no_bukti)))->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollBack();
            //dd($e);
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function jatuhtempo(Request $request)
    {
        if (!empty($request->jatuhtempo_dari) && !empty($request->jatuhtempo_sampai)) {
            if (lockreport($request->jatuhtempo_dari) == "error") {
                return Redirect::back()->with(messageError('Data Tidak Ditemukan'));
            }
        }

        $pmb = new Pembelian();
        $pembelian = $pmb->getPembelian(request: $request)->paginate(15);
        $pembelian->appends(request()->all());
        $data['pembelian'] = $pembelian;

        $data['asal_ajuan'] = config('pembelian.list_asal_pengajuan');
        $data['supplier'] = Supplier::orderBy('nama_supplier')->get();

        return view('pembelian.jatuhtempo', $data);
    }


    public function getpembelianbysupplier($kode_supplier)
    {
        $pmb = new Pembelian();
        $pembelian = $pmb->getPembelian(kode_supplier: $kode_supplier)->get();
        echo "<option value=''>No. Bukti Pembelian</option>";
        foreach ($pembelian as $d) {
            echo "<option value='$d->no_bukti'>" . $d->no_bukti . " (" . date('d-m-y', strtotime($d->tanggal)) . " ) </option>";
        }
    }


    public function getbarangpembelian(Request $request)
    {
        $detail = Detailpembelian::join('pembelian_barang', 'pembelian_detail.kode_barang', '=', 'pembelian_barang.kode_barang')
            ->where('no_bukti', $request->no_bukti)->get();
        echo "<option value=''>Pilih Barang</option>";
        foreach ($detail as $d) {
            echo "<option value='$d->kode_barang'>" . $d->nama_barang . "</option>";
        }
    }


    public function getpembelianbysupplierjson(Request $request, $kode_supplier)
    {

        if ($request->ajax()) {
            $pmb = new Pembelian();
            $pembelian = $pmb->getPembelian(kode_supplier: $kode_supplier);
            return DataTables::of($pembelian)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" class="pilihnobukti inline-flex items-center justify-center px-2.5 py-1 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-lg transition shadow-sm" no_bukti="' . $row->no_bukti . '"
                    total_pembelian="' . $row->total_pembelian . '"
                    total_bayar="' . $row->total_bayar . '"
                    >Pilih</button>';
                    return $btn;
                })
                ->addColumn('asal_pengajuan', function ($row) {
                    $asal_pengajuan = config('pembelian.asal_pengajuan');
                    $asalpengajuan = $asal_pengajuan[$row->kode_asal_pengajuan];
                    return $asalpengajuan;
                })

                ->addColumn('cekppn', function ($row) {
                    if ($row->ppn === 1) {
                        $ppn = "<i class='ti ti-checks text-success'></i>";
                    } else {
                        $ppn = "<i class='ti ti-square-rounded-x text-danger'></i>";
                    }
                    // $ppn = "<i class='ti ti-checks'></i>";
                    return $ppn;
                })

                ->addColumn('totalpembelian', function ($row) {
                    return formatAngkaDesimal($row->total_pembelian);
                })

                ->addColumn('subtotal', function ($row) {
                    return formatAngkaDesimal($row->subtotal);
                })

                ->addColumn('penyesuaianjk', function ($row) {
                    return formatAngkaDesimal($row->penyesuaian_jk);
                })
                ->rawColumns(['action', 'asal_pengajuan', 'cekppn', 'totalpembelian', 'subtotal', 'penyesuaianjk'])
                ->make(true);
        }
    }


    public function approvegdl($no_bukti)
    {
        $no_bukti = Crypt::decrypt($no_bukti);
        $pmb = new Pembelian();
        $data['pembelian'] = $pmb->getPembelian(no_bukti: $no_bukti)->first();

        $data['detail'] = Detailpembelian::select('pembelian_detail.*', 'nama_barang')
            ->join('pembelian_barang', 'pembelian_detail.kode_barang', '=', 'pembelian_barang.kode_barang')
            ->where('no_bukti', $no_bukti)
            ->where('pembelian_detail.kode_transaksi', 'PMB')
            ->get();




        $data['asal_pengajuan'] = config('pembelian.asal_pengajuan');
        return view('pembelian.approvegdl', $data);
    }


    public function storeapprovegdl(Request $request, $no_bukti)
    {
        $no_bukti = Crypt::decrypt($no_bukti);
        DB::beginTransaction();
        try {

            $pembelian = Pembelian::where('no_bukti', $no_bukti)->first();
            $detailpembelian = Detailpembelian::where('no_bukti', $no_bukti)
                ->where('pembelian_detail.kode_transaksi', 'PMB')
                ->get();

            $cektutuplaporan = cektutupLaporan($request->tanggal, "gudanglogistik");
            if ($cektutuplaporan > 0) {
                return Redirect::back()->with(messageError('Periode Laporan Sudah Ditutup'));
            }

            Barangmasukgudanglogistik::create([
                'no_bukti' => $pembelian->no_bukti,
                'tanggal' => $request->tanggal,
            ]);


            foreach ($detailpembelian as $d) {
                $detail[] = [
                    'no_bukti' => $d->no_bukti,
                    'kode_barang' => $d->kode_barang,
                    'keterangan' => $d->keterangan,
                    'jumlah' => $d->jumlah,
                    'harga' => $d->harga,
                    'penyesuaian' => $d->penyesuaian,
                    'kode_akun' => $d->kode_akun
                ];
            }

            //dd($detail);
            Detailbarangmasukgudanglogistik::insert($detail);

            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }


    public function cancelapprovegdl($no_bukti)
    {
        $no_bukti = Crypt::decrypt($no_bukti);
        DB::beginTransaction();
        try {
            $barangmasuk = Barangmasukgudanglogistik::where('no_bukti', $no_bukti)->first();
            $cektutuplaporan = cektutupLaporan($barangmasuk->tanggal, "gudanglogistik");
            if ($cektutuplaporan > 0) {
                return Redirect::back()->with(messageError('Periode Laporan Sudah Ditutup'));
            }

            Barangmasukgudanglogistik::where('no_bukti', $no_bukti)->delete();

            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil di Dibatalkan'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }


    public function approvemtc($no_bukti)
    {
        $no_bukti = Crypt::decrypt($no_bukti);
        $pmb = new Pembelian();
        $data['pembelian'] = $pmb->getPembelian(no_bukti: $no_bukti)->first();

        $data['detail'] = Detailpembelian::select('pembelian_detail.*', 'nama_barang')
            ->join('pembelian_barang', 'pembelian_detail.kode_barang', '=', 'pembelian_barang.kode_barang')
            ->where('no_bukti', $no_bukti)
            ->where('kode_akun', '1-1505')
            ->where('pembelian_detail.kode_transaksi', 'PMB')
            ->get();




        $data['asal_pengajuan'] = config('pembelian.asal_pengajuan');
        return view('pembelian.approvemtc', $data);
    }

    public function storeapprovemtc(Request $request, $no_bukti)
    {
        $no_bukti = Crypt::decrypt($no_bukti);
        DB::beginTransaction();
        try {

            $pembelian = Pembelian::where('no_bukti', $no_bukti)->first();
            $detailpembelian = Detailpembelian::where('no_bukti', $no_bukti)->where('kode_akun', '1-1505')
                ->where('pembelian_detail.kode_transaksi', 'PMB')
                ->get();

            $cektutuplaporan = cektutupLaporan($request->tanggal, "maintenance");
            if ($cektutuplaporan > 0) {
                return Redirect::back()->with(messageError('Periode Laporan Sudah Ditutup'));
            }

            Barangmasukmaintenance::create([
                'no_bukti' => $pembelian->no_bukti,
                'tanggal' => $request->tanggal,

            ]);


            foreach ($detailpembelian as $d) {
                $detail[] = [
                    'no_bukti' => $d->no_bukti,
                    'kode_barang' => $d->kode_barang,
                    'keterangan' => $d->keterangan,
                    'jumlah' => $d->jumlah
                ];
            }

            //dd($detail);
            Detailbarangmasukmaintenance::insert($detail);

            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }


    public function cancelapprovemtc($no_bukti)
    {
        $no_bukti = Crypt::decrypt($no_bukti);
        DB::beginTransaction();
        try {
            $barangmasuk = Barangmasukmaintenance::where('no_bukti', $no_bukti)->first();
            $cektutuplaporan = cektutupLaporan($barangmasuk->tanggal, "maintenance");
            if ($cektutuplaporan > 0) {
                return Redirect::back()->with(messageError('Periode Laporan Sudah Ditutup'));
            }

            Barangmasukmaintenance::where('no_bukti', $no_bukti)->delete();

            DB::commit();
            return Redirect::back()->with(messageSuccess('Data Berhasil di Dibatalkan'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }


    public function getPoBySupplier($kode_supplier)
    {
        $po = DB::table('po')
            ->where('kode_supplier', $kode_supplier)
            ->orderBy('tanggal', 'desc')
            ->limit(20)
            ->get();

        $data = [];
        foreach ($po as $p) {
            $data[] = [
                'id' => $p->no_bukti,
                'text' => $p->no_bukti . ' | ' . $p->tanggal
            ];
        }

        return response()->json($data);
    }

    public function resetData()
    {
        abort_if(!auth()->user()->can('pembelian.create'), 403);

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            
            $tables = [
                'pembelian_historibayar',
                'pembelian_kontrabon_detail',
                'pembelian_kontrabon',
                'pembelian_detail',
                'pembelian',
                'accounting_costratio',
                'gudang_logistik_barang_masuk_detail',
                'gudang_logistik_barang_masuk',
                'maintenance_barang_masuk_detail',
                'maintenance_barang_masuk'
            ];

            foreach ($tables as $table) {
                if (\Illuminate\Support\Facades\Schema::hasTable($table)) {
                    DB::table($table)->truncate();
                }
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return Redirect::route('pembelian.index')->with(messageSuccess('Seluruh Data Pembelian Berhasil Direset'));
        } catch (\Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return Redirect::back()->with(messageError('Gagal mereset data: ' . $e->getMessage()));
        }
    }

    public function importExcel(Request $request)
    {
        abort_if(!auth()->user()->can('pembelian.create'), 403);

        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv',
            'jenis_transaksi' => 'required'
        ]);

        $file = $request->file('file_excel');
        $jenis_transaksi = $request->jenis_transaksi;

        try {
            $spreadsheet = IOFactory::load($file->getRealPath());
            
            $sanitize = function($str) {
                return preg_replace('/[^a-z0-9]/', '', strtolower(trim($str)));
            };

            $sheet = null;
            $headerRow = 1;

            $inputSheet = $request->sheet_name;
            if (!empty($inputSheet)) {
                if (is_numeric($inputSheet)) {
                    $sheetIndex = (int)$inputSheet - 1;
                    if ($sheetIndex >= 0 && $sheetIndex < $spreadsheet->getSheetCount()) {
                        $sheet = $spreadsheet->getSheet($sheetIndex);
                    }
                } else {
                    $sheet = $spreadsheet->getSheetByName($inputSheet);
                }
            }

            // Auto-detect sheet if not found
            if (!$sheet) {
                foreach ($spreadsheet->getAllSheets() as $currentSheet) {
                    $highestRow = $currentSheet->getHighestRow();
                    for ($r = 1; $r <= min(5, $highestRow); $r++) {
                        for ($col = 1; $col <= 20; $col++) {
                            $val = $sanitize($currentSheet->getCell([$col, $r])->getValue() ?? '');
                            if ($val === 'nobukti' || $val === 'nomorbukti' || $val === 'tanggal') {
                                $sheet = $currentSheet;
                                $headerRow = $r;
                                break 2;
                            }
                        }
                    }
                    if ($sheet) {
                        break;
                    }
                }
            } else {
                $highestRow = $sheet->getHighestRow();
                for ($r = 1; $r <= min(5, $highestRow); $r++) {
                    for ($col = 1; $col <= 20; $col++) {
                        $val = $sanitize($sheet->getCell([$col, $r])->getValue() ?? '');
                        if ($val === 'nobukti' || $val === 'nomorbukti' || $val === 'tanggal') {
                            $headerRow = $r;
                            break 2;
                        }
                    }
                }
            }

            if (!$sheet) {
                throw new \Exception("Tidak ditemukan sheet yang memiliki kolom 'No. Bukti' atau 'Tanggal'.");
            }

            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

            $colMap = [];
            for ($col = 1; $col <= $highestColumnIndex; $col++) {
                $rawVal = $sheet->getCell([$col, $headerRow])->getValue();
                if ($rawVal !== null && $rawVal !== '') {
                    $cleanedVal = $sanitize($rawVal);
                    $colMap[$cleanedVal] = $col;
                }
            }

            // Find mandatory columns
            $colNoBukti = $colMap['nobukti'] ?? $colMap['nomorbukti'] ?? null;
            $colTanggal = $colMap['tanggal'] ?? null;
            $colSupplier = $colMap['codesupplier'] ?? $colMap['kodesupplier'] ?? null;
            $colBarang = $colMap['codeproduk'] ?? $colMap['kodeproduk'] ?? $colMap['kodebarang'] ?? $colMap['codebarang'] ?? null;
            $colQty = $colMap['qty'] ?? $colMap['jumlah'] ?? null;
            $colHarga = $colMap['harga'] ?? null;
            $colAkun = $colMap['kodeakun'] ?? null;
            $colFakturPajak = $colMap['nofakturpajak'] ?? null;
            $colJenis = $colMap['jenis'] ?? $colMap['kategoritransaksi'] ?? null;
            $colKeterangan = $colMap['jenisproduct'] ?? $colMap['namaproduk'] ?? $colMap['namabarang'] ?? null;
            $colPpn = $colMap['ppn'] ?? null;

            if (!$colNoBukti || !$colTanggal || !$colSupplier || !$colBarang || !$colQty || !$colHarga || !$colAkun) {
                throw new \Exception("Kolom minimal wajib (No. Bukti, Tanggal, Supplier, Produk/Barang, Qty, Harga, Kode Akun) tidak ditemukan.");
            }

            $rows = [];
            $consecutiveEmpty = 0;
            for ($r = $headerRow + 1; $r <= $highestRow; $r++) {
                $noBuktiVal = trim($sheet->getCell([$colNoBukti, $r])->getCalculatedValue() ?? '');
                if (empty($noBuktiVal)) {
                    $consecutiveEmpty++;
                    if ($consecutiveEmpty >= 20) {
                        break;
                    }
                    continue;
                }
                $consecutiveEmpty = 0;

                $tanggalCell = $sheet->getCell([$colTanggal, $r]);
                $tanggalVal = trim($tanggalCell->getCalculatedValue() ?? '');
                if (\PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($tanggalCell)) {
                    $tanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggalCell->getValue())->format('Y-m-d');
                } else {
                    $tanggal = date('Y-m-d', strtotime($tanggalVal));
                }

                $kodeSupplier = trim($sheet->getCell([$colSupplier, $r])->getCalculatedValue() ?? '');
                $kodeBarang = trim($sheet->getCell([$colBarang, $r])->getCalculatedValue() ?? '');
                $qty = (float) toNumber(trim($sheet->getCell([$colQty, $r])->getCalculatedValue() ?? 0));
                $harga = (float) toNumber(trim($sheet->getCell([$colHarga, $r])->getCalculatedValue() ?? 0));
                $kodeAkun = trim($sheet->getCell([$colAkun, $r])->getCalculatedValue() ?? '');
                
                $noFakPajak = $colFakturPajak ? trim($sheet->getCell([$colFakturPajak, $r])->getCalculatedValue() ?? '') : null;
                $kategoriTransaksi = $colJenis ? trim($sheet->getCell([$colJenis, $r])->getCalculatedValue() ?? '') : 'PPM';
                $keterangan = $colKeterangan ? trim($sheet->getCell([$colKeterangan, $r])->getCalculatedValue() ?? '') : null;
                
                $ppnVal = 0;
                if ($colPpn) {
                    $ppnVal = (float) toNumber(trim($sheet->getCell([$colPpn, $r])->getCalculatedValue() ?? 0));
                }

                if (empty($kodeSupplier) || empty($kodeBarang)) {
                    continue;
                }

                $rows[] = [
                    'no_bukti' => $noBuktiVal,
                    'tanggal' => $tanggal,
                    'kode_supplier' => $kodeSupplier,
                    'kode_barang' => $kodeBarang,
                    'qty' => $qty,
                    'harga' => $harga,
                    'kode_akun' => $kodeAkun,
                    'no_fak_pajak' => $noFakPajak,
                    'kategori_transaksi' => substr($kategoriTransaksi, 0, 2),
                    'keterangan' => $keterangan,
                    'ppn_val' => $ppnVal
                ];
            }

            if (empty($rows)) {
                throw new \Exception("Tidak ada data pembelian yang valid untuk diimport.");
            }

            // Group by no_bukti
            $grouped = [];
            foreach ($rows as $row) {
                $grouped[$row['no_bukti']][] = $row;
            }

            DB::beginTransaction();

            foreach ($grouped as $noBukti => $items) {
                $firstItem = $items[0];

                // Validate Supplier
                $supplier = Supplier::where('kode_supplier', $firstItem['kode_supplier'])->first();
                if (!$supplier) {
                    throw new \Exception("Kode Supplier '{$firstItem['kode_supplier']}' tidak ditemukan di database.");
                }

                // Check if pembelian already exists
                $existing = Pembelian::where('no_bukti', $noBukti)->first();
                if ($existing) {
                    throw new \Exception("Transaksi dengan No. Bukti '{$noBukti}' sudah ada di database.");
                }

                // Determine PPN
                $hasPpn = '0';
                foreach ($items as $item) {
                    if ($item['ppn_val'] > 0) {
                        $hasPpn = '1';
                        break;
                    }
                }

                // Insert Header
                Pembelian::create([
                    'no_bukti' => $noBukti,
                    'tanggal' => $firstItem['tanggal'],
                    'kode_supplier' => $firstItem['kode_supplier'],
                    'kode_asal_pengajuan' => 'GDL',
                    'kode_akun' => $firstItem['kode_akun'],
                    'ppn' => $hasPpn,
                    'no_fak_pajak' => $firstItem['no_fak_pajak'],
                    'jatuh_tempo' => $jenis_transaksi == 'K' ? date('Y-m-d', strtotime($firstItem['tanggal'] . ' +30 days')) : $firstItem['tanggal'],
                    'jenis_transaksi' => $jenis_transaksi,
                    'kategori_transaksi' => $firstItem['kategori_transaksi'],
                    'id_user' => auth()->user()->id
                ]);

                // Insert Details
                $detailData = [];
                foreach ($items as $item) {
                    // Validate Barang
                    $barang = Barangpembelian::where('kode_barang', $item['kode_barang'])->first();
                    if (!$barang) {
                        $barang = Barangpembelian::create([
                            'kode_barang' => $item['kode_barang'],
                            'nama_barang' => $item['keterangan'] ?? 'ITEM BARU ' . $item['kode_barang'],
                            'satuan' => 'BUAH',
                            'kode_jenis_barang' => 'LN',
                            'kode_kategori' => 'K001',
                            'kode_group' => 'GDL',
                            'status' => '1'
                        ]);
                    }

                    $detailData[] = [
                        'no_bukti' => $noBukti,
                        'kode_barang' => $item['kode_barang'],
                        'jumlah' => $item['qty'],
                        'harga' => $item['harga'],
                        'penyesuaian' => 0,
                        'keterangan' => $item['keterangan'] ?? $barang->nama_barang,
                        'kode_transaksi' => 'PMB',
                        'kode_akun' => $item['kode_akun'],
                        'kode_cabang' => auth()->user()->kode_cabang ?? 'PST',
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }

                Detailpembelian::insert($detailData);
            }

            DB::commit();
            return Redirect::route('pembelian.index')->with(messageSuccess('Data Pembelian Berhasil Diimport dari Excel'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError('Gagal melakukan import: ' . $e->getMessage()));
        }
    }

    public function getSheets(Request $request)
    {
        abort_if(!auth()->user()->can('pembelian.create'), 403);

        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            $file = $request->file('file_excel');
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheetNames = $spreadsheet->getSheetNames();

            return response()->json([
                'success' => true,
                'sheets' => $sheetNames
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
