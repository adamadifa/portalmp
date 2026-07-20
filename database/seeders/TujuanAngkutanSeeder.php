<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class TujuanAngkutanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tujuans = DB::select("SELECT * FROM pacificjul.angkutan_tujuan");

        foreach ($tujuans as $t) {
            DB::table('angkutan_tujuan')->updateOrInsert(
                ['kode_tujuan' => $t->kode_tujuan],
                [
                    'tujuan' => $t->tujuan,
                    'tarif' => $t->tarif,
                    'status' => $t->status,
                    'created_at' => $t->created_at ?? now(),
                    'updated_at' => $t->updated_at ?? now(),
                ]
            );
        }
    }
}
