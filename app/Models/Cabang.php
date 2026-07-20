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

    public function pelanggan(): HasMany
    {
        return $this->hasMany(Pelanggan::class, 'kode_cabang', 'kode_cabang');
    }
}
