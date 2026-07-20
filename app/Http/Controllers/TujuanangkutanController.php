<?php

namespace App\Http\Controllers;

use App\Models\Tujuanangkutan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class TujuanangkutanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('tujuanangkutan.view'), 403);

        $query = Tujuanangkutan::query();
        $query->orderBy('kode_tujuan');
        if (!empty($request->tujuan_search)) {
            $query->where('tujuan', 'like', '%' . $request->tujuan_search . '%')
                  ->orWhere('kode_tujuan', 'like', '%' . $request->tujuan_search . '%');
        }
        $query->where('status', 1);
        $tujuanangkutan = $query->paginate(12);
        $tujuanangkutan->appends(request()->all());

        return view('settings.tujuanangkutan.index', compact('tujuanangkutan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!auth()->user()->can('tujuanangkutan.create'), 403);

        return view('settings.tujuanangkutan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('tujuanangkutan.create'), 403);

        $request->validate([
            'kode_tujuan' => 'required|max:3|unique:angkutan_tujuan,kode_tujuan',
            'tujuan' => 'required|max:30',
            'tarif' => 'required'
        ]);

        try {
            Tujuanangkutan::create([
                'kode_tujuan' => textUpperCase($request->kode_tujuan),
                'tujuan' => textUpperCase($request->tujuan),
                'tarif' => toNumber($request->tarif)
            ]);

            return Redirect::back()->with(['success' => 'Tujuan Angkutan Berhasil Disimpan']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($kode_tujuan)
    {
        abort_if(!auth()->user()->can('tujuanangkutan.edit'), 403);

        $kode_tujuan = Crypt::decrypt($kode_tujuan);
        $tujuanangkutan = Tujuanangkutan::findOrFail($kode_tujuan);

        return view('settings.tujuanangkutan.edit', compact('tujuanangkutan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kode_tujuan)
    {
        abort_if(!auth()->user()->can('tujuanangkutan.edit'), 403);

        $kode_tujuan = Crypt::decrypt($kode_tujuan);
        $tujuan = Tujuanangkutan::findOrFail($kode_tujuan);

        $request->validate([
            'tujuan' => 'required|max:30',
            'tarif' => 'required'
        ]);

        try {
            $tujuan->update([
                'tujuan' => textUpperCase($request->tujuan),
                'tarif' => toNumber($request->tarif)
            ]);

            return Redirect::back()->with(['success' => 'Tujuan Angkutan Berhasil Diupdate']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kode_tujuan)
    {
        abort_if(!auth()->user()->can('tujuanangkutan.delete'), 403);

        $kode_tujuan = Crypt::decrypt($kode_tujuan);
        try {
            $tujuan = Tujuanangkutan::findOrFail($kode_tujuan);
            $tujuan->delete();
            return Redirect::back()->with(['success' => 'Tujuan Angkutan Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }
}
