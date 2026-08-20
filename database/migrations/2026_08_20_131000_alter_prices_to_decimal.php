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
        Schema::table('produk_harga', function (Blueprint $table) {
            $table->decimal('harga', 15, 2)->change();
        });

        Schema::table('marketing_penjualan_detail', function (Blueprint $table) {
            $table->decimal('harga_dus', 15, 2)->change();
            $table->decimal('subtotal', 20, 2)->change();
        });

        Schema::table('marketing_penjualan_historibayar', function (Blueprint $table) {
            $table->decimal('jumlah', 20, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk_harga', function (Blueprint $table) {
            $table->integer('harga')->change();
        });

        Schema::table('marketing_penjualan_detail', function (Blueprint $table) {
            $table->integer('harga_dus')->change();
            $table->bigInteger('subtotal')->change();
        });

        Schema::table('marketing_penjualan_historibayar', function (Blueprint $table) {
            $table->bigInteger('jumlah')->change();
        });
    }
};
