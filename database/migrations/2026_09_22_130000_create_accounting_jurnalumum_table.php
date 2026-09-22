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
        if (!Schema::hasTable('accounting_jurnalumum')) {
            Schema::create('accounting_jurnalumum', function (Blueprint $table) {
                $table->string('kode_ju', 15)->primary();
                $table->date('tanggal')->nullable();
                $table->string('keterangan', 255)->nullable();
                $table->double('jumlah', 18, 2)->nullable();
                $table->char('debet_kredit', 1)->nullable(); // D: Debet, K: Kredit
                $table->string('kode_akun', 10);
                $table->string('kode_dept', 10)->nullable();
                $table->bigInteger('id_user')->nullable();
                $table->timestamps();

                $table->foreign('kode_akun')->references('kode_akun')->on('coa')->onUpdate('cascade');
                $table->index('tanggal');
                $table->index('kode_akun');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounting_jurnalumum');
    }
};
