<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailbiaya extends Model
{
    use HasFactory;

    protected $table = 'biaya_detail';
    protected $guarded = [];

    public function biaya()
    {
        return $this->belongsTo(Biaya::class, 'no_bukti', 'no_bukti');
    }

    public function coa()
    {
        return $this->belongsTo(Coa::class, 'kode_akun', 'kode_akun');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'kode_cabang', 'kode_cabang');
    }
}
