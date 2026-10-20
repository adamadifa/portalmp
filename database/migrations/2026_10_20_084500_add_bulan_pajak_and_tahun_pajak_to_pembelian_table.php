<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pembelian', function (Blueprint $table) {
            $table->char('bulan_pajak', 2)->nullable()->after('tanggal');
            $table->char('tahun_pajak', 4)->nullable()->after('bulan_pajak');
        });

        // Populate existing data with month and year from tanggal
        DB::statement("UPDATE pembelian SET bulan_pajak = LPAD(MONTH(tanggal), 2, '0'), tahun_pajak = YEAR(tanggal) WHERE bulan_pajak IS NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembelian', function (Blueprint $table) {
            $table->dropColumn(['bulan_pajak', 'tahun_pajak']);
        });
    }
};
