<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch suppliers from pacificjul database
        $suppliers = DB::select("SELECT * FROM portaljuli.supplier");

        foreach ($suppliers as $supplier) {
            DB::table('supplier')->updateOrInsert(
                ['kode_supplier' => $supplier->kode_supplier],
                [
                    'nama_supplier' => $supplier->nama_supplier,
                    'contact_person' => $supplier->contact_person,
                    'no_hp_supplier' => $supplier->no_hp_supplier,
                    'alamat_supplier' => $supplier->alamat_supplier,
                    'email_supplier' => $supplier->email_supplier,
                    'no_rekening_supplier' => $supplier->no_rekening_supplier,
                    'created_at' => $supplier->created_at ?? now(),
                    'updated_at' => $supplier->updated_at ?? now(),
                ]
            );
        }
    }
}
