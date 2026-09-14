<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historibayarbiaya extends Model
{
    use HasFactory;

    protected $table = 'biaya_historibayar';
    protected $guarded = [];

    public function biaya()
    {
        return $this->belongsTo(Biaya::class, 'no_bukti', 'no_bukti');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'kode_bank', 'kode_bank');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'kode_cabang', 'kode_cabang');
    }
}
