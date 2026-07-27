<?php

namespace App\Http\Controllers;

use App\Models\Barangpembelian;
use App\Models\Kategoribarangpembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class BarangpembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('barangpembelian.view'), 403);

        $query = Barangpembelian::query();

        if (!empty($request->nama_barang)) {
            $query->where('nama_barang', 'like', '%' . $request->nama_barang . '%')
                  ->orWhere('kode_barang', 'like', '%' . $request->nama_barang . '%');
        }

        $query->select('pembelian_barang.*', 'pembelian_barang_kategori.nama_kategori')
              ->join('pembelian_barang_kategori', 'pembelian_barang.kode_kategori', '=', 'pembelian_barang_kategori.kode_kategori');

        // Apply role-based filtering if user is not super admin/direktur/pembelian manager
        $user = auth()->user();
        if ($user->hasRole('admin gudang bahan')) {
            $query->where('pembelian_barang.kode_group', 'GDB');
        } else if ($user->hasRole('admin ga')) {
            $query->where('pembelian_barang.kode_group', 'GAF');
        } else if ($user->hasRole('admin gudang logistik')) {
            $query->where('pembelian_barang.kode_group', 'GDL');
        } else if ($user->hasRole('admin pembelian')) {
            $query->where('pembelian_barang.kode_group', '!=', 'GDL');
        }

        $query->orderBy('created_at', 'desc');
        $barang = $query->paginate(12);
        $barang->appends(request()->all());

        $jenis_barang = config('pembelian.jenis_barang');
        $group = config('pembelian.group');

        return view('settings.barangpembelian.index', compact('barang', 'jenis_barang', 'group'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!auth()->user()->can('barangpembelian.create'), 403);

        $list_jenis_barang = config('pembelian.list_jenis_barang');
        $kategori = Kategoribarangpembelian::orderBy('kode_kategori')->get();
        $list_group = config('pembelian.list_group');

        return view('settings.barangpembelian.create', compact('list_jenis_barang', 'kategori', 'list_group'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('barangpembelian.create'), 403);

        $request->validate([
            'kode_barang' => 'required|max:7|unique:pembelian_barang,kode_barang',
            'nama_barang' => 'required|max:100',
            'satuan' => 'required|max:20',
            'kode_jenis_barang' => 'required|max:2',
            'kode_kategori' => 'required|max:4',
            'kode_group' => 'required|max:3',
            'status' => 'required|max:1'
        ]);

        try {
            Barangpembelian::create([
                'kode_barang' => textUpperCase($request->kode_barang),
                'nama_barang' => textUpperCase($request->nama_barang),
                'satuan' => textUpperCase($request->satuan),
                'kode_jenis_barang' => $request->kode_jenis_barang,
                'kode_kategori' => $request->kode_kategori,
                'kode_group' => $request->kode_group,
                'status' => $request->status,
            ]);

            return Redirect::back()->with(['success' => 'Data Barang Berhasil Disimpan']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($kode_barang)
    {
        abort_if(!auth()->user()->can('barangpembelian.edit'), 403);

        $kode_barang = Crypt::decrypt($kode_barang);
        $barangpembelian = Barangpembelian::findOrFail($kode_barang);
        $list_jenis_barang = config('pembelian.list_jenis_barang');
        $kategori = Kategoribarangpembelian::orderBy('kode_kategori')->get();
        $list_group = config('pembelian.list_group');

        return view('settings.barangpembelian.edit', compact('barangpembelian', 'list_jenis_barang', 'kategori', 'list_group'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kode_barang)
    {
        abort_if(!auth()->user()->can('barangpembelian.edit'), 403);

        $kode_barang = Crypt::decrypt($kode_barang);
        $barang = Barangpembelian::findOrFail($kode_barang);

        $request->validate([
            'kode_barang' => 'required|max:7|unique:pembelian_barang,kode_barang,' . $kode_barang . ',kode_barang',
            'nama_barang' => 'required|max:100',
            'satuan' => 'required|max:20',
            'kode_jenis_barang' => 'required|max:2',
            'kode_kategori' => 'required|max:4',
            'kode_group' => 'required|max:3',
            'status' => 'required|max:1'
        ]);

        try {
            $barang->update([
                'kode_barang' => textUpperCase($request->kode_barang),
                'nama_barang' => textUpperCase($request->nama_barang),
                'satuan' => textUpperCase($request->satuan),
                'kode_jenis_barang' => $request->kode_jenis_barang,
                'kode_kategori' => $request->kode_kategori,
                'kode_group' => $request->kode_group,
                'status' => $request->status,
            ]);

            return Redirect::back()->with(['success' => 'Data Barang Berhasil Diupdate']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kode_barang)
    {
        abort_if(!auth()->user()->can('barangpembelian.delete'), 403);

        $kode_barang = Crypt::decrypt($kode_barang);
        try {
            $barang = Barangpembelian::findOrFail($kode_barang);
            $barang->delete();
            return Redirect::back()->with(['success' => 'Data Barang Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * AJAX action to get items filtered by category.
     */
    public function getbarangbykategori(Request $request)
    {
        $query = Barangpembelian::query();
        $query->where('status', 1);
        $query->where('kode_kategori', $request->kode_kategori);
        $query->orderBy('nama_barang');
        $barang = $query->get();

        echo "<option value=''>Semua Barang</option>";
        foreach ($barang as $d) {
            echo "<option value='{$d->kode_barang}'>" . textUpperCase($d->nama_barang) . "</option>";
        }
    }

    /**
     * AJAX action to fetch Datatables JSON payload.
     */
    public function getbarangjson(Request $request, $kode_group)
    {
        if ($request->ajax()) {
            $query = Barangpembelian::query();
            $query->select('pembelian_barang.*', 'pembelian_barang_kategori.nama_kategori');
            if ($kode_group != "000") {
                $query->where('pembelian_barang.kode_group', $kode_group);
            }
            $query->join('pembelian_barang_kategori', 'pembelian_barang.kode_kategori', '=', 'pembelian_barang_kategori.kode_kategori');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<button type="button" class="pilihBarang inline-flex items-center px-2.5 py-1 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-lg transition shadow-sm" kode_barang="' . $row->kode_barang . '" nama_barang="' . $row->nama_barang . '" kode_jenis_barang="' . $row->kode_jenis_barang . '">Pilih</button>';
                })
                ->addColumn('namabarang', function ($row) {
                    return textUpperCase($row->nama_barang);
                })
                ->addColumn('jenisbarang', function ($row) {
                    $jenis_barang = config('pembelian.jenis_barang');
                    return $jenis_barang[$row->kode_jenis_barang] ?? '-';
                })
                ->rawColumns(['action', 'jenisbarang', 'namabarang'])
                ->make(true);
        }
    }
}
