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
use PhpOffice\PhpSpreadsheet\IOFactory;

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

    public function importExcel(Request $request)
    {
        abort_if(!auth()->user()->can('penjualanmarketing.create'), 403);

        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv',
            'jenis_transaksi' => 'required',
            'jenis_bayar' => 'required_if:jenis_transaksi,T'
        ]);

        $file = $request->file('file_excel');
        $jenis_transaksi = $request->jenis_transaksi;
        $jenis_bayar = $jenis_transaksi == 'T' ? $request->jenis_bayar : 'TP';

        try {
            $spreadsheet = IOFactory::load($file->getRealPath());
            
            // Helper untuk membersihkan spasi/karakter khusus dari header
            $sanitize = function($str) {
                return preg_replace('/[^a-z0-9]/', '', strtolower(trim($str)));
            };

            $sheet = null;
            $headerRow = 1;

            // Jika user menentukan nama/nomor sheet
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

            // Jika sheet tidak ditentukan atau tidak ditemukan, deteksi otomatis sheet yang memiliki kolom data
            if (!$sheet) {
                foreach ($spreadsheet->getAllSheets() as $currentSheet) {
                    $highestRow = $currentSheet->getHighestRow();
                    for ($r = 1; $r <= min(5, $highestRow); $r++) {
                        for ($col = 1; $col <= 16; $col++) {
                            $val = $sanitize($currentSheet->getCell([$col, $r])->getValue() ?? '');
                            if ($val === 'tanggal' || $val === 'noinv' || $val === 'kodepelanggan') {
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
                // Cari header row untuk sheet yang dipilih manual
                $highestRow = $sheet->getHighestRow();
                for ($r = 1; $r <= min(5, $highestRow); $r++) {
                    for ($col = 1; $col <= 16; $col++) {
                        $val = $sanitize($sheet->getCell([$col, $r])->getValue() ?? '');
                        if ($val === 'tanggal' || $val === 'noinv' || $val === 'kodepelanggan') {
                            $headerRow = $r;
                            break 2;
                        }
                    }
                }
            }

            if (!$sheet) {
                throw new \Exception("Tidak ditemukan sheet yang memiliki kolom 'tanggal' atau 'kode pelanggan'. Silakan periksa isi file Excel Anda.");
            }

            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            // Map kolom berdasarkan nama header yang disanitasi
            $colMap = [];
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
            for ($col = 1; $col <= $highestColumnIndex; $col++) {
                $rawVal = $sheet->getCell([$col, $headerRow])->getValue();
                if ($rawVal !== null && $rawVal !== '') {
                    $cleanedVal = $sanitize($rawVal);
                    $colMap[$cleanedVal] = $col;
                }
            }

            // Validasi kolom minimal yang wajib ada
            $requiredCols = [
                'tanggal' => 'tanggal',
                'kodepelanggan' => 'kode pelanggan',
                'kodeproduk' => 'kode produk',
                'qty' => 'qty',
                'harga' => 'harga'
            ];

            foreach ($requiredCols as $cleanedKey => $label) {
                if (!isset($colMap[$cleanedKey])) {
                    throw new \Exception("Kolom wajib '{$label}' tidak ditemukan di file Excel. Kolom yang terdeteksi: " . implode(', ', array_keys($colMap)));
                }
            }

            // Baca baris data
            $rows = [];
            for ($r = $headerRow + 1; $r <= $highestRow; $r++) {
                $tanggalCell = $sheet->getCell([$colMap['tanggal'], $r]);
                $tanggalVal = trim($tanggalCell->getCalculatedValue() ?? '');
                
                if (empty($tanggalVal)) {
                    continue; // Skip baris kosong
                }

                // Parse tanggal Excel
                if (\PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($tanggalCell)) {
                    $tanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggalVal)->format('Y-m-d');
                } else {
                    $tanggal = date('Y-m-d', strtotime($tanggalVal));
                }

                $fakturPajakVal = isset($colMap['nofakturpajak']) ? trim($sheet->getCell([$colMap['nofakturpajak'], $r])->getCalculatedValue() ?? '') : '';
                if (empty($fakturPajakVal)) {
                    $fakturPajakVal = isset($colMap['noinv']) ? trim($sheet->getCell([$colMap['noinv'], $r])->getCalculatedValue() ?? '') : '';
                }
                if (empty($fakturPajakVal)) {
                    $fakturPajakVal = 'ROW_' . $r; // Fallback jika tidak ada nomor invoice/faktur pajak
                }

                $kodePelanggan = trim($sheet->getCell([$colMap['kodepelanggan'], $r])->getCalculatedValue() ?? '');
                $kodeProduk = trim($sheet->getCell([$colMap['kodeproduk'], $r])->getCalculatedValue() ?? '');
                $qty = (float) toNumber(trim($sheet->getCell([$colMap['qty'], $r])->getCalculatedValue() ?? 0));
                $harga = (float) toNumber(trim($sheet->getCell([$colMap['harga'], $r])->getCalculatedValue() ?? 0));
                $jumlah = isset($colMap['jumlah']) ? (float) toNumber(trim($sheet->getCell([$colMap['jumlah'], $r])->getCalculatedValue() ?? 0)) : 0;

                if (empty($kodePelanggan) || empty($kodeProduk)) {
                    continue;
                }

                if ($jumlah == 0) {
                    $jumlah = $qty * $harga;
                }

                $rows[] = [
                    'tanggal' => $tanggal,
                    'group_key' => $fakturPajakVal,
                    'kode_pelanggan' => $kodePelanggan,
                    'kode_produk' => $kodeProduk,
                    'qty' => $qty,
                    'harga' => $harga,
                    'jumlah' => $jumlah
                ];
            }

            if (empty($rows)) {
                throw new \Exception("Tidak ada data penjualan yang valid untuk diimport.");
            }

            // Kelompokkan berdasarkan group_key
            $grouped = [];
            foreach ($rows as $row) {
                $grouped[$row['group_key']][] = $row;
            }

            $lastSeqCache = [];

            DB::beginTransaction();

            foreach ($grouped as $groupKey => $items) {
                $firstItem = $items[0];
                
                // Validasi Pelanggan
                $pelanggan = Pelanggan::where('kode_pelanggan', $firstItem['kode_pelanggan'])->first();
                if (!$pelanggan) {
                    throw new \Exception("Kode Pelanggan '{$firstItem['kode_pelanggan']}' tidak ditemukan di database.");
                }

                // Generate no_bukti: PJ + YYMM + - + 4 digit counter (contoh PJ2608-0001)
                $tglTrans = $firstItem['tanggal'];
                $yymm = date('ym', strtotime($tglTrans));
                $prefix = 'PJ' . $yymm . '-';

                if (!isset($lastSeqCache[$prefix])) {
                    $latest = DB::table('marketing_penjualan')
                        ->where('no_bukti', 'like', $prefix . '%')
                        ->orderBy('no_bukti', 'desc')
                        ->first();
                    if ($latest) {
                        $lastNum = (int) substr($latest->no_bukti, strlen($prefix));
                        $lastSeqCache[$prefix] = $lastNum;
                    } else {
                        $lastSeqCache[$prefix] = 0;
                    }
                }

                $lastSeqCache[$prefix]++;
                $no_bukti = $prefix . str_pad($lastSeqCache[$prefix], 4, '0', STR_PAD_LEFT);

                // Insert Header
                MarketingPenjualan::create([
                    'no_bukti' => $no_bukti,
                    'tanggal' => $tglTrans,
                    'kode_pelanggan' => $firstItem['kode_pelanggan'],
                    'jenis_transaksi' => $jenis_transaksi,
                    'jenis_bayar' => $jenis_bayar,
                    'status' => '0',
                    'kode_cabang' => auth()->user()->kode_cabang ?? 'PST',
                    'id_user' => auth()->user()->id
                ]);

                // Validasi dan persiapkan data detail
                $detailData = [];
                $total_penjualan = 0;
                $productCodes = [];

                foreach ($items as $item) {
                    $kp = $item['kode_produk'];
                    
                    // Cek duplikat produk dalam satu nomor invoice / faktur pajak
                    if (in_array($kp, $productCodes)) {
                        throw new \Exception("Terdapat produk ganda '{$kp}' pada Nomor Faktur Pajak/Invoice '{$groupKey}'. Silakan perbaiki file Excel Anda terlebih dahulu.");
                    }
                    $productCodes[] = $kp;

                    $produk = Produk::where('kode_produk', $kp)->first();
                    if (!$produk) {
                        throw new \Exception("Kode Produk '{$kp}' tidak ditemukan di database.");
                    }

                    $detailData[] = [
                        'no_bukti' => $no_bukti,
                        'kode_produk' => $kp,
                        'harga_dus' => $item['harga'],
                        'jumlah' => $item['qty'],
                        'subtotal' => $item['jumlah'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                    $total_penjualan += $item['jumlah'];
                }
                
                MarketingPenjualanDetail::insert($detailData);

                // Jika Tunai, buat histori bayar dan set lunas
                if ($jenis_transaksi == 'T') {
                    $kode_cabang = auth()->user()->kode_cabang ?? 'PST';
                    $tahun = date('y', strtotime($tglTrans));
                    
                    $lasthistoribayar = MarketingPenjualanHistoribayar::select('no_bukti')
                        ->whereRaw('LEFT(no_bukti,6) = "' . $kode_cabang . $tahun . '-"')
                        ->orderBy("no_bukti", "desc")
                        ->first();

                    $last_no_bukti = $lasthistoribayar != null ? $lasthistoribayar->no_bukti : '';
                    $no_bukti_bayar = buatkode($last_no_bukti, $kode_cabang . $tahun . "-", 6);

                    MarketingPenjualanHistoribayar::create([
                        'no_bukti' => $no_bukti_bayar,
                        'tanggal' => $tglTrans,
                        'no_bukti_penjualan' => $no_bukti,
                        'jenis_bayar' => $jenis_bayar,
                        'jumlah' => $total_penjualan,
                        'kode_akun' => $jenis_bayar == 'TN' ? '1-1100' : '1-1200',
                        'id_user' => auth()->user()->id
                    ]);

                    MarketingPenjualan::where('no_bukti', $no_bukti)->update(['status' => '1']);
                }
            }

            DB::commit();
            return Redirect::route('penjualanmarketing.index')->with(messageSuccess('Data Penjualan Berhasil Diimport dari Excel'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError('Gagal melakukan import: ' . $e->getMessage()));
        }
    }

    public function getSheets(Request $request)
    {
        abort_if(!auth()->user()->can('penjualanmarketing.create'), 403);

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

    public function resetData()
    {
        abort_if(!auth()->user()->can('penjualanmarketing.create'), 403);

        try {
            DB::beginTransaction();

            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('marketing_penjualan_historibayar')->truncate();
            DB::table('marketing_penjualan_detail')->truncate();
            DB::table('marketing_penjualan')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            DB::commit();
            return Redirect::route('penjualanmarketing.index')->with(messageSuccess('Seluruh Data Penjualan Berhasil Direset'));
        } catch (\Exception $e) {
            DB::rollBack();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return Redirect::back()->with(messageError('Gagal mereset data: ' . $e->getMessage()));
        }
    }

    public function deleteSelected(Request $request)
    {
        abort_if(!auth()->user()->can('penjualanmarketing.delete'), 403);

        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            $no_buktis = $request->ids;
            
            // Delete matching records. Cascade triggers details and historibayar deletions automatically.
            MarketingPenjualan::whereIn('no_bukti', $no_buktis)->delete();

            DB::commit();
            return Redirect::route('penjualanmarketing.index')->with(messageSuccess('Transaksi penjualan yang terpilih berhasil dihapus'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError('Gagal menghapus data terpilih: ' . $e->getMessage()));
        }
    }
}
