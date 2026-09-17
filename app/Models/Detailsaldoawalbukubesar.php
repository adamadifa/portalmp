<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailsaldoawalbukubesar extends Model
{
    use HasFactory;

    protected $table = 'bukubesar_saldoawal_detail';
    protected $guarded = [];

    public function saldoawal()
    {
        return $this->belongsTo(Saldoawalbukubesar::class, 'kode_saldo_awal', 'kode_saldo_awal');
    }

    public function coa()
    {
        return $this->belongsTo(Coa::class, 'kode_akun', 'kode_akun');
    }
}
