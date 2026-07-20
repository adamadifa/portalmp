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
        Schema::create('produk', function (Blueprint $table) {
            $table->char('kode_produk', 6)->primary();
            $table->string('nama_produk', 30);
            $table->string('satuan', 4);
            $table->smallInteger('isi_pcs_dus');
            $table->smallInteger('isi_pack_dus');
            $table->smallInteger('isi_pcs_pack');
            $table->char('kode_kategori_produk', 3);
            $table->char('kode_jenis_produk', 3);
            $table->char('status_aktif_produk', 1);
            $table->smallInteger('urutan')->nullable();
            $table->timestamps();

            $table->foreign('kode_kategori_produk')
                  ->references('kode_kategori_produk')
                  ->on('produk_kategori')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('kode_jenis_produk')
                  ->references('kode_jenis_produk')
                  ->on('produk_jenis')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
