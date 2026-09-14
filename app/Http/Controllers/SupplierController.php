<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('supplier.view'), 403);

        $query = Supplier::query();

        if (!empty($request->nama_supplier)) {
            $query->where(function($q) use ($request) {
                $q->where('nama_supplier', 'like', '%' . $request->nama_supplier . '%')
                  ->orWhere('kode_supplier', 'like', '%' . $request->nama_supplier . '%');
            });
        }

        $supplier = $query->orderBy('kode_supplier', 'desc')->paginate(12);
        $supplier->appends(request()->all());

        return view('settings.supplier.index', compact('supplier'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!auth()->user()->can('supplier.create'), 403);

        return view('settings.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('supplier.create'), 403);

        $request->validate([
            'nama_supplier' => 'required|max:100',
            'contact_person' => 'nullable|max:100',
            'no_hp_supplier' => 'nullable|max:100',
            'alamat_supplier' => 'nullable|max:255',
            'email_supplier' => 'nullable|email|max:255',
            'no_rekening_supplier' => 'nullable|max:30',
        ]);

        try {
            $lastsupplier = Supplier::orderBy('kode_supplier', 'desc')->first();
            $last_kode_supplier = $lastsupplier != null ? $lastsupplier->kode_supplier : '';
            $kode_supplier = buatkode($last_kode_supplier, "SP", 4);

            Supplier::create([
                'kode_supplier' => $kode_supplier,
                'nama_supplier' => $request->nama_supplier,
                'contact_person' => $request->contact_person,
                'no_hp_supplier' => $request->no_hp_supplier,
                'alamat_supplier' => $request->alamat_supplier,
                'email_supplier' => $request->email_supplier,
                'no_rekening_supplier' => $request->no_rekening_supplier,
            ]);

            return Redirect::back()->with(['success' => 'Supplier Berhasil Disimpan']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($kode_supplier)
    {
        abort_if(!auth()->user()->can('supplier.edit'), 403);

        $kode_supplier = Crypt::decrypt($kode_supplier);
        $supplier = Supplier::findOrFail($kode_supplier);

        return view('settings.supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kode_supplier)
    {
        abort_if(!auth()->user()->can('supplier.edit'), 403);

        $kode_supplier = Crypt::decrypt($kode_supplier);
        $supplier = Supplier::findOrFail($kode_supplier);

        $request->validate([
            'nama_supplier' => 'required|max:100',
            'contact_person' => 'nullable|max:100',
            'no_hp_supplier' => 'nullable|max:100',
            'alamat_supplier' => 'nullable|max:255',
            'email_supplier' => 'nullable|email|max:255',
            'no_rekening_supplier' => 'nullable|max:30',
        ]);

        try {
            $supplier->update([
                'nama_supplier' => $request->nama_supplier,
                'contact_person' => $request->contact_person,
                'no_hp_supplier' => $request->no_hp_supplier,
                'alamat_supplier' => $request->alamat_supplier,
                'email_supplier' => $request->email_supplier,
                'no_rekening_supplier' => $request->no_rekening_supplier,
            ]);

            return Redirect::back()->with(['success' => 'Supplier Berhasil Diupdate']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kode_supplier)
    {
        abort_if(!auth()->user()->can('supplier.delete'), 403);

        $kode_supplier = Crypt::decrypt($kode_supplier);
        try {
            $supplier = Supplier::findOrFail($kode_supplier);
            $supplier->delete();
            return Redirect::back()->with(['success' => 'Supplier Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Import supplier from Excel file.
     */
    public function import(Request $request)
    {
        abort_if(!auth()->user()->can('supplier.create'), 403);

        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('file_excel');

        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
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

            // Find header row or identify columns
            $headerRowIndex = 1;
            $colMap = [];
            for ($r = 1; $r <= min(5, $highestRow); $r++) {
                for ($c = 1; $c <= $highestColumnIndex; $c++) {
                    $val = strtolower(trim($sheet->getCell([$c, $r])->getValue() ?? ''));
                    if (in_array($val, ['nama supplier', 'nama_supplier', 'nama', 'supplier'])) {
                        $headerRowIndex = $r;
                        $colMap['nama_supplier'] = $c;
                    } elseif (in_array($val, ['contact person', 'contact_person', 'pic', 'kontak'])) {
                        $colMap['contact_person'] = $c;
                    } elseif (in_array($val, ['no hp', 'no_hp', 'telepon', 'no_hp_supplier', 'no telepon', 'no telp', 'phone'])) {
                        $colMap['no_hp_supplier'] = $c;
                    } elseif (in_array($val, ['alamat', 'alamat supplier', 'alamat_supplier', 'address'])) {
                        $colMap['alamat_supplier'] = $c;
                    } elseif (in_array($val, ['email', 'email supplier', 'email_supplier'])) {
                        $colMap['email_supplier'] = $c;
                    } elseif (in_array($val, ['no rekening', 'no_rekening', 'rekening', 'no_rekening_supplier', 'norek'])) {
                        $colMap['no_rekening_supplier'] = $c;
                    }
                }
                if (isset($colMap['nama_supplier'])) {
                    break;
                }
            }

            // Default column if no header found
            if (!isset($colMap['nama_supplier'])) {
                $colMap['nama_supplier'] = 1;
            }

            \Illuminate\Support\Facades\DB::beginTransaction();

            $lastsupplier = Supplier::orderBy('kode_supplier', 'desc')->first();
            $last_kode_supplier = $lastsupplier != null ? $lastsupplier->kode_supplier : '';

            $insertedCount = 0;
            $startRow = isset($colMap['nama_supplier']) && $headerRowIndex > 0 ? $headerRowIndex + 1 : 1;

            for ($row = $startRow; $row <= $highestRow; $row++) {
                $nama_supplier = trim($sheet->getCell([$colMap['nama_supplier'], $row])->getValue() ?? '');

                // Skip empty or header repeated rows
                if (empty($nama_supplier) || in_array(strtolower($nama_supplier), ['nama supplier', 'nama_supplier', 'supplier', 'nama'])) {
                    continue;
                }

                $contact_person = isset($colMap['contact_person']) ? trim($sheet->getCell([$colMap['contact_person'], $row])->getValue() ?? '') : null;
                $no_hp_supplier = isset($colMap['no_hp_supplier']) ? trim($sheet->getCell([$colMap['no_hp_supplier'], $row])->getValue() ?? '') : null;
                $alamat_supplier = isset($colMap['alamat_supplier']) ? trim($sheet->getCell([$colMap['alamat_supplier'], $row])->getValue() ?? '') : null;
                $email_supplier = isset($colMap['email_supplier']) ? trim($sheet->getCell([$colMap['email_supplier'], $row])->getValue() ?? '') : null;
                $no_rekening_supplier = isset($colMap['no_rekening_supplier']) ? trim($sheet->getCell([$colMap['no_rekening_supplier'], $row])->getValue() ?? '') : null;

                $kode_supplier = buatkode($last_kode_supplier, "SP", 4);
                $last_kode_supplier = $kode_supplier;

                Supplier::create([
                    'kode_supplier' => $kode_supplier,
                    'nama_supplier' => $nama_supplier,
                    'contact_person' => $contact_person,
                    'no_hp_supplier' => $no_hp_supplier,
                    'alamat_supplier' => $alamat_supplier,
                    'email_supplier' => $email_supplier,
                    'no_rekening_supplier' => $no_rekening_supplier,
                ]);

                $insertedCount++;
            }

            \Illuminate\Support\Facades\DB::commit();

            return Redirect::back()->with(['success' => "$insertedCount Supplier berhasil diimport."]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return Redirect::back()->with(['error' => 'Gagal mengimport supplier: ' . $e->getMessage()]);
        }
    }
}
