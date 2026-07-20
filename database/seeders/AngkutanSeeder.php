<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class AngkutanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch angkutans from pacificjul database
        $angkutans = DB::select("SELECT * FROM pacificjul.angkutan");

        foreach ($angkutans as $a) {
            DB::table('angkutan')->updateOrInsert(
                ['kode_angkutan' => $a->kode_angkutan],
                [
                    'nama_angkutan' => $a->nama_angkutan,
                    'keterangan' => $a->keterangan,
                    'created_at' => $a->created_at ?? now(),
                    'updated_at' => $a->updated_at ?? now(),
                ]
            );
        }
    }
}
