<?php

namespace App\Http\Controllers;

use App\Models\Barangproduksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class BarangproduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('barangproduksi.view'), 403);

        $query = Barangproduksi::query();
        if (!empty($request->nama_barang)) {
            $query->where('nama_barang', 'like', '%' . $request->nama_barang . '%')
                  ->orWhere('kode_barang_produksi', 'like', '%' . $request->nama_barang . '%');
        }
        $query->orderBy('kode_barang_produksi');
        $barangproduksi = $query->paginate(12);
        $barangproduksi->appends(request()->all());

        $asal_barang_produksi = config('produksi.asal_barang_produksi');
        $kategori_barang_produksi = config('produksi.kategori_barang_produksi');

        return view('settings.barangproduksi.index', compact(
            'barangproduksi',
            'asal_barang_produksi',
            'kategori_barang_produksi',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!auth()->user()->can('barangproduksi.create'), 403);

        $lastbarang = Barangproduksi::orderBy('kode_barang_produksi', 'desc')->first();
        $last_kode_barang = $lastbarang ? $lastbarang->kode_barang_produksi : '';
        $kode_barang_produksi = buatkode($last_kode_barang, "BP-", 3);
        $list_kategori_barang_produksi = config('produksi.list_kategori_barang_produksi');
        $asal_barang_produksi = config('produksi.asal_barang_produksi');

        return view('settings.barangproduksi.create', compact('list_kategori_barang_produksi', 'kode_barang_produksi', 'asal_barang_produksi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('barangproduksi.create'), 403);

        $request->validate([
            'kode_barang_produksi' => 'required|max:6|unique:produksi_barang,kode_barang_produksi',
            'nama_barang' => 'required|max:255',
            'satuan' => 'required|max:10',
            'kode_asal_barang' => 'required|max:2',
            'kode_kategori' => 'required|max:3',
            'status_aktif_barang' => 'required|max:1'
        ]);

        try {
            Barangproduksi::create([
                'kode_barang_produksi' => textUpperCase($request->kode_barang_produksi),
                'nama_barang' => textUpperCase($request->nama_barang),
                'satuan' => textUpperCase($request->satuan),
                'kode_asal_barang' => $request->kode_asal_barang,
                'kode_kategori' => $request->kode_kategori,
                'status_aktif_barang' => $request->status_aktif_barang
            ]);

            return Redirect::back()->with(['success' => 'Barang Produksi Berhasil Disimpan']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($kode_barang_produksi)
    {
        abort_if(!auth()->user()->can('barangproduksi.edit'), 403);

        $kode_barang_produksi = Crypt::decrypt($kode_barang_produksi);
        $barangproduksi = Barangproduksi::findOrFail($kode_barang_produksi);
        $list_kategori_barang_produksi = config('produksi.list_kategori_barang_produksi');
        $asal_barang_produksi = config('produksi.asal_barang_produksi');

        return view('settings.barangproduksi.edit', compact('barangproduksi', 'list_kategori_barang_produksi', 'asal_barang_produksi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kode_barang_produksi)
    {
        abort_if(!auth()->user()->can('barangproduksi.edit'), 403);

        $kode_barang_produksi = Crypt::decrypt($kode_barang_produksi);
        $barang = Barangproduksi::findOrFail($kode_barang_produksi);

        $request->validate([
            'nama_barang' => 'required|max:255',
            'satuan' => 'required|max:10',
            'kode_asal_barang' => 'required|max:2',
            'kode_kategori' => 'required|max:3',
            'status_aktif_barang' => 'required|max:1'
        ]);

        try {
            $barang->update([
                'nama_barang' => textUpperCase($request->nama_barang),
                'satuan' => textUpperCase($request->satuan),
                'kode_asal_barang' => $request->kode_asal_barang,
                'kode_kategori' => $request->kode_kategori,
                'status_aktif_barang' => $request->status_aktif_barang
            ]);

            return Redirect::back()->with(['success' => 'Barang Produksi Berhasil Diupdate']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kode_barang_produksi)
    {
        abort_if(!auth()->user()->can('barangproduksi.delete'), 403);

        $kode_barang_produksi = Crypt::decrypt($kode_barang_produksi);
        try {
            $barang = Barangproduksi::findOrFail($kode_barang_produksi);
            $barang->delete();
            return Redirect::back()->with(['success' => 'Barang Produksi Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }
}
