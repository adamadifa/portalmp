<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'kode_pelanggan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_pelanggan',
        'tanggal_register',
        'nik',
        'no_kk',
        'nama_pelanggan',
        'tanggal_lahir',
        'alamat_pelanggan',
        'alamat_toko',
        'no_hp_pelanggan',
        'hari',
        'latitude',
        'longitude',
        'status_lokasi',
        'ljt',
        'foto',
        'limit_pelanggan',
        'status_aktif_pelanggan',
        'kode_cabang',
        'kode_cabang_pkp'
    ];

    public function cabang(): BelongsTo
    {
        return $this->belongsTo(Cabang::class, 'kode_cabang', 'kode_cabang');
    }
}
