<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('seeders/bank_data.json');
        if (file_exists($path)) {
            $banks = json_decode(file_get_contents($path), true);
            foreach ($banks as $bank) {
                DB::table('bank')->updateOrInsert(
                    ['kode_bank' => $bank['kode_bank']],
                    [
                        'nama_bank' => $bank['nama_bank'],
                        'no_rekening' => $bank['no_rekening'] ?? null,
                        'kode_cabang' => $bank['kode_cabang'] ?? null,
                        'show_on_cabang' => $bank['show_on_cabang'] ?? 0,
                        'kode_akun' => $bank['kode_akun'] ?? null,
                        'jenis_rekening' => $bank['jenis_rekening'] ?? null,
                        'created_at' => $bank['created_at'] ?? null,
                        'updated_at' => $bank['updated_at'] ?? null,
                    ]
                );
            }
        }
    }
}
