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
        Schema::create('gudang_jadi_mutasi', function (Blueprint $table) {
            $table->char('no_mutasi', 25)->primary();
            $table->date('tanggal');
            $table->string('no_dok', 30)->nullable();
            $table->char('no_permintaan', 18)->nullable();
            $table->char('in_out', 1);
            $table->char('jenis_mutasi', 2); // SJ, FS, etc.
            $table->text('keterangan')->nullable();
            $table->char('status_surat_jalan', 1)->nullable();
            $table->bigInteger('id_user');
            $table->timestamps();
        });

        Schema::create('gudang_jadi_mutasi_detail', function (Blueprint $table) {
            $table->char('no_mutasi', 25);
            $table->char('kode_produk', 6);
            $table->integer('jumlah');
            $table->foreign('no_mutasi')->references('no_mutasi')->on('gudang_jadi_mutasi')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gudang_jadi_mutasi_detail');
        Schema::dropIfExists('gudang_jadi_mutasi');
    }
};
