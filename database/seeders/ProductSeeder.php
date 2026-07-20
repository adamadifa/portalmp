<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Copy produk_kategori
        $kategori = DB::select("SELECT * FROM portaljuli.produk_kategori");
        foreach ($kategori as $kat) {
            DB::table('produk_kategori')->updateOrInsert(
                ['kode_kategori_produk' => $kat->kode_kategori_produk],
                [
                    'nama_kategori_produk' => $kat->nama_kategori_produk,
                    'created_at' => $kat->created_at ?? now(),
                    'updated_at' => $kat->updated_at ?? now()
                ]
            );
        }

        // 2. Copy produk_jenis
        $jenis = DB::select("SELECT * FROM portaljuli.produk_jenis");
        foreach ($jenis as $jen) {
            DB::table('produk_jenis')->updateOrInsert(
                ['kode_jenis_produk' => $jen->kode_jenis_produk],
                [
                    'nama_jenis_produk' => $jen->nama_jenis_produk,
                    'created_at' => $jen->created_at ?? now(),
                    'updated_at' => $jen->updated_at ?? now()
                ]
            );
        }

        // 3. Copy produk
        $produk = DB::select("SELECT * FROM portaljuli.produk");
        foreach ($produk as $prod) {
            DB::table('produk')->updateOrInsert(
                ['kode_produk' => $prod->kode_produk],
                [
                    'nama_produk' => $prod->nama_produk,
                    'satuan' => $prod->satuan,
                    'isi_pcs_dus' => $prod->isi_pcs_dus,
                    'isi_pack_dus' => $prod->isi_pack_dus,
                    'isi_pcs_pack' => $prod->isi_pcs_pack,
                    'kode_kategori_produk' => $prod->kode_kategori_produk,
                    'kode_jenis_produk' => $prod->kode_jenis_produk,
                    'status_aktif_produk' => $prod->status_aktif_produk,
                    'urutan' => $prod->urutan,
                    'created_at' => $prod->created_at ?? now(),
                    'updated_at' => $prod->updated_at ?? now()
                ]
            );
        }
    }
}
