<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'kode_produk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'satuan',
        'isi_pcs_dus',
        'isi_pack_dus',
        'isi_pcs_pack',
        'kode_kategori_produk',
        'kode_jenis_produk',
        'status_aktif_produk',
        'urutan'
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(ProdukKategori::class, 'kode_kategori_produk', 'kode_kategori_produk');
    }

    public function jenis(): BelongsTo
    {
        return $this->belongsTo(ProdukJenis::class, 'kode_jenis_produk', 'kode_jenis_produk');
    }
}
