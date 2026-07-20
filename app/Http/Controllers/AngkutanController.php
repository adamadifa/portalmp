<?php

namespace App\Http\Controllers;

use App\Models\Angkutan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class AngkutanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('angkutan.view'), 403);

        $query = Angkutan::query();

        if (!empty($request->nama_angkutan)) {
            $query->where(function($q) use ($request) {
                $q->where('nama_angkutan', 'like', '%' . $request->nama_angkutan . '%')
                  ->orWhere('kode_angkutan', 'like', '%' . $request->nama_angkutan . '%');
            });
        }

        $angkutan = $query->orderBy('kode_angkutan', 'desc')->paginate(12);
        $angkutan->appends(request()->all());

        return view('settings.angkutan.index', compact('angkutan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!auth()->user()->can('angkutan.create'), 403);

        return view('settings.angkutan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('angkutan.create'), 403);

        $request->validate([
            'nama_angkutan' => 'required|max:50',
            'keterangan' => 'nullable|max:30',
        ]);

        try {
            $lastangkutan = Angkutan::orderBy('kode_angkutan', 'desc')->first();
            $lastkode_angkutan = $lastangkutan != null ? $lastangkutan->kode_angkutan : '';
            $kode_angkutan = buatkode($lastkode_angkutan, "A", 3);

            Angkutan::create([
                'kode_angkutan' => $kode_angkutan,
                'nama_angkutan' => textUpperCase($request->nama_angkutan),
                'keterangan' => $request->keterangan,
            ]);

            return Redirect::back()->with(['success' => 'Angkutan Berhasil Disimpan']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($kode_angkutan)
    {
        abort_if(!auth()->user()->can('angkutan.edit'), 403);

        $kode_angkutan = Crypt::decrypt($kode_angkutan);
        $angkutan = Angkutan::findOrFail($kode_angkutan);

        return view('settings.angkutan.edit', compact('angkutan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kode_angkutan)
    {
        abort_if(!auth()->user()->can('angkutan.edit'), 403);

        $kode_angkutan = Crypt::decrypt($kode_angkutan);
        $angkutan = Angkutan::findOrFail($kode_angkutan);

        $request->validate([
            'nama_angkutan' => 'required|max:50',
            'keterangan' => 'nullable|max:30',
        ]);

        try {
            $angkutan->update([
                'nama_angkutan' => textUpperCase($request->nama_angkutan),
                'keterangan' => $request->keterangan,
            ]);

            return Redirect::back()->with(['success' => 'Angkutan/Carriage Berhasil Diupdate']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kode_angkutan)
    {
        abort_if(!auth()->user()->can('angkutan.delete'), 403);

        $kode_angkutan = Crypt::decrypt($kode_angkutan);
        try {
            $angkutan = Angkutan::findOrFail($kode_angkutan);
            $angkutan->delete();
            return Redirect::back()->with(['success' => 'Angkutan Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }
}
