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
}
