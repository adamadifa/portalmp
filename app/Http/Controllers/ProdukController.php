<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\ProdukKategori;
use App\Models\ProdukJenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('produk.view'), 403);

        $query = Produk::with(['kategori', 'jenis']);

        if (!empty($request->nama_produk)) {
            $query->where(function($q) use ($request) {
                $q->where('nama_produk', 'like', '%' . $request->nama_produk . '%')
                  ->orWhere('kode_produk', 'like', '%' . $request->nama_produk . '%');
            });
        }

        if (!empty($request->kode_kategori_produk)) {
            $query->where('kode_kategori_produk', $request->kode_kategori_produk);
        }

        if (!empty($request->kode_jenis_produk)) {
            $query->where('kode_jenis_produk', $request->kode_jenis_produk);
        }

        $produk = $query->orderBy('kode_produk')->paginate(10);
        $produk->appends(request()->all());

        $kategori = ProdukKategori::orderBy('nama_kategori_produk')->get();
        $jenis = ProdukJenis::orderBy('nama_jenis_produk')->get();

        return view('settings.produk.index', compact('produk', 'kategori', 'jenis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!auth()->user()->can('produk.create'), 403);

        $kategori = ProdukKategori::orderBy('nama_kategori_produk')->get();
        $jenis = ProdukJenis::orderBy('nama_jenis_produk')->get();
        return view('settings.produk.create', compact('kategori', 'jenis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('produk.create'), 403);

        $request->validate([
            'kode_produk' => 'required|max:6|unique:produk,kode_produk',
            'nama_produk' => 'required|max:30',
            'satuan' => 'required|max:4',
            'isi_pcs_dus' => 'required|numeric',
            'isi_pack_dus' => 'required|numeric',
            'isi_pcs_pack' => 'required|numeric',
            'kode_kategori_produk' => 'required',
            'kode_jenis_produk' => 'required',
            'status_aktif_produk' => 'required|max:1',
            'urutan' => 'nullable|numeric'
        ]);

        try {
            Produk::create([
                'kode_produk' => strtoupper($request->kode_produk),
                'nama_produk' => $request->nama_produk,
                'satuan' => $request->satuan,
                'isi_pcs_dus' => $request->isi_pcs_dus,
                'isi_pack_dus' => $request->isi_pack_dus,
                'isi_pcs_pack' => $request->isi_pcs_pack,
                'kode_kategori_produk' => $request->kode_kategori_produk,
                'kode_jenis_produk' => $request->kode_jenis_produk,
                'status_aktif_produk' => $request->status_aktif_produk,
                'urutan' => $request->urutan
            ]);

            return Redirect::back()->with(['success' => 'Produk Berhasil Disimpan']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($kode_produk)
    {
        abort_if(!auth()->user()->can('produk.edit'), 403);

        $kode_produk = Crypt::decrypt($kode_produk);
        $produk = Produk::findOrFail($kode_produk);
        $kategori = ProdukKategori::orderBy('nama_kategori_produk')->get();
        $jenis = ProdukJenis::orderBy('nama_jenis_produk')->get();

        return view('settings.produk.edit', compact('produk', 'kategori', 'jenis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kode_produk)
    {
        abort_if(!auth()->user()->can('produk.edit'), 403);

        $kode_produk = Crypt::decrypt($kode_produk);
        $produk = Produk::findOrFail($kode_produk);

        $request->validate([
            'nama_produk' => 'required|max:30',
            'satuan' => 'required|max:4',
            'isi_pcs_dus' => 'required|numeric',
            'isi_pack_dus' => 'required|numeric',
            'isi_pcs_pack' => 'required|numeric',
            'kode_kategori_produk' => 'required',
            'kode_jenis_produk' => 'required',
            'status_aktif_produk' => 'required|max:1',
            'urutan' => 'nullable|numeric'
        ]);

        try {
            $produk->update([
                'nama_produk' => $request->nama_produk,
                'satuan' => $request->satuan,
                'isi_pcs_dus' => $request->isi_pcs_dus,
                'isi_pack_dus' => $request->isi_pack_dus,
                'isi_pcs_pack' => $request->isi_pcs_pack,
                'kode_kategori_produk' => $request->kode_kategori_produk,
                'kode_jenis_produk' => $request->kode_jenis_produk,
                'status_aktif_produk' => $request->status_aktif_produk,
                'urutan' => $request->urutan
            ]);

            return Redirect::back()->with(['success' => 'Produk Berhasil Diupdate']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kode_produk)
    {
        abort_if(!auth()->user()->can('produk.delete'), 403);

        $kode_produk = Crypt::decrypt($kode_produk);
        try {
            Produk::where('kode_produk', $kode_produk)->delete();
            return Redirect::back()->with(['success' => 'Produk Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }
}
