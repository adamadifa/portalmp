<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembelian_historibayar', function (Blueprint $table) {
            $table->renameColumn('no_kontrabon', 'no_bukti');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembelian_historibayar', function (Blueprint $table) {
            $table->renameColumn('no_bukti', 'no_kontrabon');
        });
    }
};
