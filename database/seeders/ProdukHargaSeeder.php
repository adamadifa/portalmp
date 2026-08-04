<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukHargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = \Illuminate\Support\Facades\DB::select("SELECT * FROM portaxdb.harga_supplier");
        foreach ($data as $row) {
            \Illuminate\Support\Facades\DB::table('produk_harga')->updateOrInsert(
                ['kode_produk' => $row->kode_produk],
                [
                    'harga' => $row->harga,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}
