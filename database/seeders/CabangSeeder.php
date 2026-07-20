<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cabang = DB::select("SELECT * FROM portaljuli.cabang");
        foreach ($cabang as $cab) {
            DB::table('cabang')->updateOrInsert(
                ['kode_cabang' => $cab->kode_cabang],
                [
                    'nama_cabang' => $cab->nama_cabang,
                    'alamat_cabang' => $cab->alamat_cabang,
                    'telepon_cabang' => $cab->telepon_cabang,
                    'lokasi_cabang' => $cab->lokasi_cabang,
                    'radius_cabang' => $cab->radius_cabang,
                    'kode_regional' => $cab->kode_regional,
                    'urutan' => $cab->urutan,
                    'color_marker' => $cab->color_marker,
                    'kode_pt' => $cab->kode_pt,
                    'nama_pt' => $cab->nama_pt,
                    'status_aktif_cabang' => $cab->status_aktif_cabang,
                    'email' => $cab->email,
                    'created_at' => $cab->created_at ?? now(),
                    'updated_at' => $cab->updated_at ?? now()
                ]
            );
        }
    }
}
