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

    public function create()
    {
        abort_if(!auth()->user()->can('coa.create'), 403);

        $parentAccounts = Coa::orderBy('kode_akun')->get();
        return view('settings.coa.create', compact('parentAccounts'));
    }

    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('coa.create'), 403);

        $request->validate([
            'kode_akun' => 'required|unique:coa,kode_akun|max:20',
            'nama_akun' => 'required|max:100',
            'sub_akun'  => 'nullable|max:20',
        ], [
            'kode_akun.required' => 'Kode akun wajib diisi.',
            'kode_akun.unique'   => 'Kode akun sudah digunakan.',
            'nama_akun.required' => 'Nama akun wajib diisi.',
        ]);

        $sub_akun = $request->sub_akun ?: null;
        $level = 1;
        if ($sub_akun) {
            $parent = Coa::where('kode_akun', $sub_akun)->first();
            $level = $parent ? ($parent->level + 1) : 2;
        }

        try {
            Coa::create([
                'kode_akun' => trim($request->kode_akun),
                'nama_akun' => trim($request->nama_akun),
                'sub_akun'  => $sub_akun,
                'level'     => $level,
            ]);

            return redirect()->route('coa.index')->with('success', 'Akun berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan akun: ' . $e->getMessage());
        }
    }

    public function edit($kode_akun)
    {
        abort_if(!auth()->user()->can('coa.edit'), 403);

        $coa = Coa::where('kode_akun', $kode_akun)->firstOrFail();
        $parentAccounts = Coa::where('kode_akun', '!=', $kode_akun)->orderBy('kode_akun')->get();

        return view('settings.coa.edit', compact('coa', 'parentAccounts'));
    }

    public function update(Request $request, $kode_akun)
    {
        abort_if(!auth()->user()->can('coa.update') && !auth()->user()->can('coa.edit'), 403);

        $coa = Coa::where('kode_akun', $kode_akun)->firstOrFail();

        $request->validate([
            'nama_akun' => 'required|max:100',
            'sub_akun'  => 'nullable|max:20',
        ], [
            'nama_akun.required' => 'Nama akun wajib diisi.',
        ]);

        $sub_akun = $request->sub_akun ?: null;
        $level = 1;
        if ($sub_akun) {
            $parent = Coa::where('kode_akun', $sub_akun)->first();
            $level = $parent ? ($parent->level + 1) : 2;
        }

        try {
            $coa->update([
                'nama_akun' => trim($request->nama_akun),
                'sub_akun'  => $sub_akun,
                'level'     => $level,
            ]);

            return redirect()->route('coa.index')->with('success', 'Akun berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui akun: ' . $e->getMessage());
        }
    }

    public function destroy($kode_akun)
    {
        abort_if(!auth()->user()->can('coa.delete'), 403);

        $coa = Coa::where('kode_akun', $kode_akun)->firstOrFail();

        // Cek jika akun digunakan sebagai sub_akun oleh akun lain
        $hasChildren = Coa::where('sub_akun', $kode_akun)->exists();
        if ($hasChildren) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun karena memiliki sub-akun (child account).');
        }

        try {
            $coa->delete();
            return redirect()->route('coa.index')->with('success', 'Akun berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus akun: ' . $e->getMessage());
        }
    }
}
