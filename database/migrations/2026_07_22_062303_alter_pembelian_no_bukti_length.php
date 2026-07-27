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
        // 1. Drop foreign key constraints
        try {
            Schema::table('pembelian_detail', function (Blueprint $table) {
                $table->dropForeign('pembelian_detail_no_bukti_foreign');
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('pembelian_kontrabon_detail', function (Blueprint $table) {
                $table->dropForeign('pembelian_kontrabon_detail_no_bukti_foreign');
            });
        } catch (\Exception $e) {}

        // 2. Change no_bukti column length in pembelian table
        Schema::table('pembelian', function (Blueprint $table) {
            $table->char('no_bukti', 21)->change();
        });

        // 3. Change no_bukti column length in pembelian_detail table
        Schema::table('pembelian_detail', function (Blueprint $table) {
            $table->char('no_bukti', 21)->change();
            
            // 4. Re-create foreign key constraint
            $table->foreign('no_bukti')->references('no_bukti')->on('pembelian')->cascadeOnDelete()->cascadeOnUpdate();
        });

        // 5. Change no_bukti column length in pembelian_kontrabon_detail table
        Schema::table('pembelian_kontrabon_detail', function (Blueprint $table) {
            $table->char('no_bukti', 21)->change();
            
            // 6. Re-create foreign key constraint
            $table->foreign('no_bukti')->references('no_bukti')->on('pembelian')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembelian_detail', function (Blueprint $table) {
            $table->dropForeign('pembelian_detail_no_bukti_foreign');
        });

        Schema::table('pembelian_kontrabon_detail', function (Blueprint $table) {
            $table->dropForeign('pembelian_kontrabon_detail_no_bukti_foreign');
        });

        Schema::table('pembelian', function (Blueprint $table) {
            $table->char('no_bukti', 17)->change();
        });

        Schema::table('pembelian_detail', function (Blueprint $table) {
            $table->char('no_bukti', 17)->change();
            $table->foreign('no_bukti')->references('no_bukti')->on('pembelian')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::table('pembelian_kontrabon_detail', function (Blueprint $table) {
            $table->char('no_bukti', 17)->change();
            $table->foreign('no_bukti')->references('no_bukti')->on('pembelian')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }
};
