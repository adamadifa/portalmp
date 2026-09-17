<?php

namespace Database\Seeders;

use App\Models\Coa;
use App\Models\Detailsaldoawalbukubesar;
use App\Models\Saldoawalbukubesar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaldoawalbukubesarJanuari2026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan akun 2-11206 (Hutang PPh 25) terdaftar di tabel coa
        Coa::updateOrCreate(
            ['kode_akun' => '2-11206'],
            [
                'nama_akun' => 'Hutang PPh 25',
                'sub_akun' => '2-11200',
                'level' => 3,
            ]
        );

        $bulan = 1;
        $tahun = 2026;
        $kode_saldo_awal = 'SA012026';
        $tanggal = '2026-01-01';

        // Data Saldo Awal Buku Besar Januari 2026
        $saldoData = [
            // ==========================================
            // AKTIVA LANCAR
            // ==========================================
            // Kas & Bank
            '1-11101' => 1520318754,    // Kas Besar
            '1-11102' => 0,             // Kas Kecil
            '1-11103' => 13272643,      // BANK BCA
            '1-11104' => 363534573,     // BANK BNI
            '1-11105' => 0,             // BANK BSI

            // Piutang
            '1-11201' => 8492080279,    // Piutang Usaha

            // Persediaan
            '1-11301' => 7452548583,    // Persediaan Barang Jadi
            '1-11302' => 7125456556,    // Persediaan Bahan Baku
            '1-11303' => 1201254566,    // Persediaan Bahan Kemasan
            '1-11304' => 0,             // Persediaan Bahan Bakar
            '1-11305' => 0,             // Persediaan Barang Dalam Proses
            '1-11306' => 0,             // Persediaan Bahan Penolong

            // Pajak Dibayar Dimuka
            '1-11401' => 529368100,     // PPh 22 Impor
            '1-11402' => 540939564,     // PPh 25

            // PPN Masukan
            '1-11501' => 0,             // PPN Masukan

            // ==========================================
            // AKTIVA TETAP (Akumulasi Penyusutan bertanda negatif)
            // ==========================================
            '1-21101' => 27264908,      // Kendaraan
            '1-21102' => -27264908,     // Akumulasi Penyusutan Kendaraan
            '1-21103' => 1206934094,    // Peralatan
            '1-21104' => -1051099167,   // Akumulasi Penyusutan Peralatan
            '1-21105' => 835851695,     // Inventaris Pabrik
            '1-21106' => -582895577,    // Akumulasi Penyusutan Inventaris Pabrik

            // ==========================================
            // KEWAJIBAN LANCAR
            // ==========================================
            // Hutang Dagang
            '2-11101' => 3992788148,    // Hutang Usaha
            '2-11102' => 5214269001,    // Hutang Pihak Ketiga
            '2-11103' => 8957555000,    // Biaya Yang Masih Harus Dibayar

            // Hutang Pajak
            '2-11201' => 19952297,      // Hutang PPN
            '2-11202' => 18143714,      // Hutang PPh 21
            '2-11203' => 1288168,       // Hutang PPh 23
            '2-11204' => 30000000,      // Hutang PPh Final Sewa
            '2-11205' => 2710967,       // Hutang PPh 29
            '2-11206' => 0,             // Hutang PPh 25

            // PPN Keluaran
            '2-11301' => 0,             // PPN Keluaran

            // ==========================================
            // EKUITAS
            // ==========================================
            '3-11100' => 5500000000,    // Modal
            '3-11200' => 106518587,     // RETAINED EARNING
            '3-11300' => 3804338783,    // Laba tahun ini
            '3-11400' => 0,             // PRIVE
        ];

        DB::beginTransaction();
        try {
            // Header Saldo Awal
            Saldoawalbukubesar::updateOrCreate(
                ['kode_saldo_awal' => $kode_saldo_awal],
                [
                    'tanggal' => $tanggal,
                    'bulan'   => $bulan,
                    'tahun'   => $tahun,
                ]
            );

            // Bersihkan detail lama jika ada
            Detailsaldoawalbukubesar::where('kode_saldo_awal', $kode_saldo_awal)->delete();

            // Insert detail saldo awal
            foreach ($saldoData as $kode_akun => $jumlah) {
                if ($jumlah != 0) {
                    Detailsaldoawalbukubesar::create([
                        'kode_saldo_awal' => $kode_saldo_awal,
                        'kode_akun'       => $kode_akun,
                        'jumlah'          => $jumlah,
                    ]);
                }
            }

            DB::commit();
            $this->command->info("Saldo Awal Buku Besar Periode Januari 2026 ($kode_saldo_awal) berhasil disimpan.");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("Gagal menyimpan Saldo Awal Buku Besar: " . $e->getMessage());
        }
    }
}
