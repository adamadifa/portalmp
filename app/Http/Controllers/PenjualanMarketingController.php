<?php

namespace App\Http\Controllers;

use App\Models\Bank;
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

        $historibayar = DB::table('marketing_penjualan_historibayar')
            ->leftJoin('bank', 'marketing_penjualan_historibayar.kode_bank', '=', 'bank.kode_bank')
            ->select('marketing_penjualan_historibayar.*', 'bank.nama_bank')
            ->where('no_bukti_penjualan', $no_bukti)
            ->orderBy('tanggal', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        $bank = Bank::orderBy('nama_bank')->get();

        return view('marketing.penjualan.show', compact('penjualan', 'detail', 'historibayar', 'bank'));
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
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('marketing_penjualan_historibayar')->truncate();
            DB::table('marketing_penjualan_detail')->truncate();
            DB::table('marketing_penjualan')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return Redirect::route('penjualanmarketing.index')->with(messageSuccess('Seluruh Data Penjualan Berhasil Direset'));
        } catch (\Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return Redirect::back()->with(messageError('Gagal mereset data: ' . $e->getMessage()));
        }
    }

    public function resetPembayaran()
    {
        abort_if(!auth()->user()->can('penjualanmarketing.create'), 403);

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('marketing_penjualan_historibayar')->truncate();
            DB::table('marketing_penjualan')->where('jenis_transaksi', 'K')->update(['status' => '0']);
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return Redirect::route('penjualanmarketing.index')->with(messageSuccess('Seluruh Data Pembayaran Piutang Penjualan Berhasil Direset'));
        } catch (\Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return Redirect::back()->with(messageError('Gagal mereset data pembayaran: ' . $e->getMessage()));
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

    public function storeBayar(Request $request, $no_bukti)
    {
        abort_if(!auth()->user()->can('penjualanmarketing.create'), 403);
        $no_bukti = Crypt::decrypt($no_bukti);

        $jumlah_bayar = toNumber($request->jumlah);
        $request->merge(['jumlah_numeric' => $jumlah_bayar]);

        $request->validate([
            'tanggal' => 'required|date',
            'jumlah_numeric' => 'required|numeric|min:0.01',
            'kode_bank' => 'nullable|string|exists:bank,kode_bank',
            'jenis_bayar' => 'nullable|string|in:TN,TR',
        ]);

        $penjualan = MarketingPenjualan::where('no_bukti', $no_bukti)->firstOrFail();

        // Calculate total invoice
        $total_invoice = (float) DB::table('marketing_penjualan_detail')
            ->where('no_bukti', $no_bukti)
            ->sum('subtotal');

        // Calculate already paid
        $total_bayar_sebelumnya = DB::table('marketing_penjualan_historibayar')
            ->where('no_bukti_penjualan', $no_bukti)
            ->sum('jumlah') ?? 0;

        $sisa_tagihan = $total_invoice - $total_bayar_sebelumnya;

        if ($jumlah_bayar > $sisa_tagihan + 0.05) {
            return Redirect::back()->with(messageError('Jumlah pembayaran melebihi sisa tagihan! Sisa tagihan: ' . number_format($sisa_tagihan, 2, ',', '.')));
        }

        try {
            DB::beginTransaction();

            $bank = !empty($request->kode_bank) ? Bank::where('kode_bank', $request->kode_bank)->first() : null;
            $jenis_bayar = $request->jenis_bayar ?? ($bank && stripos($bank->nama_bank, 'KAS') !== false ? 'TN' : 'TR');
            $kode_akun = $bank ? ($bank->kode_akun ?? ($jenis_bayar == 'TN' ? '1-11101' : '1-11103')) : ($jenis_bayar == 'TN' ? '1-11101' : '1-11103');

            $kode_cabang = auth()->user()->kode_cabang ?? 'PST';
            $tahun = date('y', strtotime($request->tanggal));

            $lasthistoribayar = MarketingPenjualanHistoribayar::select('no_bukti')
                ->whereRaw('LEFT(no_bukti,6) = "' . $kode_cabang . $tahun . '-"')
                ->orderBy("no_bukti", "desc")
                ->first();

            $last_no_bukti = $lasthistoribayar != null ? $lasthistoribayar->no_bukti : '';
            $no_bukti_bayar = buatkode($last_no_bukti, $kode_cabang . $tahun . "-", 6);

            MarketingPenjualanHistoribayar::create([
                'no_bukti' => $no_bukti_bayar,
                'tanggal' => $request->tanggal,
                'no_bukti_penjualan' => $no_bukti,
                'jenis_bayar' => $jenis_bayar,
                'jumlah' => $jumlah_bayar,
                'kode_bank' => $request->kode_bank ?? ($bank ? $bank->kode_bank : null),
                'kode_akun' => $kode_akun,
                'id_user' => auth()->user()->id
            ]);

            // If fully paid, update status to 1
            $total_bayar_baru = $total_bayar_sebelumnya + $jumlah_bayar;
            if ($total_bayar_baru >= $total_invoice - 0.05) {
                $penjualan->update(['status' => '1']);
            }

            DB::commit();
            return Redirect::back()->with(messageSuccess('Pembayaran berhasil ditambahkan.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError('Gagal menyimpan pembayaran: ' . $e->getMessage()));
        }
    }

    public function destroyBayar($no_bukti_bayar)
    {
        abort_if(!auth()->user()->can('penjualanmarketing.delete'), 403);
        $no_bukti_bayar = Crypt::decrypt($no_bukti_bayar);

        $historibayar = MarketingPenjualanHistoribayar::where('no_bukti', $no_bukti_bayar)->firstOrFail();
        $no_bukti_penjualan = $historibayar->no_bukti_penjualan;

        try {
            DB::beginTransaction();

            $historibayar->delete();

            // Set status to Belum Lunas ('0')
            MarketingPenjualan::where('no_bukti', $no_bukti_penjualan)->update(['status' => '0']);

            DB::commit();
            return Redirect::back()->with(messageSuccess('Pembayaran berhasil dihapus.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError('Gagal menghapus pembayaran: ' . $e->getMessage()));
        }
    }

    public function updateBayar(Request $request, $no_bukti_bayar)
    {
        abort_if(!auth()->user()->can('penjualanmarketing.edit'), 403);
        $no_bukti_bayar = Crypt::decrypt($no_bukti_bayar);

        $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required',
            'kode_bank' => 'nullable|string|exists:bank,kode_bank',
            'jenis_bayar' => 'nullable|string|in:TN,TR',
        ]);

        $jumlah_bayar = toNumber($request->jumlah);

        $historibayar = MarketingPenjualanHistoribayar::where('no_bukti', $no_bukti_bayar)->firstOrFail();
        $no_bukti_penjualan = $historibayar->no_bukti_penjualan;

        $penjualan = MarketingPenjualan::where('no_bukti', $no_bukti_penjualan)->firstOrFail();

        // Calculate total invoice
        $total_invoice = (float) DB::table('marketing_penjualan_detail')
            ->where('no_bukti', $no_bukti_penjualan)
            ->sum('subtotal');

        // Calculate other payments (excluding this one)
        $total_bayar_lainnya = DB::table('marketing_penjualan_historibayar')
            ->where('no_bukti_penjualan', $no_bukti_penjualan)
            ->where('no_bukti', '!=', $no_bukti_bayar)
            ->sum('jumlah') ?? 0;

        $sisa_tagihan = $total_invoice - $total_bayar_lainnya;

        if ($jumlah_bayar > $sisa_tagihan + 0.05) {
            return Redirect::back()->with(messageError('Jumlah pembayaran melebihi sisa tagihan! Sisa tagihan: ' . number_format($sisa_tagihan, 2, ',', '.')));
        }

        try {
            DB::beginTransaction();

            $bank = !empty($request->kode_bank) ? Bank::where('kode_bank', $request->kode_bank)->first() : null;
            $jenis_bayar = $request->jenis_bayar ?? ($bank && stripos($bank->nama_bank, 'KAS') !== false ? 'TN' : 'TR');
            $kode_akun = $bank ? ($bank->kode_akun ?? ($jenis_bayar == 'TN' ? '1-11101' : '1-11103')) : ($jenis_bayar == 'TN' ? '1-11101' : '1-11103');

            $historibayar->update([
                'tanggal' => $request->tanggal,
                'jenis_bayar' => $jenis_bayar,
                'jumlah' => $jumlah_bayar,
                'kode_bank' => $request->kode_bank ?? ($bank ? $bank->kode_bank : null),
                'kode_akun' => $kode_akun,
            ]);

            // If fully paid, update status to 1, else 0
            $total_bayar_baru = $total_bayar_lainnya + $jumlah_bayar;
            if ($total_bayar_baru >= $total_invoice - 0.05) {
                $penjualan->update(['status' => '1']);
            } else {
                $penjualan->update(['status' => '0']);
            }

            DB::commit();
            return Redirect::back()->with(messageSuccess('Pembayaran berhasil diperbarui.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError('Gagal memperbarui pembayaran: ' . $e->getMessage()));
        }
    }

    public function importPembayaranExcel(Request $request)
    {
        abort_if(!auth()->user()->can('penjualanmarketing.create'), 403);

        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('file_excel');

        try {
            $spreadsheet = IOFactory::load($file->getRealPath());

            $sheet = null;
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
            if (!$sheet) {
                $sheet = $spreadsheet->getActiveSheet();
            }

            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

            // 1. Deteksi baris header
            $headerRowIndex = 1;
            for ($r = 1; $r <= min(10, $highestRow); $r++) {
                for ($c = 1; $c <= $highestColumnIndex; $c++) {
                    $val = strtolower(trim((string)($sheet->getCell([$c, $r])->getValue() ?? '')));
                    if (str_contains($val, 'nominal') || str_contains($val, 'pelanggan') || str_contains($val, 'bank')) {
                        $headerRowIndex = $r;
                        break 2;
                    }
                }
            }

            // 2. Pemetaan kolom
            $colMap = [];
            for ($c = 1; $c <= $highestColumnIndex; $c++) {
                $val = strtolower(trim((string)($sheet->getCell([$c, $headerRowIndex])->getValue() ?? '')));
                if (in_array($val, ['tgl', 'tanggal', 'tgl bayar', 'tglbayar', 'tgl. bayar'])) {
                    $colMap['tanggal'] = $c;
                } elseif (str_contains($val, 'nominal') || str_contains($val, 'jumlah') || str_contains($val, 'bayar')) {
                    $colMap['nominal'] = $c;
                } elseif (str_contains($val, 'kode pelanggan') || str_contains($val, 'kode_pelanggan')) {
                    $colMap['kode_pelanggan'] = $c;
                } elseif (str_contains($val, 'pelanggan') && !isset($colMap['kode_pelanggan'])) {
                    $colMap['kode_pelanggan'] = $c;
                } elseif (str_contains($val, 'inisial')) {
                    $colMap['inisial'] = $c;
                } elseif (str_contains($val, 'kode bank') || str_contains($val, 'kode_bank')) {
                    $colMap['kode_bank'] = $c;
                } elseif (str_contains($val, 'bank') && !isset($colMap['bank'])) {
                    $colMap['bank'] = $c;
                }
            }

            // Fallback jika tidak terdeteksi via nama header
            if (!isset($colMap['tanggal'])) $colMap['tanggal'] = 2;
            if (!isset($colMap['nominal'])) $colMap['nominal'] = 3;
            if (!isset($colMap['inisial'])) $colMap['inisial'] = 4;
            if (!isset($colMap['kode_pelanggan'])) $colMap['kode_pelanggan'] = 5;
            if (!isset($colMap['bank'])) $colMap['bank'] = 6;
            if (!isset($colMap['kode_bank'])) $colMap['kode_bank'] = 7;

            $dataStartRow = $headerRowIndex + 1;

            DB::beginTransaction();

            $totalPembayaranBaris = 0;
            $totalFakturTerbayar = 0;
            $totalNominalSukses = 0;
            $skippedMessages = [];
            $kelebihanBayar = [];

            // Cache data master pelanggan dan bank untuk efisiensi
            $allPelanggan = DB::table('pelanggan')->select('kode_pelanggan', 'nama_pelanggan')->get();
            $pelangganMap = [];
            foreach ($allPelanggan as $p) {
                $pelangganMap[strtoupper(trim($p->kode_pelanggan))] = $p;
            }

            $allBanks = DB::table('bank')->get();
            $bankCodeMap = [];
            foreach ($allBanks as $b) {
                $bankCodeMap[strtoupper(trim($b->kode_bank))] = $b;
            }

            for ($row = $dataStartRow; $row <= $highestRow; $row++) {
                // Nominal
                $nomVal = $sheet->getCell([$colMap['nominal'], $row])->getValue();
                if ($nomVal === null || $nomVal === '') {
                    continue;
                }

                if (is_numeric($nomVal)) {
                    $nominal = (float)$nomVal;
                } else {
                    $cleanStr = trim((string)$nomVal);
                    if (in_array(strtolower($cleanStr), ['total', 'grand total', 'grandtotal', 'subtotal', 'nominal', 'nominal pembayaran'])) {
                        continue;
                    }
                    if (strpos($cleanStr, ',') !== false && strpos($cleanStr, '.') !== false) {
                        if (strrpos($cleanStr, ',') > strrpos($cleanStr, '.')) {
                            $cleanStr = str_replace('.', '', $cleanStr);
                            $cleanStr = str_replace(',', '.', $cleanStr);
                        } else {
                            $cleanStr = str_replace(',', '', $cleanStr);
                        }
                    } elseif (strpos($cleanStr, '.') !== false) {
                        if (substr_count($cleanStr, '.') > 1) {
                            $cleanStr = str_replace('.', '', $cleanStr);
                        }
                    } elseif (strpos($cleanStr, ',') !== false) {
                        if (substr_count($cleanStr, ',') > 1) {
                            $cleanStr = str_replace(',', '', $cleanStr);
                        } else {
                            $cleanStr = str_replace(',', '.', $cleanStr);
                        }
                    }
                    $nominal = (float)$cleanStr;
                }

                if ($nominal <= 0) {
                    continue;
                }

                // Tanggal
                $cellTgl = $sheet->getCell([$colMap['tanggal'], $row]);
                $tglVal = $cellTgl->getValue();
                if (empty($tglVal)) {
                    continue;
                }

                if (\PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($cellTgl)) {
                    $tglFormatted = date('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($tglVal));
                } else {
                    $strTgl = trim((string)$tglVal);
                    $parsed = false;
                    foreach (['d/m/y', 'd/m/Y', 'd-m-Y', 'd-m-y', 'Y-m-d', 'Y/m/d'] as $fmt) {
                        $dt = \DateTime::createFromFormat($fmt, $strTgl);
                        if ($dt !== false) {
                            $tglFormatted = $dt->format('Y-m-d');
                            $parsed = true;
                            break;
                        }
                    }
                    if (!$parsed) {
                        $tglFormatted = date('Y-m-d', strtotime(str_replace('/', '-', $strTgl)));
                    }
                }

                // Kode Pelanggan
                $rawKodePelanggan = strtoupper(trim((string)($sheet->getCell([$colMap['kode_pelanggan'], $row])->getValue() ?? '')));
                if (empty($rawKodePelanggan) && isset($colMap['inisial'])) {
                    $rawKodePelanggan = strtoupper(trim((string)($sheet->getCell([$colMap['inisial'], $row])->getValue() ?? '')));
                }

                if (empty($rawKodePelanggan)) {
                    continue;
                }

                if (!isset($pelangganMap[$rawKodePelanggan])) {
                    $found = null;
                    foreach ($pelangganMap as $k => $p) {
                        if (str_contains($k, $rawKodePelanggan) || str_contains(strtoupper($p->nama_pelanggan), $rawKodePelanggan)) {
                            $found = $p;
                            break;
                        }
                    }
                    if (!$found) {
                        $skippedMessages[] = "Baris $row: Pelanggan '$rawKodePelanggan' tidak ditemukan di database.";
                        continue;
                    }
                    $pelangganObj = $found;
                } else {
                    $pelangganObj = $pelangganMap[$rawKodePelanggan];
                }

                $kodePelanggan = $pelangganObj->kode_pelanggan;

                // Bank
                $rawKodeBank = strtoupper(trim((string)($sheet->getCell([$colMap['kode_bank'], $row])->getValue() ?? '')));
                $rawNamaBank = strtoupper(trim((string)($sheet->getCell([$colMap['bank'], $row])->getValue() ?? '')));

                $bankObj = null;
                if (!empty($rawKodeBank) && isset($bankCodeMap[$rawKodeBank])) {
                    $bankObj = $bankCodeMap[$rawKodeBank];
                } elseif (!empty($rawNamaBank)) {
                    foreach ($allBanks as $b) {
                        if (str_contains(strtoupper($b->nama_bank), $rawNamaBank)) {
                            $bankObj = $b;
                            break;
                        }
                    }
                }
                if (!$bankObj) {
                    $bankObj = $bankCodeMap['BK047'] ?? $allBanks->first();
                }

                $kodeBank = $bankObj ? $bankObj->kode_bank : 'BK047';
                $kodeAkun = $bankObj ? ($bankObj->kode_akun ?? '1-11103') : '1-11103';
                $jenisBayar = (stripos($bankObj->nama_bank ?? '', 'KAS') !== false) ? 'TN' : 'TR';

                // Ambil semua faktur kredit yang belum lunas milik pelanggan ini secara FIFO (terawal ke terbaru)
                $sales = MarketingPenjualan::where('kode_pelanggan', $kodePelanggan)
                    ->where('jenis_transaksi', 'K')
                    ->where('status', '0')
                    ->orderBy('tanggal', 'asc')
                    ->orderBy('no_bukti', 'asc')
                    ->get();

                if ($sales->isEmpty()) {
                    $anyCreditSales = MarketingPenjualan::where('kode_pelanggan', $kodePelanggan)
                        ->where('jenis_transaksi', 'K')
                        ->exists();

                    if (!$anyCreditSales) {
                        $skippedMessages[] = "Baris $row: Pelanggan $kodePelanggan tidak memiliki faktur penjualan kredit.";
                    } else {
                        $kelebihanBayar[] = "Baris $row: Pelanggan $kodePelanggan (" . $pelangganObj->nama_pelanggan . ") pembayaran Rp " . number_format($nominal, 0, ',', '.') . " tidak dialokasikan karena seluruh faktur sudah Lunas.";
                    }
                    continue;
                }

                $sisaNominal = $nominal;
                $rowAllocated = false;

                foreach ($sales as $sale) {
                    if ($sisaNominal <= 0.01) {
                        break;
                    }

                    $totalInvoice = (float) DB::table('marketing_penjualan_detail')
                        ->where('no_bukti', $sale->no_bukti)
                        ->sum('subtotal');

                    $totalPaid = (float) DB::table('marketing_penjualan_historibayar')
                        ->where('no_bukti_penjualan', $sale->no_bukti)
                        ->sum('jumlah');

                    $sisaTagihan = $totalInvoice - $totalPaid;
                    if ($sisaTagihan <= 0.05) {
                        $sale->update(['status' => '1']);
                        continue;
                    }

                    $alokasi = min($sisaNominal, $sisaTagihan);

                    $kode_cabang = $sale->kode_cabang ?? 'PST';
                    $tahun = date('y', strtotime($tglFormatted));

                    $lasthistoribayar = DB::table('marketing_penjualan_historibayar')
                        ->whereRaw('LEFT(no_bukti,6) = ?', [$kode_cabang . $tahun . "-"])
                        ->orderBy("no_bukti", "desc")
                        ->lockForUpdate()
                        ->value('no_bukti');

                    $no_bukti_bayar = buatkode($lasthistoribayar, $kode_cabang . $tahun . "-", 6);

                    DB::table('marketing_penjualan_historibayar')->insert([
                        'no_bukti' => $no_bukti_bayar,
                        'tanggal' => $tglFormatted,
                        'no_bukti_penjualan' => $sale->no_bukti,
                        'jenis_bayar' => $jenisBayar,
                        'jumlah' => $alokasi,
                        'kode_bank' => $kodeBank,
                        'kode_akun' => $kodeAkun,
                        'id_user' => auth()->id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $totalPaidBaru = $totalPaid + $alokasi;
                    if ($totalPaidBaru >= $totalInvoice - 0.05) {
                        $sale->update(['status' => '1']);
                    }

                    $sisaNominal -= $alokasi;
                    $totalFakturTerbayar++;
                    $totalNominalSukses += $alokasi;
                    $rowAllocated = true;
                }

                if ($rowAllocated) {
                    $totalPembayaranBaris++;
                }

                if ($sisaNominal > 0.05) {
                    $kelebihanBayar[] = "Baris $row: Pelanggan $kodePelanggan ada kelebihan pembayaran Rp " . number_format($sisaNominal, 0, ',', '.') . " karena seluruh tagihan faktur telah tertutup.";
                }
            }

            DB::commit();

            $msg = "Import berhasil: $totalPembayaranBaris transaksi pembayaran diproses, dialokasikan ke $totalFakturTerbayar faktur penjualan (Total: Rp " . number_format($totalNominalSukses, 0, ',', '.') . ").";
            if (!empty($kelebihanBayar)) {
                $msg .= "\nCatatan Sisa Lebih Bayar:\n" . implode("\n", array_slice($kelebihanBayar, 0, 5));
                if (count($kelebihanBayar) > 5) {
                    $msg .= "\n...dan " . (count($kelebihanBayar) - 5) . " lainnya.";
                }
            }
            if (!empty($skippedMessages)) {
                $msg .= "\nDilewati:\n" . implode("\n", array_slice($skippedMessages, 0, 5));
            }

            return Redirect::route('penjualanmarketing.index')->with(messageSuccess($msg));

        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError('Gagal melakukan import pembayaran: ' . $e->getMessage()));
        }
    }
}
