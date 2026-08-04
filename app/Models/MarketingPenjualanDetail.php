<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingPenjualanDetail extends Model
{
    use HasFactory;

    protected $table = 'marketing_penjualan_detail';
    protected $guarded = [];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'kode_produk', 'kode_produk');
    }

    public function penjualan()
    {
        return $this->belongsTo(MarketingPenjualan::class, 'no_bukti', 'no_bukti');
    }
}
