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
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->char('kode_pelanggan', 13)->primary();
            $table->date('tanggal_register');
            $table->string('nik', 255)->nullable();
            $table->string('no_kk', 255)->nullable();
            $table->string('nama_pelanggan', 100);
            $table->date('tanggal_lahir')->nullable();
            $table->string('alamat_pelanggan', 255)->nullable();
            $table->string('alamat_toko', 255)->nullable();
            $table->string('no_hp_pelanggan', 255)->nullable();
            $table->string('hari', 100)->nullable();
            $table->string('latitude', 30)->nullable();
            $table->string('longitude', 30)->nullable();
            $table->char('status_lokasi', 1)->nullable();
            $table->smallInteger('ljt')->nullable();
            $table->string('foto', 20)->nullable();
            $table->bigInteger('limit_pelanggan')->nullable();
            $table->char('status_aktif_pelanggan', 1)->default('1');
            $table->char('kode_cabang', 3);
            $table->char('kode_cabang_pkp', 3)->nullable();
            $table->timestamps();

            $table->foreign('kode_cabang')
                  ->references('kode_cabang')
                  ->on('cabang')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
