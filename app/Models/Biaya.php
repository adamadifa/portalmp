<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Biaya extends Model
{
    use HasFactory;

    protected $table = 'biaya';
    protected $primaryKey = 'no_bukti';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';

    public function detail()
    {
        return $this->hasMany(Detailbiaya::class, 'no_bukti', 'no_bukti');
    }

    public function historibayar()
    {
        return $this->hasMany(Historibayarbiaya::class, 'no_bukti', 'no_bukti');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'kode_supplier', 'kode_supplier');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function getBiaya($no_bukti = "", Request $request = null, $kode_supplier = "")
    {
        $query = Biaya::query();
        $query->select(
            'biaya.*',
            'supplier.nama_supplier',
            'coa.nama_akun',
            DB::raw('IFNULL(detailbiaya.total_biaya, 0) as total_biaya'),
            DB::raw('IFNULL(historibayar.total_bayar, 0) as total_bayar'),
            DB::raw('(IFNULL(detailbiaya.total_biaya, 0) - IFNULL(historibayar.total_bayar, 0)) as sisa_bayar')
        );

        $query->leftJoin('supplier', 'biaya.kode_supplier', '=', 'supplier.kode_supplier');
        $query->leftJoin('coa', 'biaya.kode_akun', '=', 'coa.kode_akun');

        // Subquery Total Biaya
        $query->leftJoin(
            DB::raw('(
                SELECT no_bukti, SUM((jumlah * harga) + penyesuaian) as total_biaya
                FROM biaya_detail
                GROUP BY no_bukti
            ) detailbiaya'),
            function ($join) {
                $join->on('biaya.no_bukti', '=', 'detailbiaya.no_bukti');
            }
        );

        // Subquery Total Bayar
        $query->leftJoin(
            DB::raw('(
                SELECT no_bukti, SUM(jumlah) as total_bayar
                FROM biaya_historibayar
                GROUP BY no_bukti
            ) historibayar'),
            function ($join) {
                $join->on('biaya.no_bukti', '=', 'historibayar.no_bukti');
            }
        );

        if (!empty($no_bukti)) {
            $query->where('biaya.no_bukti', $no_bukti);
        }

        if (!empty($kode_supplier)) {
            $query->where('biaya.kode_supplier', $kode_supplier);
        }

        if ($request != null) {
            if (!empty($request->dari) && !empty($request->sampai)) {
                $query->whereBetween('biaya.tanggal', [$request->dari, $request->sampai]);
            }

            if (!empty($request->no_bukti_search)) {
                $query->where('biaya.no_bukti', 'like', '%' . $request->no_bukti_search . '%');
            }

            if (!empty($request->kode_supplier_search)) {
                $query->where('biaya.kode_supplier', $request->kode_supplier_search);
            }

            if (!empty($request->jenis_transaksi_search)) {
                $query->where('biaya.jenis_transaksi', $request->jenis_transaksi_search);
            }

            if (!empty($request->kategori_transaksi_search)) {
                $query->where('biaya.kategori_transaksi', $request->kategori_transaksi_search);
            }

            if ($request->status_bayar === '1') { // Lunas
                $query->havingRaw('(total_biaya - total_bayar) <= 0');
            } elseif ($request->status_bayar === '0') { // Belum Lunas
                $query->havingRaw('(total_biaya - total_bayar) > 0');
            }
        }

        $query->orderBy('biaya.tanggal', 'desc');
        $query->orderBy('biaya.no_bukti', 'desc');

        return $query;
    }
}
