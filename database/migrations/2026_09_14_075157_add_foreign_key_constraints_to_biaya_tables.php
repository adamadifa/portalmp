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
        Schema::table('biaya', function (Blueprint $table) {
            $table->foreign('kode_supplier')->references('kode_supplier')->on('supplier')->nullOnDelete()->cascadeOnUpdate();
        });

        Schema::table('biaya_detail', function (Blueprint $table) {
            $table->foreign('kode_akun')->references('kode_akun')->on('coa')->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('biaya_detail', function (Blueprint $table) {
            $table->dropForeign(['kode_akun']);
        });

        Schema::table('biaya', function (Blueprint $table) {
            $table->dropForeign(['kode_supplier']);
        });
    }
};
