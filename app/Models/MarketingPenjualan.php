<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingPenjualan extends Model
{
    use HasFactory;

    protected $table = 'marketing_penjualan';
    protected $primaryKey = 'no_bukti';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'kode_pelanggan', 'kode_pelanggan');
    }

    public function detail()
    {
        return $this->hasMany(MarketingPenjualanDetail::class, 'no_bukti', 'no_bukti');
    }

    public function historibayar()
    {
        return $this->hasMany(MarketingPenjualanHistoribayar::class, 'no_bukti_penjualan', 'no_bukti');
    }
}
