<?php

namespace App\Http\Controllers;

use App\Models\ProdukHarga;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class ProdukHargaController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('produkharga.view'), 403);

        $query = ProdukHarga::query();
        $query->select('produk_harga.*', 'produk.nama_produk');
        $query->join('produk', 'produk_harga.kode_produk', '=', 'produk.kode_produk');
        $query->orderBy('produk.nama_produk', 'asc');
        
        if ($request->has('nama_produk') && !empty($request->nama_produk)) {
            $query->where('produk.nama_produk', 'like', '%' . $request->nama_produk . '%');
        }

        $produkharga = $query->paginate(15);
        $produkharga->appends($request->all());

        return view('settings.produkharga.index', compact('produkharga'));
    }

    public function create()
    {
        abort_if(!auth()->user()->can('produkharga.create'), 403);

        // Get products that don't have a price set yet
        $produk = Produk::whereNotExists(function ($query) {
            $query->select('*')
                ->from('produk_harga')
                ->whereColumn('produk_harga.kode_produk', 'produk.kode_produk');
        })
        ->orderBy('nama_produk')
        ->get();

        return view('settings.produkharga.create', compact('produk'));
    }

    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('produkharga.create'), 403);

        $request->validate([
            'kode_produk' => 'required|unique:produk_harga,kode_produk',
            'harga' => 'required'
        ]);

        try {
            ProdukHarga::create([
                'kode_produk' => $request->kode_produk,
                'harga' => toNumber($request->harga)
            ]);

            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function edit($kode_produk)
    {
        abort_if(!auth()->user()->can('produkharga.edit'), 403);

        $kode_produk = Crypt::decrypt($kode_produk);
        $produkharga = ProdukHarga::findOrFail($kode_produk);
        $produk = Produk::orderBy('nama_produk')->get();
        return view('settings.produkharga.edit', compact('produkharga', 'produk'));
    }

    public function update(Request $request, $kode_produk)
    {
        abort_if(!auth()->user()->can('produkharga.edit'), 403);

        $kode_produk = Crypt::decrypt($kode_produk);
        $request->validate([
            'harga' => 'required'
        ]);

        try {
            ProdukHarga::where('kode_produk', $kode_produk)->update([
                'harga' => toNumber($request->harga)
            ]);

            return Redirect::back()->with(messageSuccess('Data Berhasil Diupdate'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function destroy($kode_produk)
    {
        abort_if(!auth()->user()->can('produkharga.delete'), 403);

        $kode_produk = Crypt::decrypt($kode_produk);
        try {
            $produkharga = ProdukHarga::where('kode_produk', $kode_produk)->first();
            $produkharga->delete();
            return Redirect::back()->with(messageSuccess('Data Berhasil Dihapus'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError('Data Gagal Dihapus: ' . $e->getMessage()));
        }
    }

    public function getHarga($kode_produk)
    {
        $harga = ProdukHarga::where('kode_produk', $kode_produk)->first();
        return response()->json([
            'harga' => $harga ? $harga->harga : 0
        ]);
    }
}
