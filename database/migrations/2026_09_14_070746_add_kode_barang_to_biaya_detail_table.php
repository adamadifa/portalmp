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
        Schema::table('biaya_detail', function (Blueprint $table) {
            $table->char('kode_barang', 7)->nullable()->after('no_bukti');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('biaya_detail', function (Blueprint $table) {
            $table->dropColumn('kode_barang');
        });
    }
};
