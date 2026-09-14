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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::table('biaya', function (Blueprint $table) {
            $table->string('no_bukti', 50)->change();
        });
        Schema::table('biaya_detail', function (Blueprint $table) {
            $table->string('no_bukti', 50)->change();
        });
        Schema::table('biaya_historibayar', function (Blueprint $table) {
            $table->string('no_bukti', 50)->change();
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::table('biaya', function (Blueprint $table) {
            $table->char('no_bukti', 20)->change();
        });
        Schema::table('biaya_detail', function (Blueprint $table) {
            $table->char('no_bukti', 20)->change();
        });
        Schema::table('biaya_historibayar', function (Blueprint $table) {
            $table->char('no_bukti', 20)->change();
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
