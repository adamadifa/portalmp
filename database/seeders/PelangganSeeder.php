<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cabang = DB::table('cabang')->get();
        foreach ($cabang as $cab) {
            $kode_pelanggan = 'PL-' . $cab->kode_cabang;
            DB::table('pelanggan')->updateOrInsert(
                ['kode_pelanggan' => $kode_pelanggan],
                [
                    'tanggal_register' => now()->toDateString(),
                    'nik' => '3201010101010001',
                    'no_kk' => '3201010101010002',
                    'nama_pelanggan' => $cab->nama_pt,
                    'tanggal_lahir' => '1990-01-01',
                    'alamat_pelanggan' => $cab->alamat_cabang,
                    'alamat_toko' => $cab->alamat_cabang,
                    'no_hp_pelanggan' => $cab->telepon_cabang,
                    'hari' => 'Senin',
                    'latitude' => '-6.200000',
                    'longitude' => '106.816666',
                    'status_lokasi' => '1',
                    'ljt' => 1,
                    'foto' => null,
                    'limit_pelanggan' => 50000000,
                    'status_aktif_pelanggan' => '1',
                    'kode_cabang' => $cab->kode_cabang,
                    'kode_cabang_pkp' => $cab->kode_cabang,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}
