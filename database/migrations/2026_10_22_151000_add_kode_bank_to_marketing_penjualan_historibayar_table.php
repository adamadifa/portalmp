<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('marketing_penjualan_historibayar', function (Blueprint $table) {
            $table->char('kode_bank', 5)->nullable()->after('jumlah');
            $table->foreign('kode_bank')->references('kode_bank')->on('bank')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('marketing_penjualan_historibayar', function (Blueprint $table) {
            $table->dropForeign(['kode_bank']);
            $table->dropColumn('kode_bank');
        });
    }
};
