<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saldoawalbukubesar extends Model
{
    use HasFactory;

    protected $table = 'bukubesar_saldoawal';
    protected $primaryKey = 'kode_saldo_awal';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function detail()
    {
        return $this->hasMany(Detailsaldoawalbukubesar::class, 'kode_saldo_awal', 'kode_saldo_awal');
    }
}
