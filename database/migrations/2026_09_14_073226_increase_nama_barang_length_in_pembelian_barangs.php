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
        Schema::table('pembelian_barang', function (Blueprint $table) {
            $table->string('nama_barang', 255)->change();
        });

        Schema::table('supplier', function (Blueprint $table) {
            $table->string('nama_supplier', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembelian_barang', function (Blueprint $table) {
            $table->string('nama_barang', 100)->change();
        });

        Schema::table('supplier', function (Blueprint $table) {
            $table->string('nama_supplier', 100)->change();
        });
    }
};
