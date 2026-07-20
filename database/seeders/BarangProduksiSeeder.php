<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class BarangProduksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barangs = DB::select("SELECT * FROM pacificjul.produksi_barang");

        foreach ($barangs as $b) {
            DB::table('produksi_barang')->updateOrInsert(
                ['kode_barang_produksi' => $b->kode_barang_produksi],
                [
                    'nama_barang' => $b->nama_barang,
                    'satuan' => $b->satuan,
                    'kode_asal_barang' => $b->kode_asal_barang,
                    'kode_kategori' => $b->kode_kategori,
                    'status_aktif_barang' => $b->status_aktif_barang,
                    'kode_barang_gb' => $b->kode_barang_gb,
                    'created_at' => $b->created_at ?? now(),
                    'updated_at' => $b->updated_at ?? now(),
                ]
            );
        }
    }
}
