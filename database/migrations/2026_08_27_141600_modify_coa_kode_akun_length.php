<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::statement('ALTER TABLE coa MODIFY COLUMN kode_akun VARCHAR(10)');
        DB::statement('ALTER TABLE coa MODIFY COLUMN sub_akun VARCHAR(10) NULL');
        DB::statement('ALTER TABLE coa_departemen MODIFY COLUMN kode_akun VARCHAR(10)');
        DB::statement('ALTER TABLE pembelian_detail MODIFY COLUMN kode_akun VARCHAR(10)');
        DB::statement('ALTER TABLE pembelian MODIFY COLUMN kode_akun VARCHAR(10)');
        DB::statement('ALTER TABLE bank MODIFY COLUMN kode_akun VARCHAR(10) NULL');
        DB::statement('ALTER TABLE gudang_logistik_barang_masuk_detail MODIFY COLUMN kode_akun VARCHAR(10) NULL');
        DB::statement('ALTER TABLE marketing_penjualan_historibayar MODIFY COLUMN kode_akun VARCHAR(10) NULL');
        DB::statement('ALTER TABLE pembelian_jurnalkoreksi MODIFY COLUMN kode_akun VARCHAR(10)');

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::statement('ALTER TABLE coa MODIFY COLUMN kode_akun CHAR(6)');
        DB::statement('ALTER TABLE coa MODIFY COLUMN sub_akun CHAR(6) NULL');
        DB::statement('ALTER TABLE coa_departemen MODIFY COLUMN kode_akun CHAR(8)');
        DB::statement('ALTER TABLE pembelian_detail MODIFY COLUMN kode_akun CHAR(6)');
        DB::statement('ALTER TABLE pembelian MODIFY COLUMN kode_akun CHAR(6)');
        DB::statement('ALTER TABLE bank MODIFY COLUMN kode_akun CHAR(6) NULL');
        DB::statement('ALTER TABLE gudang_logistik_barang_masuk_detail MODIFY COLUMN kode_akun CHAR(6) NULL');
        DB::statement('ALTER TABLE marketing_penjualan_historibayar MODIFY COLUMN kode_akun CHAR(6) NULL');
        DB::statement('ALTER TABLE pembelian_jurnalkoreksi MODIFY COLUMN kode_akun CHAR(8)');

        Schema::enableForeignKeyConstraints();
    }
};
