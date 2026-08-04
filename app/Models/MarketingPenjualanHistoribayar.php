<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingPenjualanHistoribayar extends Model
{
    use HasFactory;

    protected $table = 'marketing_penjualan_historibayar';
    protected $primaryKey = 'no_bukti';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function penjualan()
    {
        return $this->belongsTo(MarketingPenjualan::class, 'no_bukti_penjualan', 'no_bukti');
    }
}
