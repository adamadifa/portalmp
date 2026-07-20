<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProdukJenis extends Model
{
    protected $table = 'produk_jenis';
    protected $primaryKey = 'kode_jenis_produk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_jenis_produk',
        'nama_jenis_produk'
    ];

    public function produk(): HasMany
    {
        return $this->hasMany(Produk::class, 'kode_jenis_produk', 'kode_jenis_produk');
    }
}
