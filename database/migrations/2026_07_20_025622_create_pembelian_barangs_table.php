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
        Schema::create('pembelian_barang', function (Blueprint $table) {
            $table->char('kode_barang', 7)->primary();
            $table->string('nama_barang', 100);
            $table->string('satuan', 20);
            $table->char('kode_jenis_barang', 2);
            $table->char('kode_kategori', 4);
            $table->char('kode_group', 3);
            $table->char('status', 1);
            $table->foreign('kode_kategori')->references('kode_kategori')->on('pembelian_barang_kategori')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_barang');
    }
};
