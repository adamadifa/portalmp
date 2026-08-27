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

        // Drop foreign keys safely
        try {
            Schema::table('pembelian_detail', function (Blueprint $table) {
                $table->dropForeign('pembelian_detail_kode_akun_foreign');
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('pembelian', function (Blueprint $table) {
                $table->dropForeign('pembelian_kode_akun_foreign');
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('coa_departemen', function (Blueprint $table) {
                $table->dropForeign('coa_departemen_kode_akun_foreign');
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('pembelian_jurnalkoreksi', function (Blueprint $table) {
                $table->dropForeign('pembelian_jurnalkoreksi_kode_akun_foreign');
            });
        } catch (\Exception $e) {}

        // Modify columns
        DB::statement('ALTER TABLE coa MODIFY COLUMN kode_akun VARCHAR(10)');
        DB::statement('ALTER TABLE coa MODIFY COLUMN sub_akun VARCHAR(10) NULL');
        DB::statement('ALTER TABLE coa_departemen MODIFY COLUMN kode_akun VARCHAR(10)');
        DB::statement('ALTER TABLE pembelian_detail MODIFY COLUMN kode_akun VARCHAR(10)');
        DB::statement('ALTER TABLE pembelian MODIFY COLUMN kode_akun VARCHAR(10)');
        DB::statement('ALTER TABLE bank MODIFY COLUMN kode_akun VARCHAR(10) NULL');
        DB::statement('ALTER TABLE gudang_logistik_barang_masuk_detail MODIFY COLUMN kode_akun VARCHAR(10) NULL');
        DB::statement('ALTER TABLE marketing_penjualan_historibayar MODIFY COLUMN kode_akun VARCHAR(10) NULL');
        DB::statement('ALTER TABLE pembelian_jurnalkoreksi MODIFY COLUMN kode_akun VARCHAR(10)');

        // Recreate foreign keys safely
        try {
            Schema::table('coa_departemen', function (Blueprint $table) {
                $table->foreign('kode_akun')->references('kode_akun')->on('coa')->cascadeOnUpdate()->restrictOnDelete();
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('pembelian', function (Blueprint $table) {
                $table->foreign('kode_akun')->references('kode_akun')->on('coa')->cascadeOnUpdate()->restrictOnDelete();
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('pembelian_detail', function (Blueprint $table) {
                $table->foreign('kode_akun')->references('kode_akun')->on('coa')->cascadeOnUpdate()->restrictOnDelete();
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('pembelian_jurnalkoreksi', function (Blueprint $table) {
                $table->foreign('kode_akun')->references('kode_akun')->on('coa')->cascadeOnUpdate()->restrictOnDelete();
            });
        } catch (\Exception $e) {}

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        // Drop foreign keys safely
        try {
            Schema::table('pembelian_detail', function (Blueprint $table) {
                $table->dropForeign('pembelian_detail_kode_akun_foreign');
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('pembelian', function (Blueprint $table) {
                $table->dropForeign('pembelian_kode_akun_foreign');
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('coa_departemen', function (Blueprint $table) {
                $table->dropForeign('coa_departemen_kode_akun_foreign');
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('pembelian_jurnalkoreksi', function (Blueprint $table) {
                $table->dropForeign('pembelian_jurnalkoreksi_kode_akun_foreign');
            });
        } catch (\Exception $e) {}

        // Restore columns
        DB::statement('ALTER TABLE coa MODIFY COLUMN kode_akun CHAR(6)');
        DB::statement('ALTER TABLE coa MODIFY COLUMN sub_akun CHAR(6) NULL');
        DB::statement('ALTER TABLE coa_departemen MODIFY COLUMN kode_akun CHAR(8)');
        DB::statement('ALTER TABLE pembelian_detail MODIFY COLUMN kode_akun CHAR(6)');
        DB::statement('ALTER TABLE pembelian MODIFY COLUMN kode_akun CHAR(6)');
        DB::statement('ALTER TABLE bank MODIFY COLUMN kode_akun CHAR(6) NULL');
        DB::statement('ALTER TABLE gudang_logistik_barang_masuk_detail MODIFY COLUMN kode_akun CHAR(6) NULL');
        DB::statement('ALTER TABLE marketing_penjualan_historibayar MODIFY COLUMN kode_akun CHAR(6) NULL');
        DB::statement('ALTER TABLE pembelian_jurnalkoreksi MODIFY COLUMN kode_akun CHAR(8)');

        // Recreate foreign keys safely
        try {
            Schema::table('coa_departemen', function (Blueprint $table) {
                $table->foreign('kode_akun')->references('kode_akun')->on('coa')->cascadeOnUpdate()->restrictOnDelete();
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('pembelian', function (Blueprint $table) {
                $table->foreign('kode_akun')->references('kode_akun')->on('coa')->cascadeOnUpdate()->restrictOnDelete();
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('pembelian_detail', function (Blueprint $table) {
                $table->foreign('kode_akun')->references('kode_akun')->on('coa')->cascadeOnUpdate()->restrictOnDelete();
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('pembelian_jurnalkoreksi', function (Blueprint $table) {
                $table->foreign('kode_akun')->references('kode_akun')->on('coa')->cascadeOnUpdate()->restrictOnDelete();
            });
        } catch (\Exception $e) {}

        Schema::enableForeignKeyConstraints();
    }
};
