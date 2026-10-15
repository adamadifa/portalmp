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
        Schema::table('biaya', function (Blueprint $table) {
            $table->char('bulan_pajak', 2)->nullable()->after('tanggal');
            $table->char('tahun_pajak', 4)->nullable()->after('bulan_pajak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('biaya', function (Blueprint $table) {
            $table->dropColumn(['bulan_pajak', 'tahun_pajak']);
        });
    }
};
