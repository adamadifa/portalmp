<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use Illuminate\Http\Request;

class CoaController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('coa.index'), 403);

        $query = Coa::query();

        if (!empty($request->nama_akun)) {
            $query->where(function($q) use ($request) {
                $q->where('nama_akun', 'like', '%' . $request->nama_akun . '%')
                  ->orWhere('kode_akun', 'like', '%' . $request->nama_akun . '%');
            });
        }

        $coa = $query->orderBy('kode_akun', 'asc')->get();

        return view('settings.coa.index', compact('coa'));
    }
}
