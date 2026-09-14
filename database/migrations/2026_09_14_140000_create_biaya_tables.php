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
        // 1. Header Table: biaya
        if (!Schema::hasTable('biaya')) {
            Schema::create('biaya', function (Blueprint $table) {
                $table->char('no_bukti', 20)->primary();
                $table->date('tanggal');
                $table->char('kode_supplier', 6)->nullable();
                $table->char('kode_asal_pengajuan', 3)->nullable();
                $table->char('kode_akun', 10)->nullable();
                $table->char('ppn', 1)->default('0');
                $table->string('no_fak_pajak', 30)->nullable();
                $table->date('tanggal_jatuh_tempo')->nullable();
                $table->char('jenis_transaksi', 1)->default('T'); // T: Tunai, K: Kredit
                $table->char('kategori_transaksi', 3)->nullable(); // MP, PC, PB, IP
                $table->text('keterangan')->nullable();
                $table->bigInteger('id_user');
                $table->timestamps();

                $table->index('tanggal');
                $table->index('kode_supplier');
            });
        }

        // 2. Detail Table: biaya_detail
        if (!Schema::hasTable('biaya_detail')) {
            Schema::create('biaya_detail', function (Blueprint $table) {
                $table->id();
                $table->char('no_bukti', 20);
                $table->char('kode_akun', 10);
                $table->string('keterangan')->nullable();
                $table->double('jumlah', 10, 2)->default(1);
                $table->double('harga', 15, 2)->default(0);
                $table->double('penyesuaian', 15, 2)->default(0);
                $table->char('kode_cabang', 3)->nullable();
                $table->char('kode_transaksi', 3)->default('BYA');
                $table->timestamps();

                $table->foreign('no_bukti')->references('no_bukti')->on('biaya')->onDelete('cascade')->onUpdate('cascade');
                $table->index('no_bukti');
                $table->index('kode_akun');
            });
        }

        // 3. Payment History Table: biaya_historibayar
        if (!Schema::hasTable('biaya_historibayar')) {
            Schema::create('biaya_historibayar', function (Blueprint $table) {
                $table->id();
                $table->char('no_bukti', 20);
                $table->date('tanggal');
                $table->double('jumlah', 15, 2);
                $table->char('kode_bank', 5);
                $table->char('kode_cabang', 3)->nullable();
                $table->string('keterangan')->nullable();
                $table->bigInteger('id_user');
                $table->timestamps();

                $table->foreign('no_bukti')->references('no_bukti')->on('biaya')->onDelete('cascade')->onUpdate('cascade');
                $table->index('no_bukti');
                $table->index('kode_bank');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biaya_historibayar');
        Schema::dropIfExists('biaya_detail');
        Schema::dropIfExists('biaya');
    }
};
