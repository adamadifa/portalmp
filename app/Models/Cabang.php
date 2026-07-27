<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cabang extends Model
{
    protected $table = 'cabang';
    protected $primaryKey = 'kode_cabang';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_cabang',
        'nama_cabang',
        'alamat_cabang',
        'telepon_cabang',
        'lokasi_cabang',
        'radius_cabang',
        'kode_regional',
        'urutan',
        'color_marker',
        'kode_pt',
        'nama_pt',
        'status_aktif_cabang',
        'email'
    ];

    public function getCabang()
    {
        $id_user = auth()->user()->id;
        $user = User::findOrFail($id_user);
        $kode_regional = auth()->user()->kode_regional;
        $kode_cabang = auth()->user()->kode_cabang;
        $roles_access_all_cabang = config('global.roles_access_all_cabang');
        if ($user->hasRole($roles_access_all_cabang) || $user->hasRole('admin pusat')) {
            $cabang = Cabang::orderBy('kode_cabang')->get();
        } else {
            if ($kode_regional != "R00") {
                $cabang = Cabang::where('kode_regional', $kode_regional)->get();
            } else {
                $cabang = Cabang::where('kode_cabang', $kode_cabang)->get();
            }
        }

        return $cabang;
    }

    public function pelanggan(): HasMany
    {
        return $this->hasMany(Pelanggan::class, 'kode_cabang', 'kode_cabang');
    }
}
