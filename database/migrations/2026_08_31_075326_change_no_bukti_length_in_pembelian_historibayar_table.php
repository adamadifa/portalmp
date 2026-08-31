<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembelian_historibayar', function (Blueprint $table) {
            $table->dropForeign('pembelian_historibayar_no_kontrabon_foreign');
            $table->char('no_bukti', 21)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembelian_historibayar', function (Blueprint $table) {
            $table->char('no_bukti', 13)->change();
            $table->foreign('no_bukti', 'pembelian_historibayar_no_kontrabon_foreign')
                ->references('no_kontrabon')
                ->on('pembelian_kontrabon')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
        });
    }
};
