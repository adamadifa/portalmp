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
        if (!Schema::hasTable('gudang_logistik_barang_keluar_detail')) {
            Schema::create('gudang_logistik_barang_keluar_detail', function (Blueprint $table) {
                $table->char('no_bukti', 17);
                $table->char('kode_barang', 7);
                $table->double('jumlah', 8, 2);
                $table->string('keterangan')->nullable();
                $table->char('kode_cabang', 3)->nullable();
                $table->foreign('no_bukti')->references('no_bukti')->on('gudang_logistik_barang_keluar')->cascadeOnDelete()->cascadeOnUpdate();
                $table->foreign('kode_barang')->references('kode_barang')->on('pembelian_barang')->restrictOnDelete()->cascadeOnUpdate();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gudang_logistik_barang_keluar_detail');
    }
};
