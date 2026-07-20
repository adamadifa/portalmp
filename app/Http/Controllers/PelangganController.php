<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('pelanggan.view'), 403);

        $query = Pelanggan::with('cabang');

        if (!empty($request->nama_pelanggan)) {
            $query->where(function($q) use ($request) {
                $q->where('nama_pelanggan', 'like', '%' . $request->nama_pelanggan . '%')
                  ->orWhere('kode_pelanggan', 'like', '%' . $request->nama_pelanggan . '%');
            });
        }

        if (!empty($request->kode_cabang)) {
            $query->where('kode_cabang', $request->kode_cabang);
        }

        $pelanggan = $query->orderBy('kode_pelanggan')->paginate(12);
        $pelanggan->appends(request()->all());

        $cabang = Cabang::orderBy('nama_cabang')->get();

        return view('settings.pelanggan.index', compact('pelanggan', 'cabang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!auth()->user()->can('pelanggan.create'), 403);

        $cabang = Cabang::orderBy('nama_cabang')->get();
        return view('settings.pelanggan.create', compact('cabang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('pelanggan.create'), 403);

        $request->validate([
            'kode_pelanggan' => 'required|max:13|unique:pelanggan,kode_pelanggan',
            'tanggal_register' => 'required|date',
            'nama_pelanggan' => 'required|max:100',
            'no_hp_pelanggan' => 'required|max:255',
            'alamat_pelanggan' => 'required|max:255',
            'alamat_toko' => 'required|max:255',
            'kode_cabang' => 'required',
            'status_aktif_pelanggan' => 'required|max:1',
            'limit_pelanggan' => 'nullable|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        try {
            $foto = null;
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/pelanggan', $filename);
                $foto = $filename;
            }

            Pelanggan::create([
                'kode_pelanggan' => strtoupper($request->kode_pelanggan),
                'tanggal_register' => $request->tanggal_register,
                'nik' => $request->nik,
                'no_kk' => $request->no_kk,
                'nama_pelanggan' => $request->nama_pelanggan,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat_pelanggan' => $request->alamat_pelanggan,
                'alamat_toko' => $request->alamat_toko,
                'no_hp_pelanggan' => $request->no_hp_pelanggan,
                'hari' => $request->hari,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status_lokasi' => $request->status_lokasi,
                'ljt' => $request->ljt,
                'foto' => $foto,
                'limit_pelanggan' => $request->limit_pelanggan ?? 50000000,
                'status_aktif_pelanggan' => $request->status_aktif_pelanggan,
                'kode_cabang' => $request->kode_cabang,
                'kode_cabang_pkp' => $request->kode_cabang
            ]);

            return Redirect::back()->with(['success' => 'Pelanggan Berhasil Disimpan']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($kode_pelanggan)
    {
        abort_if(!auth()->user()->can('pelanggan.edit'), 403);

        $kode_pelanggan = Crypt::decrypt($kode_pelanggan);
        $pelanggan = Pelanggan::findOrFail($kode_pelanggan);
        $cabang = Cabang::orderBy('nama_cabang')->get();

        return view('settings.pelanggan.edit', compact('pelanggan', 'cabang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kode_pelanggan)
    {
        abort_if(!auth()->user()->can('pelanggan.edit'), 403);

        $kode_pelanggan = Crypt::decrypt($kode_pelanggan);
        $pelanggan = Pelanggan::findOrFail($kode_pelanggan);

        $request->validate([
            'nama_pelanggan' => 'required|max:100',
            'no_hp_pelanggan' => 'required|max:255',
            'alamat_pelanggan' => 'required|max:255',
            'alamat_toko' => 'required|max:255',
            'kode_cabang' => 'required',
            'status_aktif_pelanggan' => 'required|max:1',
            'limit_pelanggan' => 'nullable|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        try {
            $foto = $pelanggan->foto;
            if ($request->hasFile('foto')) {
                if ($pelanggan->foto && Storage::exists('public/pelanggan/' . $pelanggan->foto)) {
                    Storage::delete('public/pelanggan/' . $pelanggan->foto);
                }
                $file = $request->file('foto');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/pelanggan', $filename);
                $foto = $filename;
            }

            $pelanggan->update([
                'nama_pelanggan' => $request->nama_pelanggan,
                'nik' => $request->nik,
                'no_kk' => $request->no_kk,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat_pelanggan' => $request->alamat_pelanggan,
                'alamat_toko' => $request->alamat_toko,
                'no_hp_pelanggan' => $request->no_hp_pelanggan,
                'hari' => $request->hari,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status_lokasi' => $request->status_lokasi,
                'ljt' => $request->ljt,
                'foto' => $foto,
                'limit_pelanggan' => $request->limit_pelanggan ?? 50000000,
                'status_aktif_pelanggan' => $request->status_aktif_pelanggan,
                'kode_cabang' => $request->kode_cabang,
                'kode_cabang_pkp' => $request->kode_cabang
            ]);

            return Redirect::back()->with(['success' => 'Pelanggan Berhasil Diupdate']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kode_pelanggan)
    {
        abort_if(!auth()->user()->can('pelanggan.delete'), 403);

        $kode_pelanggan = Crypt::decrypt($kode_pelanggan);
        try {
            $pelanggan = Pelanggan::findOrFail($kode_pelanggan);
            if ($pelanggan->foto && Storage::exists('public/pelanggan/' . $pelanggan->foto)) {
                Storage::delete('public/pelanggan/' . $pelanggan->foto);
            }
            $pelanggan->delete();
            return Redirect::back()->with(['success' => 'Pelanggan Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }
}
