<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class BarangPembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed hrd_departemen
        $departments = DB::select("SELECT * FROM pacificjul.hrd_departemen");
        foreach ($departments as $d) {
            DB::table('hrd_departemen')->updateOrInsert(
                ['kode_dept' => $d->kode_dept],
                [
                    'nama_dept' => $d->nama_dept,
                    'created_at' => $d->created_at ?? now(),
                    'updated_at' => $d->updated_at ?? now(),
                ]
            );
        }

        // 2. Seed hrd_group
        $groups = DB::select("SELECT * FROM pacificjul.hrd_group");
        foreach ($groups as $g) {
            DB::table('hrd_group')->updateOrInsert(
                ['kode_group' => $g->kode_group],
                [
                    'nama_group' => $g->nama_group,
                    'kode_dept' => $g->kode_dept,
                    'created_at' => $g->created_at ?? now(),
                    'updated_at' => $g->updated_at ?? now(),
                ]
            );
        }

        // 3. Seed pembelian_barang_kategori
        $categories = DB::select("SELECT * FROM pacificjul.pembelian_barang_kategori");
        foreach ($categories as $c) {
            DB::table('pembelian_barang_kategori')->updateOrInsert(
                ['kode_kategori' => $c->kode_kategori],
                [
                    'nama_kategori' => $c->nama_kategori,
                    'kode_group' => $c->kode_group,
                    'created_at' => $c->created_at ?? now(),
                    'updated_at' => $c->updated_at ?? now(),
                ]
            );
        }

        // 4. Seed pembelian_barang
        $barangs = DB::select("SELECT * FROM pacificjul.pembelian_barang");
        foreach ($barangs as $b) {
            DB::table('pembelian_barang')->updateOrInsert(
                ['kode_barang' => $b->kode_barang],
                [
                    'nama_barang' => $b->nama_barang,
                    'satuan' => $b->satuan,
                    'kode_jenis_barang' => $b->kode_jenis_barang,
                    'kode_kategori' => $b->kode_kategori,
                    'kode_group' => $b->kode_group,
                    'status' => $b->status,
                    'created_at' => $b->created_at ?? now(),
                    'updated_at' => $b->updated_at ?? now(),
                ]
            );
        }
    }
}
