<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Barangpembelian;
use App\Models\Biaya;
use App\Models\Cabang;
use App\Models\Coa;
use App\Models\Detailbiaya;
use App\Models\Historibayarbiaya;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BiayaController extends Controller
{
    public function index(Request $request)
    {
        $data['supplier'] = Supplier::orderBy('nama_supplier')->get();

        $biayaModel = new Biaya();
        $data['biaya'] = $biayaModel->getBiaya("", $request)->paginate(15);
        $data['biaya']->appends(request()->all());

        return view('biaya.index', $data);
    }

    public function create()
    {
        $data['supplier'] = Supplier::orderBy('nama_supplier')->get();
        $data['coa'] = Coa::orderBy('kode_akun')->get();
        $data['cabang'] = Cabang::orderBy('kode_cabang')->get();
        $data['bank'] = Bank::orderBy('nama_bank')->get();

        return view('biaya.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_bukti' => 'required',
            'tanggal' => 'required|date',
            'jenis_transaksi' => 'required|in:T,K',
            'kode_akun_item' => 'required|array|min:1',
        ]);

        $cek = Biaya::where('no_bukti', $request->no_bukti)->first();
        if ($cek) {
            return Redirect::back()->withInput()->with(['error' => 'No. Bukti Biaya sudah ada di database. Silakan gunakan nomor lain.']);
        }

        $kode_barang_item = $request->kode_barang_item ?? [];
        $nama_barang_item = $request->nama_barang_item ?? [];
        $kode_akun_item = $request->kode_akun_item ?? [];
        $keterangan_item = $request->keterangan_item ?? [];
        $jumlah_item = $request->jumlah_item ?? [];
        $harga_item = $request->harga_item ?? [];
        $penyesuaian_item = $request->penyesuaian_item ?? [];
        $kode_cabang_item = $request->kode_cabang_item ?? [];

        if (count($kode_akun_item) == 0) {
            return Redirect::back()->withInput()->with(['error' => 'Rincian detail biaya tidak boleh kosong.']);
        }

        DB::beginTransaction();
        try {
            Biaya::create([
                'no_bukti' => $request->no_bukti,
                'tanggal' => $request->tanggal,
                'kode_supplier' => $request->kode_supplier,
                'kode_akun' => $request->kode_akun ?? ($kode_akun_item[0] ?? null),
                'ppn' => '0',
                'tanggal_jatuh_tempo' => $request->jenis_transaksi == 'K' ? $request->tanggal_jatuh_tempo : null,
                'jenis_transaksi' => $request->jenis_transaksi,
                'keterangan' => $request->keterangan,
                'id_user' => auth()->user()->id ?? 1,
            ]);

            $total_biaya = 0;
            for ($i = 0; $i < count($kode_akun_item); $i++) {
                $jml = !empty($jumlah_item[$i]) ? toNumber($jumlah_item[$i]) : 1;
                $hrg = !empty($harga_item[$i]) ? toNumber($harga_item[$i]) : 0;
                $peny = !empty($penyesuaian_item[$i]) ? toNumber($penyesuaian_item[$i]) : 0;

                $subtotal = ($jml * $hrg) + $peny;
                $total_biaya += $subtotal;

                Detailbiaya::create([
                    'no_bukti' => $request->no_bukti,
                    'kode_barang' => $kode_barang_item[$i] ?? null,
                    'kode_akun' => $kode_akun_item[$i],
                    'keterangan' => $keterangan_item[$i] ?? ($nama_barang_item[$i] ?? null),
                    'jumlah' => $jml,
                    'harga' => $hrg,
                    'penyesuaian' => $peny,
                    'kode_cabang' => $kode_cabang_item[$i] ?? null,
                    'kode_transaksi' => 'BYA',
                ]);
            }

            DB::commit();
            return Redirect::route('biaya.index')->with(['success' => 'Transaksi Biaya Berhasil Disimpan.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withInput()->with(['error' => 'Gagal menyimpan transaksi biaya: ' . $e->getMessage()]);
        }
    }

    public function show($no_bukti)
    {
        try {
            $no_bukti_decrypted = Crypt::decrypt($no_bukti);
        } catch (\Exception $e) {
            $no_bukti_decrypted = $no_bukti;
        }

        $data['biaya'] = (new Biaya())->getBiaya($no_bukti_decrypted)->first();
        if (!$data['biaya']) {
            abort(404);
        }

        $data['detail'] = Detailbiaya::where('biaya_detail.no_bukti', $no_bukti_decrypted)
            ->join('coa', 'biaya_detail.kode_akun', '=', 'coa.kode_akun')
            ->leftJoin('pembelian_barang', 'biaya_detail.kode_barang', '=', 'pembelian_barang.kode_barang')
            ->select('biaya_detail.*', 'coa.nama_akun', 'pembelian_barang.nama_barang')
            ->get();

        $data['historibayar'] = Historibayarbiaya::where('no_bukti', $no_bukti_decrypted)
            ->join('bank', 'biaya_historibayar.kode_bank', '=', 'bank.kode_bank')
            ->join('users', 'biaya_historibayar.id_user', '=', 'users.id')
            ->select('biaya_historibayar.*', 'bank.nama_bank', 'users.name as nama_user')
            ->get();

        return view('biaya.show', $data);
    }

    public function edit($no_bukti)
    {
        try {
            $no_bukti_decrypted = Crypt::decrypt($no_bukti);
        } catch (\Exception $e) {
            $no_bukti_decrypted = $no_bukti;
        }

        $data['biaya'] = Biaya::findOrFail($no_bukti_decrypted);
        $data['detail'] = Detailbiaya::where('biaya_detail.no_bukti', $no_bukti_decrypted)
            ->leftJoin('pembelian_barang', 'biaya_detail.kode_barang', '=', 'pembelian_barang.kode_barang')
            ->select('biaya_detail.*', 'pembelian_barang.nama_barang')
            ->get();
        $data['supplier'] = Supplier::orderBy('nama_supplier')->get();
        $data['coa'] = Coa::orderBy('kode_akun')->get();
        $data['cabang'] = Cabang::orderBy('kode_cabang')->get();

        return view('biaya.edit', $data);
    }

    public function update($no_bukti, Request $request)
    {
        try {
            $no_bukti_decrypted = Crypt::decrypt($no_bukti);
        } catch (\Exception $e) {
            $no_bukti_decrypted = $no_bukti;
        }

        $biaya = Biaya::findOrFail($no_bukti_decrypted);

        $request->validate([
            'tanggal' => 'required|date',
            'jenis_transaksi' => 'required|in:T,K',
            'kode_akun_item' => 'required|array|min:1',
        ]);

        $kode_barang_item = $request->kode_barang_item ?? [];
        $nama_barang_item = $request->nama_barang_item ?? [];
        $kode_akun_item = $request->kode_akun_item ?? [];
        $keterangan_item = $request->keterangan_item ?? [];
        $jumlah_item = $request->jumlah_item ?? [];
        $harga_item = $request->harga_item ?? [];
        $penyesuaian_item = $request->penyesuaian_item ?? [];
        $kode_cabang_item = $request->kode_cabang_item ?? [];

        DB::beginTransaction();
        try {
            $biaya->update([
                'tanggal' => $request->tanggal,
                'kode_supplier' => $request->kode_supplier,
                'kode_akun' => $request->kode_akun ?? ($kode_akun_item[0] ?? null),
                'tanggal_jatuh_tempo' => $request->jenis_transaksi == 'K' ? $request->tanggal_jatuh_tempo : null,
                'jenis_transaksi' => $request->jenis_transaksi,
                'keterangan' => $request->keterangan,
            ]);

            Detailbiaya::where('no_bukti', $no_bukti_decrypted)->delete();

            for ($i = 0; $i < count($kode_akun_item); $i++) {
                $jml = !empty($jumlah_item[$i]) ? toNumber($jumlah_item[$i]) : 1;
                $hrg = !empty($harga_item[$i]) ? toNumber($harga_item[$i]) : 0;
                $peny = !empty($penyesuaian_item[$i]) ? toNumber($penyesuaian_item[$i]) : 0;

                Detailbiaya::create([
                    'no_bukti' => $no_bukti_decrypted,
                    'kode_barang' => $kode_barang_item[$i] ?? null,
                    'kode_akun' => $kode_akun_item[$i],
                    'keterangan' => $keterangan_item[$i] ?? ($nama_barang_item[$i] ?? null),
                    'jumlah' => $jml,
                    'harga' => $hrg,
                    'penyesuaian' => $peny,
                    'kode_cabang' => $kode_cabang_item[$i] ?? null,
                    'kode_transaksi' => 'BYA',
                ]);
            }

            DB::commit();
            return Redirect::route('biaya.index')->with(['success' => 'Data Biaya Berhasil Diperbarui.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withInput()->with(['error' => 'Gagal memperbarui data biaya: ' . $e->getMessage()]);
        }
    }

    public function destroy($no_bukti)
    {
        try {
            $no_bukti_decrypted = Crypt::decrypt($no_bukti);
        } catch (\Exception $e) {
            $no_bukti_decrypted = $no_bukti;
        }

        try {
            $biaya = Biaya::findOrFail($no_bukti_decrypted);
            $biaya->delete(); // Cascades detail and payment history
            return Redirect::back()->with(['success' => 'Data Biaya Berhasil Dihapus.']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Gagal menghapus biaya: ' . $e->getMessage()]);
        }
    }

    public function createprosespembayaran($no_bukti)
    {
        try {
            $no_bukti_decrypted = Crypt::decrypt($no_bukti);
        } catch (\Exception $e) {
            $no_bukti_decrypted = $no_bukti;
        }

        $data['biaya'] = (new Biaya())->getBiaya($no_bukti_decrypted)->first();
        if (!$data['biaya']) {
            abort(404);
        }

        $data['bank'] = Bank::orderBy('nama_bank')->get();
        return view('biaya.prosespembayaran', $data);
    }

    public function storeprosespembayaran($no_bukti, Request $request)
    {
        try {
            $no_bukti_decrypted = Crypt::decrypt($no_bukti);
        } catch (\Exception $e) {
            $no_bukti_decrypted = $no_bukti;
        }

        $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required',
            'kode_bank' => 'required',
        ]);

        $biaya = (new Biaya())->getBiaya($no_bukti_decrypted)->first();
        if (!$biaya) {
            return Redirect::back()->with(['error' => 'Data Biaya Tidak Ditemukan.']);
        }

        $jumlahBayar = toNumber($request->jumlah);
        if ($jumlahBayar <= 0) {
            return Redirect::back()->with(['error' => 'Jumlah Pembayaran Harus Lebih Dari 0.']);
        }

        if ($jumlahBayar > $biaya->sisa_bayar) {
            return Redirect::back()->with(['error' => 'Jumlah Pembayaran Melebihi Sisa Tagihan Biaya (Sisa: ' . formatAngkaDesimal($biaya->sisa_bayar) . ').']);
        }

        try {
            Historibayarbiaya::create([
                'no_bukti' => $no_bukti_decrypted,
                'tanggal' => $request->tanggal,
                'jumlah' => $jumlahBayar,
                'kode_bank' => $request->kode_bank,
                'kode_cabang' => $request->kode_cabang ?? null,
                'keterangan' => $request->keterangan ?? 'Pembayaran Biaya ' . $no_bukti_decrypted,
                'id_user' => auth()->user()->id ?? 1,
            ]);

            return Redirect::back()->with(['success' => 'Pembayaran Biaya Berhasil Disimpan.']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Gagal memproses pembayaran: ' . $e->getMessage()]);
        }
    }

    public function showpembayaran($no_bukti)
    {
        try {
            $no_bukti_decrypted = Crypt::decrypt($no_bukti);
        } catch (\Exception $e) {
            $no_bukti_decrypted = $no_bukti;
        }

        $data['biaya'] = (new Biaya())->getBiaya($no_bukti_decrypted)->first();
        if (!$data['biaya']) {
            abort(404);
        }

        $data['historibayar'] = Historibayarbiaya::where('no_bukti', $no_bukti_decrypted)
            ->join('bank', 'biaya_historibayar.kode_bank', '=', 'bank.kode_bank')
            ->join('users', 'biaya_historibayar.id_user', '=', 'users.id')
            ->select('biaya_historibayar.*', 'bank.nama_bank', 'users.name as nama_user')
            ->orderBy('biaya_historibayar.tanggal', 'desc')
            ->get();

        return view('biaya.showpembayaran', $data);
    }

    public function deletepembayaran($id)
    {
        try {
            $id_decrypted = Crypt::decrypt($id);
        } catch (\Exception $e) {
            $id_decrypted = $id;
        }

        try {
            $bayar = Historibayarbiaya::findOrFail($id_decrypted);
            $bayar->delete();
            return Redirect::back()->with(['success' => 'Histori Pembayaran Berhasil Dibatalkan / Dihapus.']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Gagal membatalkan pembayaran: ' . $e->getMessage()]);
        }
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('file_excel');
        $jenis_transaksi = $request->jenis_transaksi ?? 'T';

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

            $sanitize = function ($str) {
                return strtolower(preg_replace('/[^a-zA-Z0-9]/', '', (string)$str));
            };

            // Search for header row
            $headerRow = 1;
            $colMap = [];
            for ($r = 1; $r <= min(10, $highestRow); $r++) {
                $tempColMap = [];
                for ($col = 1; $col <= $highestColumnIndex; $col++) {
                    $rawVal = $sheet->getCell([$col, $r])->getValue();
                    if ($rawVal !== null) {
                        $cleanedVal = $sanitize($rawVal);
                        $tempColMap[$cleanedVal] = $col;
                    }
                }
                if (
                    isset($tempColMap['nobukti']) ||
                    isset($tempColMap['nomorbukti']) ||
                    isset($tempColMap['no']) ||
                    isset($tempColMap['kodeakun']) ||
                    isset($tempColMap['produk']) ||
                    isset($tempColMap['namasupplier'])
                ) {
                    $headerRow = $r;
                    $colMap = $tempColMap;
                    break;
                }
            }

            // Identify columns
            $colNoBukti = $colMap['nobukti'] ?? $colMap['nomorbukti'] ?? $colMap['no_bukti'] ?? null;
            $colTanggal = $colMap['tanggal'] ?? $colMap['tgl'] ?? null;
            $colBulan = $colMap['bulan'] ?? null;
            $colAkun = $colMap['kodeakun'] ?? $colMap['kode_akun'] ?? $colMap['noakun'] ?? $colMap['coa'] ?? null;
            $colNamaAkun = $colMap['namaakun'] ?? $colMap['nama_akun'] ?? null;
            $colNamaSupplier = $colMap['namasupplier'] ?? $colMap['nama_supplier'] ?? $colMap['supplier'] ?? $colMap['rekanan'] ?? null;
            $colKodeSupplier = $colMap['kodesupplier'] ?? $colMap['kode_supplier'] ?? $colMap['codesupplier'] ?? null;
            $colProduk = $colMap['produk'] ?? $colMap['namaproduk'] ?? $colMap['nama_produk'] ?? $colMap['product'] ?? $colMap['namabarang'] ?? $colMap['nama_barang'] ?? $colMap['rincian'] ?? $colMap['keterangan'] ?? null;
            $colJenisProduk = $colMap['jenisproduct'] ?? $colMap['jenisproduk'] ?? null;
            $colKodeProduk = $colMap['kodeproduk'] ?? $colMap['kode_produk'] ?? $colMap['codeproduk'] ?? $colMap['kodebarang'] ?? $colMap['kode_barang'] ?? $colMap['codebarang'] ?? null;
            $colQty = $colMap['qty'] ?? $colMap['jumlah'] ?? $colMap['volume'] ?? $colMap['kuantiti'] ?? null;
            $colHarga = $colMap['harga'] ?? $colMap['hargasatuan'] ?? $colMap['harga_satuan'] ?? null;
            $colDpp = $colMap['dpp'] ?? null;
            $colTotal = $colMap['total'] ?? $colMap['jumlah'] ?? $colMap['subtotal'] ?? $colMap['grandtotal'] ?? null;
            $colPeny = $colMap['peny'] ?? $colMap['penyesuaian'] ?? null;

            if (!$colNoBukti) {
                // Fallback default column indices based on standard sheet layout
                $colNoBukti = 6;
                $colTanggal = 4;
                $colAkun = 3;
                $colNamaSupplier = 11;
                $colKodeSupplier = 12;
                $colProduk = 13;
                $colJenisProduk = 14;
                $colKodeProduk = 15;
                $colQty = 16;
                $colHarga = 17;
            }

            // Prepare cached maps to optimize DB lookups
            $supplierNameMap = [];
            foreach (Supplier::all() as $s) {
                $supplierNameMap[strtolower(trim($s->nama_supplier))] = $s->kode_supplier;
            }

            $coaList = Coa::pluck('kode_akun')->toArray();
            $coaMap = array_flip($coaList);

            $lastSupplierRec = Supplier::where('kode_supplier', 'like', 'SP%')->orderBy('kode_supplier', 'desc')->first();
            $lastKodeSupplier = $lastSupplierRec ? $lastSupplierRec->kode_supplier : 'SP0000';

            $rows = [];
            $consecutiveEmpty = 0;

            for ($r = $headerRow + 1; $r <= $highestRow; $r++) {
                $noBuktiVal = trim($sheet->getCell([$colNoBukti, $r])->getCalculatedValue() ?? '');
                if (empty($noBuktiVal) || in_array(strtolower($noBuktiVal), ['total', 'grand total', 'grandtotal', 'no bukti', 'no_bukti', 'jumlah'])) {
                    $consecutiveEmpty++;
                    if ($consecutiveEmpty >= 20) {
                        break;
                    }
                    continue;
                }
                $consecutiveEmpty = 0;

                // 1. Tanggal parsing
                $tanggalCell = $colTanggal ? $sheet->getCell([$colTanggal, $r]) : null;
                $tanggalFormatted = date('Y-m-d');
                if ($tanggalCell) {
                    if (\PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($tanggalCell)) {
                        try {
                            $tanggalFormatted = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggalCell->getValue())->format('Y-m-d');
                        } catch (\Exception $e) {}
                    } else {
                        $rawTgl = trim($tanggalCell->getCalculatedValue() ?? $tanggalCell->getValue() ?? '');
                        if (!empty($rawTgl)) {
                            if (preg_match('/^(\d{1,2})[-\/ ]([a-zA-Z]{3,})$/', $rawTgl, $m)) {
                                $day = str_pad($m[1], 2, '0', STR_PAD_LEFT);
                                $monthStr = $m[2];
                                $year = date('Y');
                                $time = strtotime("$day $monthStr $year");
                                if ($time !== false) {
                                    $tanggalFormatted = date('Y-m-d', $time);
                                }
                            } else {
                                $cleanTgl = str_replace('/', '-', $rawTgl);
                                $time = strtotime($cleanTgl);
                                if ($time !== false && $time > 0) {
                                    $tanggalFormatted = date('Y-m-d', $time);
                                }
                            }
                        }
                    }
                }

                // 2. Kode Akun (Wajib terdaftar di tabel COA)
                $kodeAkunVal = $colAkun ? trim($sheet->getCell([$colAkun, $r])->getCalculatedValue() ?? '') : '';
                if (empty($kodeAkunVal)) {
                    throw new \Exception("Gagal Import: Kolom Kode Akun kosong pada baris Excel ke-{$r} (No. Bukti: {$noBuktiVal}).");
                }
                if (!isset($coaMap[$kodeAkunVal])) {
                    throw new \Exception("Gagal Import: Kode Akun COA '{$kodeAkunVal}' pada baris ke-{$r} (No. Bukti: {$noBuktiVal}) tidak terdaftar dalam Master COA!");
                }

                // 3. Supplier handling
                $namaSupplierRaw = $colNamaSupplier ? trim($sheet->getCell([$colNamaSupplier, $r])->getCalculatedValue() ?? '') : '';
                $kodeSupplierRaw = $colKodeSupplier ? trim($sheet->getCell([$colKodeSupplier, $r])->getCalculatedValue() ?? '') : '';

                $cleanKodeSup = trim($kodeSupplierRaw);
                $isCodeSupValid = !empty($cleanKodeSup) && $cleanKodeSup !== '0' && strtolower($cleanKodeSup) !== 'null' && $cleanKodeSup !== '-';

                $cleanNamaSup = trim($namaSupplierRaw);
                $isNameSupValid = !empty($cleanNamaSup) && $cleanNamaSup !== '0' && strtolower($cleanNamaSup) !== 'null' && $cleanNamaSup !== '-';

                $finalKodeSupplier = null;

                if ($isCodeSupValid) {
                    $supExist = Supplier::where('kode_supplier', $cleanKodeSup)->first();
                    if ($supExist) {
                        $finalKodeSupplier = $supExist->kode_supplier;
                    } else {
                        $namaKey = strtolower($cleanNamaSup);
                        if ($isNameSupValid && isset($supplierNameMap[$namaKey])) {
                            $finalKodeSupplier = $supplierNameMap[$namaKey];
                        } else {
                            $supCodeToUse = strtoupper($cleanKodeSup);
                            Supplier::create([
                                'kode_supplier' => $supCodeToUse,
                                'nama_supplier' => strtoupper($isNameSupValid ? $cleanNamaSup : $cleanKodeSup)
                            ]);
                            if ($isNameSupValid) {
                                $supplierNameMap[$namaKey] = $supCodeToUse;
                            }
                            $finalKodeSupplier = $supCodeToUse;
                        }
                    }
                } elseif ($isNameSupValid) {
                    $namaKey = strtolower($cleanNamaSup);
                    if (isset($supplierNameMap[$namaKey])) {
                        $finalKodeSupplier = $supplierNameMap[$namaKey];
                    } else {
                        $newKodeSupplier = buatkode($lastKodeSupplier, 'SP', 4);
                        $lastKodeSupplier = $newKodeSupplier;

                        Supplier::create([
                            'kode_supplier' => $newKodeSupplier,
                            'nama_supplier' => mb_substr(strtoupper($cleanNamaSup), 0, 255)
                        ]);
                        $supplierNameMap[$namaKey] = $newKodeSupplier;
                        $finalKodeSupplier = $newKodeSupplier;
                    }
                }

                // 4. Deskripsi / Keterangan Biaya
                $namaProdukRaw = $colProduk ? trim($sheet->getCell([$colProduk, $r])->getCalculatedValue() ?? '') : '';
                if (empty($namaProdukRaw) && $colJenisProduk) {
                    $namaProdukRaw = trim($sheet->getCell([$colJenisProduk, $r])->getCalculatedValue() ?? '');
                }
                if (empty($namaProdukRaw) && $colNamaAkun) {
                    $namaProdukRaw = trim($sheet->getCell([$colNamaAkun, $r])->getCalculatedValue() ?? '');
                }
                if (empty($namaProdukRaw)) {
                    $namaProdukRaw = 'BIAYA OPERASIONAL';
                }

                $keteranganItem = $namaProdukRaw;

                // 5. Quantity & Price
                $qty = $colQty ? (float) toNumber(trim($sheet->getCell([$colQty, $r])->getCalculatedValue() ?? 1)) : 1;
                if ($qty <= 0) $qty = 1;

                $harga = $colHarga ? (float) toNumber(trim($sheet->getCell([$colHarga, $r])->getCalculatedValue() ?? 0)) : 0;
                $dpp = $colDpp ? (float) toNumber(trim($sheet->getCell([$colDpp, $r])->getCalculatedValue() ?? 0)) : 0;
                $totalVal = $colTotal ? (float) toNumber(trim($sheet->getCell([$colTotal, $r])->getCalculatedValue() ?? 0)) : 0;

                if ($harga <= 0) {
                    if ($dpp > 0) {
                        $harga = $dpp / $qty;
                    } elseif ($totalVal > 0) {
                        $harga = $totalVal / $qty;
                    }
                }

                $peny = $colPeny ? (float) toNumber(trim($sheet->getCell([$colPeny, $r])->getCalculatedValue() ?? 0)) : 0;

                $rows[] = [
                    'no_bukti' => $noBuktiVal,
                    'tanggal' => $tanggalFormatted,
                    'kode_supplier' => $finalKodeSupplier,
                    'kode_akun' => $kodeAkunVal,
                    'kode_barang' => null,
                    'keterangan' => $keteranganItem,
                    'qty' => $qty,
                    'harga' => $harga,
                    'penyesuaian' => $peny,
                ];
            }

            if (empty($rows)) {
                throw new \Exception("Tidak ada data baris yang valid ditemukan pada file Excel.");
            }

            // Group by no_bukti
            $grouped = [];
            foreach ($rows as $row) {
                $grouped[$row['no_bukti']][] = $row;
            }

            DB::beginTransaction();

            $insertedCount = 0;
            $userCabang = auth()->user()->kode_cabang ?? 'PST';

            foreach ($grouped as $noBukti => $items) {
                $firstItem = $items[0];

                // Check or Create Biaya Header
                $biaya = Biaya::where('no_bukti', $noBukti)->first();
                if (!$biaya) {
                    $biaya = Biaya::create([
                        'no_bukti' => $noBukti,
                        'tanggal' => $firstItem['tanggal'],
                        'kode_supplier' => $firstItem['kode_supplier'],
                        'kode_akun' => $firstItem['kode_akun'],
                        'jenis_transaksi' => $jenis_transaksi,
                        'id_user' => auth()->user()->id ?? 1
                    ]);
                } else {
                    // Update header info if supplier is now available
                    $updateData = [];
                    if (empty($biaya->kode_supplier) && !empty($firstItem['kode_supplier'])) {
                        $updateData['kode_supplier'] = $firstItem['kode_supplier'];
                    }
                    if (!empty($updateData)) {
                        $biaya->update($updateData);
                    }
                    // Remove previous details to overwrite cleanly
                    Detailbiaya::where('no_bukti', $noBukti)->delete();
                }

                foreach ($items as $item) {
                    Detailbiaya::create([
                        'no_bukti' => $noBukti,
                        'kode_barang' => $item['kode_barang'],
                        'kode_akun' => $item['kode_akun'],
                        'keterangan' => $item['keterangan'],
                        'jumlah' => $item['qty'],
                        'harga' => $item['harga'],
                        'penyesuaian' => $item['penyesuaian'],
                        'kode_cabang' => $userCabang,
                        'kode_transaksi' => 'BYA',
                    ]);
                    $insertedCount++;
                }
            }

            DB::commit();

            return Redirect::back()->with(['success' => "$insertedCount data rincian biaya dari " . count($grouped) . " transaksi berhasil diimport."]);
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(['error' => 'Gagal melakukan import biaya: ' . $e->getMessage()]);
        }
    }

    public function importPembayaranExcel(Request $request)
    {
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

            // Find header rows
            $headerRowIndex = 1;
            for ($r = 1; $r <= min(10, $highestRow); $r++) {
                for ($c = 1; $c <= $highestColumnIndex; $c++) {
                    $val = strtolower(trim($sheet->getCell([$c, $r])->getValue() ?? ''));
                    if (in_array($val, ['no bukti', 'no_bukti', 'nomor bukti'])) {
                        $headerRowIndex = $r;
                        break 2;
                    }
                }
            }

            $colMap = [];
            $bankCols = [];
            $validBankCodes = DB::table('bank')->pluck('kode_bank')->toArray();
            $validBankCodesLower = array_map('strtolower', $validBankCodes);
            $bankCodeMap = array_combine($validBankCodesLower, $validBankCodes);

            $maxHeaderRowOffset = 1;
            for ($c = 1; $c <= $highestColumnIndex; $c++) {
                $val1 = strtolower(trim($sheet->getCell([$c, $headerRowIndex])->getValue() ?? ''));
                $val2 = strtolower(trim($sheet->getCell([$c, $headerRowIndex + 1])->getValue() ?? ''));
                $val3 = strtolower(trim($sheet->getCell([$c, $headerRowIndex + 2])->getValue() ?? ''));

                if (in_array($val1, ['no bukti', 'no_bukti', 'nomor bukti'])) $colMap['no_bukti'] = $c;
                elseif (in_array($val1, ['tgl', 'tanggal', 'tgl bayar'])) $colMap['tanggal'] = $c;

                if (isset($bankCodeMap[$val1])) {
                    $bankCols[$c] = $bankCodeMap[$val1];
                } elseif (isset($bankCodeMap[$val2])) {
                    $bankCols[$c] = $bankCodeMap[$val2];
                    $maxHeaderRowOffset = max($maxHeaderRowOffset, 2);
                } elseif (isset($bankCodeMap[$val3])) {
                    $bankCols[$c] = $bankCodeMap[$val3];
                    $maxHeaderRowOffset = max($maxHeaderRowOffset, 3);
                }
            }

            if (!isset($colMap['no_bukti'])) $colMap['no_bukti'] = 3;
            if (!isset($colMap['tanggal'])) $colMap['tanggal'] = 2;

            $dataStartRow = $headerRowIndex + $maxHeaderRowOffset;
            $checkSampleVal = trim($sheet->getCell([$colMap['no_bukti'], $dataStartRow])->getValue() ?? '');
            $checkNoCol = trim($sheet->getCell([1, $dataStartRow])->getValue() ?? '');
            if (empty($checkSampleVal) || !is_numeric($checkNoCol) || strtolower($checkSampleVal) === 'no bukti') {
                $dataStartRow++;
            }

            DB::beginTransaction();

            $insertedCount = 0;
            $bankBranches = DB::table('bank')->pluck('kode_cabang', 'kode_bank')->toArray();

            for ($row = $dataStartRow; $row <= $highestRow; $row++) {
                $noBukti = trim($sheet->getCell([$colMap['no_bukti'], $row])->getValue() ?? '');
                if (empty($noBukti) || in_array(strtolower($noBukti), ['total', 'grand total', 'grandtotal', 'no bukti', 'no_bukti'])) {
                    continue;
                }

                $tglVal = $sheet->getCell([$colMap['tanggal'], $row])->getValue();
                if (\PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($sheet->getCell([$colMap['tanggal'], $row]))) {
                    $tglFormatted = date('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($tglVal));
                } else {
                    $tglFormatted = !empty($tglVal) ? date('Y-m-d', strtotime(str_replace('/', '-', $tglVal))) : date('Y-m-d');
                }

                $biayaExists = DB::table('biaya')->where('no_bukti', $noBukti)->exists();
                if (!$biayaExists) {
                    throw new \Exception("No Bukti '$noBukti' pada baris $row tidak ditemukan di data biaya.");
                }

                foreach ($bankCols as $colIndex => $bankCode) {
                    $amountVal = $sheet->getCell([$colIndex, $row])->getValue();
                    if ($amountVal !== null && $amountVal !== '') {
                        $amountClean = str_replace('.', '', $amountVal);
                        $amountClean = str_replace(',', '.', $amountClean);
                        $amountClean = (float)$amountClean;

                        if ($amountClean > 0) {
                            $kodeCabang = $bankBranches[$bankCode] ?? 'PST';

                            DB::table('biaya_historibayar')->insert([
                                'no_bukti' => $noBukti,
                                'tanggal' => $tglFormatted,
                                'jumlah' => $amountClean,
                                'kode_bank' => $bankCode,
                                'kode_cabang' => $kodeCabang,
                                'id_user' => auth()->user()->id ?? 1,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                            $insertedCount++;
                        }
                    }
                }
            }

            DB::commit();
            return Redirect::back()->with(['success' => "$insertedCount data pembayaran biaya berhasil diimport."]);
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(['error' => 'Gagal melakukan import pembayaran biaya: ' . $e->getMessage()]);
        }
    }

    public function getSheets(Request $request)
    {
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
        abort_if(!auth()->user()->can('pembelian.create'), 403);

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            
            $tables = [
                'biaya_historibayar',
                'biaya_detail',
                'biaya',
            ];

            foreach ($tables as $table) {
                if (\Illuminate\Support\Facades\Schema::hasTable($table)) {
                    DB::table($table)->truncate();
                }
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return Redirect::route('biaya.index')->with(['success' => 'Seluruh Data Biaya Operasional Berhasil Direset.']);
        } catch (\Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return Redirect::back()->with(['error' => 'Gagal mereset data biaya: ' . $e->getMessage()]);
        }
    }
}
