<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProdukKategori extends Model
{
    protected $table = 'produk_kategori';
    protected $primaryKey = 'kode_kategori_produk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_kategori_produk',
        'nama_kategori_produk'
    ];

    public function produk(): HasMany
    {
        return $this->hasMany(Produk::class, 'kode_kategori_produk', 'kode_kategori_produk');
    }
}
