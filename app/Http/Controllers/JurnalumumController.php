<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\Jurnalumum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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

    /**
     * Download Excel template for Jurnal Umum import.
     */
    public function downloadTemplate()
    {
        abort_if(!auth()->user()->can('jurnalumum.create'), 403);

        $spreadsheet = new Spreadsheet();

        // ── Sheet 1: Template Jurnal Umum ──────────────────────────
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Jurnal Umum');

        $headers = [
            'A1' => 'Tanggal',
            'B1' => 'No Bukti',
            'C1' => 'Kode Akun',
            'D1' => 'Nama Akun',
            'E1' => 'Keterangan',
            'F1' => 'Debet',
            'G1' => 'Kredit',
            'H1' => 'Departemen',
        ];

        foreach ($headers as $cell => $val) {
            $sheet->setCellValue($cell, $val);
        }

        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 10,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '294C9A'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '1E3A70'],
                ],
            ],
        ];
        $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(28);

        // Sample rows showing balanced debit and credit entries
        $sampleData = [
            [
                '2026-01-31',
                'MEMO-01',
                '5-12101',
                'P/L Persediaan Awal Bahan Baku',
                'Penyesuaian Persediaan Awal Bahan Baku Januari 2026',
                50000000,
                0,
                'AKT',
            ],
            [
                '2026-01-31',
                'MEMO-01',
                '1-11302',
                'Persediaan Bahan Baku',
                'Penyesuaian Persediaan Awal Bahan Baku Januari 2026',
                0,
                50000000,
                'AKT',
            ],
            [
                '2026-01-31',
                'MEMO-02',
                '1-11302',
                'Persediaan Bahan Baku',
                'Penyesuaian Persediaan Akhir Bahan Baku Januari 2026',
                45000000,
                0,
                'AKT',
            ],
            [
                '2026-01-31',
                'MEMO-02',
                '5-13101',
                'P/L Persediaan Akhir Bahan Baku',
                'Penyesuaian Persediaan Akhir Bahan Baku Januari 2026',
                0,
                45000000,
                'AKT',
            ],
        ];

        $rowNum = 2;
        foreach ($sampleData as $row) {
            $sheet->setCellValueExplicit('A' . $rowNum, $row[0], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('B' . $rowNum, $row[1], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('C' . $rowNum, $row[2], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $rowNum, $row[3]);
            $sheet->setCellValue('E' . $rowNum, $row[4]);
            $sheet->setCellValue('F' . $rowNum, $row[5]);
            $sheet->setCellValue('G' . $rowNum, $row[6]);
            $sheet->setCellValue('H' . $rowNum, $row[7]);

            $sheet->getStyle('F' . $rowNum . ':G' . $rowNum)->getNumberFormat()->setFormatCode('#,##0');
            $rowNum++;
        }

        $dataBorderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'E5E7EB'],
                ],
            ],
        ];
        $sheet->getStyle('A2:H' . ($rowNum - 1))->applyFromArray($dataBorderStyle);

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // ── Sheet 2: Daftar Akun (COA) ──────────────────────────────
        $coaSheet = $spreadsheet->createSheet();
        $coaSheet->setTitle('Daftar Akun COA');

        $coaHeaders = ['A1' => 'Kode Akun', 'B1' => 'Nama Akun', 'C1' => 'Level'];
        foreach ($coaHeaders as $cell => $val) {
            $coaSheet->setCellValue($cell, $val);
        }

        $coaHeaderStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 10],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E3A70']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ];
        $coaSheet->getStyle('A1:C1')->applyFromArray($coaHeaderStyle);
        $coaSheet->getRowDimension(1)->setRowHeight(24);

        $coaList = Coa::orderBy('kode_akun')->get();
        $coaRow = 2;
        foreach ($coaList as $c) {
            $coaSheet->setCellValueExplicit('A' . $coaRow, $c->kode_akun, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $coaSheet->setCellValue('B' . $coaRow, $c->nama_akun);
            $coaSheet->setCellValue('C' . $coaRow, $c->level ?? '-');
            $coaRow++;
        }

        foreach (['A', 'B', 'C'] as $col) {
            $coaSheet->getColumnDimension($col)->setAutoSize(true);
        }

        $spreadsheet->setActiveSheetIndex(0);

        $filename = 'Template_Import_Jurnal_Umum.xlsx';
        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    /**
     * Import Jurnal Umum data from Excel file.
     */
    public function import(Request $request)
    {
        abort_if(!auth()->user()->can('jurnalumum.create'), 403);

        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        $file = $request->file('file_excel');
        $validasiBalance = $request->boolean('validasi_balance', true);

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

            $headerRow = 1;
            $colTanggal = null;
            $colNoBukti = null;
            $colAkun = null;
            $colNamaAkun = null;
            $colKeterangan = null;
            $colDebet = null;
            $colKredit = null;
            $colPosisi = null;
            $colJumlah = null;
            $colDept = null;

            for ($r = 1; $r <= min(10, $highestRow); $r++) {
                $foundAny = false;
                for ($col = 1; $col <= $highestColumnIndex; $col++) {
                    $rawVal = $sheet->getCell([$col, $r])->getValue();
                    if ($rawVal !== null) {
                        $cv = $sanitize($rawVal);
                        if (str_contains($cv, 'tanggal') || str_contains($cv, 'tgl') || $cv === 'date') {
                            $colTanggal = $col;
                            $foundAny = true;
                        } elseif (str_contains($cv, 'nobukti') || str_contains($cv, 'nomorbukti') || $cv === 'bukti' || $cv === 'ref') {
                            $colNoBukti = $col;
                            $foundAny = true;
                        } elseif (str_contains($cv, 'kodeakun') || str_contains($cv, 'noakun') || $cv === 'coa' || $cv === 'akun' || str_contains($cv, 'account')) {
                            $colAkun = $col;
                            $foundAny = true;
                        } elseif (str_contains($cv, 'namaakun')) {
                            $colNamaAkun = $col;
                            $foundAny = true;
                        } elseif (str_contains($cv, 'keterangan') || str_contains($cv, 'deskripsi') || str_contains($cv, 'uraian') || $cv === 'ket') {
                            $colKeterangan = $col;
                            $foundAny = true;
                        } elseif (str_contains($cv, 'debet') || str_contains($cv, 'debit')) {
                            $colDebet = $col;
                            $foundAny = true;
                        } elseif (str_contains($cv, 'kredit') || str_contains($cv, 'credit')) {
                            $colKredit = $col;
                            $foundAny = true;
                        } elseif (str_contains($cv, 'posisi') || str_contains($cv, 'debetkredit') || $cv === 'dk') {
                            $colPosisi = $col;
                            $foundAny = true;
                        } elseif (str_contains($cv, 'jumlah') || str_contains($cv, 'nominal') || str_contains($cv, 'amount') || $cv === 'total') {
                            $colJumlah = $col;
                            $foundAny = true;
                        } elseif (str_contains($cv, 'dept') || str_contains($cv, 'departemen')) {
                            $colDept = $col;
                            $foundAny = true;
                        }
                    }
                }
                if ($foundAny && ($colAkun || $colTanggal || $colDebet)) {
                    $headerRow = $r;
                    break;
                }
            }

            // Fallback default column layout if no header found
            if (!$colAkun) {
                $colTanggal = 1;
                $colNoBukti = 2;
                $colAkun = 3;
                $colNamaAkun = 4;
                $colKeterangan = 5;
                $colDebet = 6;
                $colKredit = 7;
                $colDept = 8;
            }

            // Pre-load all COAs for validation
            $coaMap = Coa::pluck('nama_akun', 'kode_akun')->toArray();

            $rowsToInsert = [];
            $totalDebet = 0.0;
            $totalKredit = 0.0;
            $consecutiveEmpty = 0;

            for ($r = $headerRow + 1; $r <= $highestRow; $r++) {
                // Check if row is empty
                $isEmptyRow = true;
                for ($checkCol = 1; $checkCol <= min(8, $highestColumnIndex); $checkCol++) {
                    $valCheck = trim((string)($sheet->getCell([$checkCol, $r])->getCalculatedValue() ?? ''));
                    if ($valCheck !== '') {
                        $isEmptyRow = false;
                        break;
                    }
                }

                if ($isEmptyRow) {
                    $consecutiveEmpty++;
                    if ($consecutiveEmpty >= 20) {
                        break;
                    }
                    continue;
                }
                $consecutiveEmpty = 0;

                // 1. Kode Akun
                $rawKodeAkun = $colAkun ? trim((string)($sheet->getCell([$colAkun, $r])->getCalculatedValue() ?? '')) : '';
                if (empty($rawKodeAkun)) {
                    continue; // Skip row without account code
                }

                if (in_array(strtolower($rawKodeAkun), ['total', 'grand total', 'grandtotal', 'subtotal', 'kode akun'])) {
                    continue; // Skip summary / repeated header
                }

                if (!isset($coaMap[$rawKodeAkun])) {
                    return Redirect::back()->with(messageError("Baris {$r}: Kode Akun '{$rawKodeAkun}' tidak ditemukan dalam Chart of Accounts (COA)."));
                }

                // 2. Tanggal
                $tanggalCell = $colTanggal ? $sheet->getCell([$colTanggal, $r]) : null;
                $tanggalFormatted = null;

                if ($tanggalCell) {
                    if (ExcelDate::isDateTime($tanggalCell)) {
                        try {
                            $tanggalFormatted = ExcelDate::excelToDateTimeObject($tanggalCell->getValue())->format('Y-m-d');
                        } catch (\Exception $e) {}
                    } else {
                        $rawTgl = trim((string)($tanggalCell->getCalculatedValue() ?? $tanggalCell->getValue() ?? ''));
                        if (is_numeric($rawTgl) && $rawTgl > 25569) {
                            try {
                                $tanggalFormatted = ExcelDate::excelToDateTimeObject($rawTgl)->format('Y-m-d');
                            } catch (\Exception $e) {}
                        } elseif (!empty($rawTgl)) {
                            $cleanTgl = str_replace('/', '-', $rawTgl);
                            $time = strtotime($cleanTgl);
                            if ($time !== false && $time > 0) {
                                $tanggalFormatted = date('Y-m-d', $time);
                            }
                        }
                    }
                }

                if (!$tanggalFormatted) {
                    return Redirect::back()->with(messageError("Baris {$r}: Format tanggal tidak valid. Gunakan format YYYY-MM-DD."));
                }

                // Check tutup laporan
                $cektutuplaporan = cektutupLaporan($tanggalFormatted, "jurnalumum");
                if ($cektutuplaporan > 0) {
                    return Redirect::back()->with(messageError("Baris {$r}: Periode laporan untuk tanggal {$tanggalFormatted} sudah ditutup."));
                }

                // 3. No Bukti
                $noBukti = $colNoBukti ? trim((string)($sheet->getCell([$colNoBukti, $r])->getCalculatedValue() ?? '')) : null;
                if ($noBukti === '') $noBukti = null;

                // 4. Keterangan
                $keterangan = $colKeterangan ? trim((string)($sheet->getCell([$colKeterangan, $r])->getCalculatedValue() ?? '')) : '';
                if (empty($keterangan)) {
                    $keterangan = 'Import Jurnal Umum ' . ($noBukti ? "- {$noBukti}" : '');
                }

                // 5. Dept
                $kodeDept = $colDept ? trim((string)($sheet->getCell([$colDept, $r])->getCalculatedValue() ?? '')) : '';
                if (empty($kodeDept)) {
                    $kodeDept = 'AKT';
                }

                // Helper to clean numeric input
                $parseAmount = function ($val) {
                    if (is_numeric($val)) return (float)$val;
                    $clean = preg_replace('/[^0-9.,-]/', '', (string)$val);
                    if (empty($clean)) return 0.0;
                    if (strpos($clean, ',') !== false && strpos($clean, '.') !== false) {
                        $clean = str_replace('.', '', $clean);
                        $clean = str_replace(',', '.', $clean);
                    } elseif (strpos($clean, ',') !== false) {
                        $clean = str_replace(',', '.', $clean);
                    }
                    return (float)$clean;
                };

                // 6. Debet & Kredit / Posisi & Jumlah
                $debetVal = $colDebet ? $parseAmount($sheet->getCell([$colDebet, $r])->getCalculatedValue()) : 0.0;
                $kreditVal = $colKredit ? $parseAmount($sheet->getCell([$colKredit, $r])->getCalculatedValue()) : 0.0;

                if ($colDebet || $colKredit) {
                    if ($debetVal > 0 && $kreditVal == 0) {
                        $posisi = 'D';
                        $jumlah = $debetVal;
                        $totalDebet += $jumlah;
                    } elseif ($kreditVal > 0 && $debetVal == 0) {
                        $posisi = 'K';
                        $jumlah = $kreditVal;
                        $totalKredit += $jumlah;
                    } elseif ($debetVal > 0 && $kreditVal > 0) {
                        return Redirect::back()->with(messageError("Baris {$r}: Baris tidak boleh mengisi Debet dan Kredit sekaligus."));
                    } else {
                        continue; // Skip 0 value row
                    }
                } else {
                    $posisi = $colPosisi ? strtoupper(trim((string)$sheet->getCell([$colPosisi, $r])->getCalculatedValue())) : 'D';
                    $posisi = ($posisi === 'K' || $posisi === 'KREDIT') ? 'K' : 'D';
                    $jumlah = $colJumlah ? $parseAmount($sheet->getCell([$colJumlah, $r])->getCalculatedValue()) : 0.0;
                    if ($jumlah <= 0) {
                        continue;
                    }
                    if ($posisi === 'D') {
                        $totalDebet += $jumlah;
                    } else {
                        $totalKredit += $jumlah;
                    }
                }

                $rowsToInsert[] = [
                    'tanggal' => $tanggalFormatted,
                    'no_bukti' => $noBukti,
                    'kode_akun' => $rawKodeAkun,
                    'keterangan' => $keterangan,
                    'debet_kredit' => $posisi,
                    'jumlah' => $jumlah,
                    'kode_dept' => $kodeDept,
                    'id_user' => auth()->user()->id,
                ];
            }

            if (empty($rowsToInsert)) {
                return Redirect::back()->with(messageError("Tidak ada data jurnal umum yang valid untuk diimport."));
            }

            // Validasi Keseimbangan
            if ($validasiBalance) {
                if (abs($totalDebet - $totalKredit) > 0.01) {
                    $selisih = abs($totalDebet - $totalKredit);
                    $msg = "Import dibatalkan: Total Debet (Rp " . number_format($totalDebet, 0, ',', '.') . ") tidak seimbang dengan Total Kredit (Rp " . number_format($totalKredit, 0, ',', '.') . "). Selisih: Rp " . number_format($selisih, 0, ',', '.') . ". Pastikan seluruh transaksi jurnal umum seimbang (balance).";
                    return Redirect::back()->with(messageError($msg));
                }
            }

            // Begin DB Transaction
            DB::beginTransaction();

            $lastKodeJuByPrefix = [];
            $insertedCount = 0;

            foreach ($rowsToInsert as $item) {
                $prefix = 'JL' . date('ym', strtotime($item['tanggal']));

                if (!isset($lastKodeJuByPrefix[$prefix])) {
                    $lastRecord = Jurnalumum::select('kode_ju')
                        ->whereRaw('LEFT(kode_ju, 6) = ?', [$prefix])
                        ->orderBy('kode_ju', 'desc')
                        ->first();
                    $lastKodeJuByPrefix[$prefix] = $lastRecord ? $lastRecord->kode_ju : '';
                }

                $kode_ju = buatkode($lastKodeJuByPrefix[$prefix], $prefix, 3);
                $lastKodeJuByPrefix[$prefix] = $kode_ju;

                Jurnalumum::create([
                    'kode_ju' => $kode_ju,
                    'no_bukti' => $item['no_bukti'],
                    'tanggal' => $item['tanggal'],
                    'kode_akun' => $item['kode_akun'],
                    'keterangan' => $item['keterangan'],
                    'debet_kredit' => $item['debet_kredit'],
                    'kode_dept' => $item['kode_dept'],
                    'jumlah' => $item['jumlah'],
                    'id_user' => $item['id_user'],
                ]);

                $insertedCount++;
            }

            DB::commit();

            $infoBalance = "Total: Rp " . number_format($totalDebet, 0, ',', '.');
            return Redirect::back()->with(messageSuccess("{$insertedCount} baris data jurnal umum berhasil diimport ({$infoBalance})."));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(messageError("Gagal mengimport jurnal umum: " . $e->getMessage()));
        }
    }
}
