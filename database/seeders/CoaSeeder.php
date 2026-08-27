<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('coa')->truncate();

        $coas = [
            // Aktiva
            ['kode_akun' => '1-11000', 'nama_akun' => 'Aktiva Lancar', 'sub_akun' => null, 'level' => 1],
            ['kode_akun' => '1-11100', 'nama_akun' => 'Kas & Bank', 'sub_akun' => '1-11000', 'level' => 2],
            ['kode_akun' => '1-11101', 'nama_akun' => 'Kas Besar', 'sub_akun' => '1-11100', 'level' => 3],
            ['kode_akun' => '1-11102', 'nama_akun' => 'Kas Kecil', 'sub_akun' => '1-11100', 'level' => 3],
            ['kode_akun' => '1-11103', 'nama_akun' => 'BANK BCA', 'sub_akun' => '1-11100', 'level' => 3],
            ['kode_akun' => '1-11104', 'nama_akun' => 'BANK BNI', 'sub_akun' => '1-11100', 'level' => 3],
            ['kode_akun' => '1-11105', 'nama_akun' => 'BANK BSI', 'sub_akun' => '1-11100', 'level' => 3],
            
            ['kode_akun' => '1-11200', 'nama_akun' => 'Piutang Dagang', 'sub_akun' => '1-11000', 'level' => 2],
            ['kode_akun' => '1-11201', 'nama_akun' => 'Piutang Usaha', 'sub_akun' => '1-11200', 'level' => 3],
            
            ['kode_akun' => '1-11300', 'nama_akun' => 'Persediaan Barang Dagang', 'sub_akun' => '1-11000', 'level' => 2],
            ['kode_akun' => '1-11301', 'nama_akun' => 'Persediaan Barang Dagang', 'sub_akun' => '1-11300', 'level' => 3],
            ['kode_akun' => '1-11302', 'nama_akun' => 'Persediaan Bahan Baku', 'sub_akun' => '1-11300', 'level' => 3],
            ['kode_akun' => '1-11303', 'nama_akun' => 'Persediaan Bahan Kemasan', 'sub_akun' => '1-11300', 'level' => 3],
            ['kode_akun' => '1-11304', 'nama_akun' => 'Persediaan Bahan Bakar', 'sub_akun' => '1-11300', 'level' => 3],
            ['kode_akun' => '1-11305', 'nama_akun' => 'Persediaan Barang Dalam Proses', 'sub_akun' => '1-11300', 'level' => 3],
            ['kode_akun' => '1-11306', 'nama_akun' => 'Persediaan Bahan Penolong', 'sub_akun' => '1-11300', 'level' => 3],
            
            ['kode_akun' => '1-11400', 'nama_akun' => 'Pajak Dibayar Dimuka', 'sub_akun' => '1-11000', 'level' => 2],
            ['kode_akun' => '1-11401', 'nama_akun' => 'PPh 22 Impor', 'sub_akun' => '1-11400', 'level' => 3],
            ['kode_akun' => '1-11402', 'nama_akun' => 'PPH 25', 'sub_akun' => '1-11400', 'level' => 3],
            
            ['kode_akun' => '1-11500', 'nama_akun' => 'PPN Masukan', 'sub_akun' => '1-11000', 'level' => 2],
            ['kode_akun' => '1-11501', 'nama_akun' => 'PPN Masukan', 'sub_akun' => '1-11500', 'level' => 3],
            
            ['kode_akun' => '1-21000', 'nama_akun' => 'Aktiva Tetap', 'sub_akun' => null, 'level' => 1],
            ['kode_akun' => '1-21100', 'nama_akun' => 'Aktiva Tetap', 'sub_akun' => '1-21000', 'level' => 2],
            ['kode_akun' => '1-21101', 'nama_akun' => 'Kendaraan', 'sub_akun' => '1-21100', 'level' => 3],
            ['kode_akun' => '1-21102', 'nama_akun' => 'Akumulasi Penyusutan Kendaraan', 'sub_akun' => '1-21100', 'level' => 3],
            ['kode_akun' => '1-21103', 'nama_akun' => 'Peralatan', 'sub_akun' => '1-21100', 'level' => 3],
            ['kode_akun' => '1-21104', 'nama_akun' => 'Akumulasi Penyusutan Peralatan', 'sub_akun' => '1-21100', 'level' => 3],
            ['kode_akun' => '1-21105', 'nama_akun' => 'Inventaris Pabrik', 'sub_akun' => '1-21100', 'level' => 3],
            ['kode_akun' => '1-21106', 'nama_akun' => 'Akumulasi Penyusutan Inventaris Pabrik', 'sub_akun' => '1-21100', 'level' => 3],

            // Kewajiban
            ['kode_akun' => '2-11000', 'nama_akun' => 'Kewajiban Lancar', 'sub_akun' => null, 'level' => 1],
            ['kode_akun' => '2-11100', 'nama_akun' => 'Hutang Dagang', 'sub_akun' => '2-11000', 'level' => 2],
            ['kode_akun' => '2-11101', 'nama_akun' => 'Hutang Usaha', 'sub_akun' => '2-11100', 'level' => 3],
            ['kode_akun' => '2-11102', 'nama_akun' => 'Hutang Pihak Ketiga', 'sub_akun' => '2-11100', 'level' => 3],
            ['kode_akun' => '2-11103', 'nama_akun' => 'Biaya Yang Masih Harus Dibayar', 'sub_akun' => '2-11100', 'level' => 3],
            
            ['kode_akun' => '2-11200', 'nama_akun' => 'Hutang Pajak', 'sub_akun' => '2-11000', 'level' => 2],
            ['kode_akun' => '2-11201', 'nama_akun' => 'Hutang PPN', 'sub_akun' => '2-11200', 'level' => 3],
            ['kode_akun' => '2-11202', 'nama_akun' => 'Hutang PPh 21', 'sub_akun' => '2-11200', 'level' => 3],
            ['kode_akun' => '2-11203', 'nama_akun' => 'Hutang PPh 23', 'sub_akun' => '2-11200', 'level' => 3],
            ['kode_akun' => '2-11204', 'nama_akun' => 'Hutang PPh Final Sewa', 'sub_akun' => '2-11200', 'level' => 3],
            ['kode_akun' => '2-11205', 'nama_akun' => 'Hutang PPh 29', 'sub_akun' => '2-11200', 'level' => 3],
            
            ['kode_akun' => '2-11300', 'nama_akun' => 'PPN Keluaran', 'sub_akun' => '2-11000', 'level' => 2],
            ['kode_akun' => '2-11301', 'nama_akun' => 'PPN Keluaran', 'sub_akun' => '2-11300', 'level' => 3],

            // Ekuitas
            ['kode_akun' => '3-11000', 'nama_akun' => 'Ekuitas', 'sub_akun' => null, 'level' => 1],
            ['kode_akun' => '3-11100', 'nama_akun' => 'Modal', 'sub_akun' => '3-11000', 'level' => 2],
            ['kode_akun' => '3-11200', 'nama_akun' => 'RETAINED EARNING', 'sub_akun' => '3-11000', 'level' => 2],
            ['kode_akun' => '3-11300', 'nama_akun' => 'Laba tahun ini', 'sub_akun' => '3-11000', 'level' => 2],
            ['kode_akun' => '3-11400', 'nama_akun' => 'PRIVE', 'sub_akun' => '3-11000', 'level' => 2],
            ['kode_akun' => '3-11500', 'nama_akun' => 'Ikhtisar Laba Rugi', 'sub_akun' => '3-11000', 'level' => 2],

            // Pendapatan
            ['kode_akun' => '4-11000', 'nama_akun' => 'Pendapatan', 'sub_akun' => null, 'level' => 1],
            ['kode_akun' => '4-11100', 'nama_akun' => 'Pendapatan', 'sub_akun' => '4-11000', 'level' => 2],
            ['kode_akun' => '4-11101', 'nama_akun' => 'Penjualan', 'sub_akun' => '4-11100', 'level' => 3],

            // Pembelian
            ['kode_akun' => '5-11000', 'nama_akun' => 'Pembelian', 'sub_akun' => null, 'level' => 1],
            ['kode_akun' => '5-11100', 'nama_akun' => 'Pembelian', 'sub_akun' => '5-11000', 'level' => 2],
            ['kode_akun' => '5-11101', 'nama_akun' => 'Pembelian Bahan Baku', 'sub_akun' => '5-11100', 'level' => 3],
            ['kode_akun' => '5-11102', 'nama_akun' => 'Pembelian Bahan Kemasan', 'sub_akun' => '5-11100', 'level' => 3],
            ['kode_akun' => '5-11103', 'nama_akun' => 'Pembelian Bahan Bakar', 'sub_akun' => '5-11100', 'level' => 3],

            // BIAYA
            ['kode_akun' => '6-11000', 'nama_akun' => 'BIAYA OVERHEAD PABRIK', 'sub_akun' => null, 'level' => 1],
            ['kode_akun' => '6-11100', 'nama_akun' => 'Biaya Overhead Pabrik', 'sub_akun' => '6-11000', 'level' => 2],
            ['kode_akun' => '6-11101', 'nama_akun' => 'Biaya Listrik Pabrik', 'sub_akun' => '6-11100', 'level' => 3],
            ['kode_akun' => '6-11102', 'nama_akun' => 'Biaya Air Pabrik', 'sub_akun' => '6-11100', 'level' => 3],
            ['kode_akun' => '6-11103', 'nama_akun' => 'Biaya Pemakaian Bahan Bakar', 'sub_akun' => '6-11100', 'level' => 3],
            ['kode_akun' => '6-11104', 'nama_akun' => 'Biaya Penyusutan Inventaris Pabrik', 'sub_akun' => '6-11100', 'level' => 3],

            ['kode_akun' => '6-12100', 'nama_akun' => 'Biaya Tidak Langsung', 'sub_akun' => '6-11000', 'level' => 2],
            ['kode_akun' => '6-12101', 'nama_akun' => 'Biaya Uji Lab Produk', 'sub_akun' => '6-12100', 'level' => 3],
            ['kode_akun' => '6-12102', 'nama_akun' => 'BPTL Lainnya', 'sub_akun' => '6-12100', 'level' => 3],
            ['kode_akun' => '6-12103', 'nama_akun' => 'Biaya Pemeliharaan & Perbaikan Bangunan Pabrik', 'sub_akun' => '6-12100', 'level' => 3],
            ['kode_akun' => '6-12104', 'nama_akun' => 'Biaya Pemeliharaan & Perbaikan Mesin Produksi', 'sub_akun' => '6-12100', 'level' => 3],
            ['kode_akun' => '6-12105', 'nama_akun' => 'Biaya Pemeliharaan & Perbaikan Peralatan Pabrik', 'sub_akun' => '6-12100', 'level' => 3],
            ['kode_akun' => '6-12106', 'nama_akun' => 'Biaya Pemeliharaan & Perbaikan Instalasi Listrik/Air Pabrik', 'sub_akun' => '6-12100', 'level' => 3],

            ['kode_akun' => '6-13100', 'nama_akun' => 'Biaya Overhead Lainnya', 'sub_akun' => '6-11000', 'level' => 2],
            ['kode_akun' => '6-13101', 'nama_akun' => 'Bea Masuk', 'sub_akun' => '6-13100', 'level' => 3],
            ['kode_akun' => '6-13102', 'nama_akun' => 'Upah Produksi', 'sub_akun' => '6-13100', 'level' => 3],

            // BIAYA OPERASIONAL
            ['kode_akun' => '6-21100', 'nama_akun' => 'Beban Operasi / Biaya ADM', 'sub_akun' => null, 'level' => 1],
            ['kode_akun' => '6-21101', 'nama_akun' => 'Bahan Bakar Adm', 'sub_akun' => '6-21100', 'level' => 2],
            ['kode_akun' => '6-21102', 'nama_akun' => 'Biaya Listrik Adm', 'sub_akun' => '6-21100', 'level' => 2],
            ['kode_akun' => '6-21103', 'nama_akun' => 'Biaya Telp,Fax Adm', 'sub_akun' => '6-21100', 'level' => 2],
            ['kode_akun' => '6-21104', 'nama_akun' => 'Pajak & Perijinan', 'sub_akun' => '6-21100', 'level' => 2],
            ['kode_akun' => '6-21105', 'nama_akun' => 'Biaya Retribusi & Sumbangan', 'sub_akun' => '6-21100', 'level' => 2],
            ['kode_akun' => '6-21106', 'nama_akun' => 'Biaya Jamsostek/BPJS', 'sub_akun' => '6-21100', 'level' => 2],
            ['kode_akun' => '6-21107', 'nama_akun' => 'Biaya Perjalanan Dinas Adm', 'sub_akun' => '6-21100', 'level' => 2],
            ['kode_akun' => '6-21108', 'nama_akun' => 'Biaya Adm Lainnya', 'sub_akun' => '6-21100', 'level' => 2],
            ['kode_akun' => '6-21109', 'nama_akun' => 'Surat, Materai, Paket', 'sub_akun' => '6-21100', 'level' => 2],

            ['kode_akun' => '6-22100', 'nama_akun' => 'Biaya Penyusutan & Amortisasi', 'sub_akun' => null, 'level' => 1],
            ['kode_akun' => '6-22101', 'nama_akun' => 'Biaya Penyusutan Kendaraan', 'sub_akun' => '6-22100', 'level' => 2],
            ['kode_akun' => '6-22102', 'nama_akun' => 'Biaya Penyusutan Peralatan', 'sub_akun' => '6-22100', 'level' => 2],

            ['kode_akun' => '6-23100', 'nama_akun' => 'Biaya Jasa', 'sub_akun' => null, 'level' => 1],
            ['kode_akun' => '6-23101', 'nama_akun' => 'GENERAL PEST CONTROL', 'sub_akun' => '6-23100', 'level' => 2],
            ['kode_akun' => '6-23102', 'nama_akun' => 'JASA KONSULTAN', 'sub_akun' => '6-23100', 'level' => 2],
            ['kode_akun' => '6-23103', 'nama_akun' => 'Jasa Lab', 'sub_akun' => '6-23100', 'level' => 2],
            ['kode_akun' => '6-23104', 'nama_akun' => 'Jasa Sertifikasi', 'sub_akun' => '6-23100', 'level' => 2],

            ['kode_akun' => '6-24100', 'nama_akun' => 'Biaya Impor', 'sub_akun' => null, 'level' => 1],
            ['kode_akun' => '6-24101', 'nama_akun' => 'BIAYA IMPOR', 'sub_akun' => '6-24100', 'level' => 2],

            ['kode_akun' => '6-25100', 'nama_akun' => 'Biaya Umum & Administrasi', 'sub_akun' => null, 'level' => 1],
            ['kode_akun' => '6-25110', 'nama_akun' => 'Gaji & Tunjangan Karyawan', 'sub_akun' => '6-25100', 'level' => 2],
            ['kode_akun' => '6-25111', 'nama_akun' => 'Biaya Gaji, Lembur', 'sub_akun' => '6-25110', 'level' => 3],
            ['kode_akun' => '6-25120', 'nama_akun' => 'Beban Utiliti, Adm, Sewa & Lainnya', 'sub_akun' => '6-25100', 'level' => 2],
            ['kode_akun' => '6-25121', 'nama_akun' => 'SPAREPART', 'sub_akun' => '6-25120', 'level' => 3],
            ['kode_akun' => '6-25122', 'nama_akun' => 'Biaya Umum & Adm Lainnya', 'sub_akun' => '6-25120', 'level' => 3],
            ['kode_akun' => '6-25130', 'nama_akun' => 'Repair & Maintenance Expense', 'sub_akun' => '6-25100', 'level' => 2],
            ['kode_akun' => '6-25131', 'nama_akun' => 'Pemeliharaan Mesin', 'sub_akun' => '6-25130', 'level' => 3],
            ['kode_akun' => '6-25132', 'nama_akun' => 'PEMELIHARAAN PERLENGKAPAN PABRIK', 'sub_akun' => '6-25130', 'level' => 3],
            ['kode_akun' => '6-25133', 'nama_akun' => 'Jasa Angkutan', 'sub_akun' => '6-25130', 'level' => 3],
            ['kode_akun' => '6-25134', 'nama_akun' => 'Sewa Mesin', 'sub_akun' => '6-25130', 'level' => 3],
            ['kode_akun' => '6-25135', 'nama_akun' => 'Sewa Bangunan', 'sub_akun' => '6-25130', 'level' => 3],
        ];

        DB::table('coa')->insert($coas);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
