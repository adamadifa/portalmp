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
        if (!Schema::hasTable('bukubesar_saldoawal')) {
            Schema::create('bukubesar_saldoawal', function (Blueprint $table) {
                $table->string('kode_saldo_awal', 15)->primary();
                $table->date('tanggal');
                $table->smallInteger('bulan');
                $table->char('tahun', 4);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('bukubesar_saldoawal_detail')) {
            Schema::create('bukubesar_saldoawal_detail', function (Blueprint $table) {
                $table->id();
                $table->string('kode_saldo_awal', 15);
                $table->string('kode_akun', 10);
                $table->double('jumlah', 18, 2)->default(0);
                $table->timestamps();

                $table->foreign('kode_saldo_awal')
                    ->references('kode_saldo_awal')
                    ->on('bukubesar_saldoawal')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();

                $table->foreign('kode_akun')
                    ->references('kode_akun')
                    ->on('coa')
                    ->restrictOnDelete()
                    ->cascadeOnUpdate();

                $table->index('kode_saldo_awal');
                $table->index('kode_akun');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukubesar_saldoawal_detail');
        Schema::dropIfExists('bukubesar_saldoawal');
    }
};
