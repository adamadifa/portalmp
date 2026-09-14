<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Drop foreign keys referencing biaya(no_bukti)
        Schema::table('biaya_detail', function (Blueprint $table) {
            $table->dropForeign(['no_bukti']);
        });

        Schema::table('biaya_historibayar', function (Blueprint $table) {
            $table->dropForeign(['no_bukti']);
        });

        // 2. Change column lengths
        Schema::table('biaya', function (Blueprint $table) {
            $table->string('no_bukti', 50)->change();
        });

        Schema::table('biaya_detail', function (Blueprint $table) {
            $table->string('no_bukti', 50)->change();
        });

        Schema::table('biaya_historibayar', function (Blueprint $table) {
            $table->string('no_bukti', 50)->change();
        });

        // 3. Re-add foreign keys
        Schema::table('biaya_detail', function (Blueprint $table) {
            $table->foreign('no_bukti')->references('no_bukti')->on('biaya')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('biaya_historibayar', function (Blueprint $table) {
            $table->foreign('no_bukti')->references('no_bukti')->on('biaya')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('biaya_detail', function (Blueprint $table) {
            $table->dropForeign(['no_bukti']);
        });

        Schema::table('biaya_historibayar', function (Blueprint $table) {
            $table->dropForeign(['no_bukti']);
        });

        Schema::table('biaya', function (Blueprint $table) {
            $table->char('no_bukti', 20)->change();
        });

        Schema::table('biaya_detail', function (Blueprint $table) {
            $table->char('no_bukti', 20)->change();
        });

        Schema::table('biaya_historibayar', function (Blueprint $table) {
            $table->char('no_bukti', 20)->change();
        });

        Schema::table('biaya_detail', function (Blueprint $table) {
            $table->foreign('no_bukti')->references('no_bukti')->on('biaya')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('biaya_historibayar', function (Blueprint $table) {
            $table->foreign('no_bukti')->references('no_bukti')->on('biaya')->onDelete('cascade')->onUpdate('cascade');
        });
    }
};

