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
        Schema::create('marketing_penjualan', function (Blueprint $table) {
            $table->char('no_bukti', 13)->primary();
            $table->date('tanggal');
            $table->char('kode_pelanggan', 13);
            $table->char('jenis_transaksi', 1); // T: Tunai, K: Kredit
            $table->char('jenis_bayar', 2)->nullable(); // TN: Cash, TR: Transfer, etc.
            $table->char('status', 1)->default('0'); // 0: Belum Lunas, 1: Lunas
            $table->string('kode_cabang', 10)->nullable();
            $table->bigInteger('id_user');
            $table->timestamps();

            $table->foreign('kode_pelanggan')->references('kode_pelanggan')->on('pelanggan')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('marketing_penjualan_detail', function (Blueprint $table) {
            $table->char('no_bukti', 13);
            $table->char('kode_produk', 6);
            $table->integer('harga_dus');
            $table->integer('jumlah');
            $table->integer('subtotal');
            $table->timestamps();

            $table->primary(['no_bukti', 'kode_produk']);
            $table->foreign('no_bukti')->references('no_bukti')->on('marketing_penjualan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kode_produk')->references('kode_produk')->on('produk')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('marketing_penjualan_historibayar', function (Blueprint $table) {
            $table->char('no_bukti', 13)->primary();
            $table->date('tanggal');
            $table->char('no_bukti_penjualan', 13);
            $table->char('jenis_bayar', 2);
            $table->integer('jumlah');
            $table->char('kode_akun', 6)->nullable();
            $table->bigInteger('id_user');
            $table->timestamps();

            $table->foreign('no_bukti_penjualan')->references('no_bukti')->on('marketing_penjualan')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketing_penjualan_historibayar');
        Schema::dropIfExists('marketing_penjualan_detail');
        Schema::dropIfExists('marketing_penjualan');
    }
};
