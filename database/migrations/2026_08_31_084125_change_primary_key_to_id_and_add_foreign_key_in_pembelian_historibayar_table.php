<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE pembelian_historibayar DROP PRIMARY KEY, ADD id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY FIRST");
        DB::statement("ALTER TABLE pembelian_historibayar ADD CONSTRAINT fk_historibayar_pembelian FOREIGN KEY (no_bukti) REFERENCES pembelian(no_bukti) ON DELETE CASCADE ON UPDATE CASCADE");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE pembelian_historibayar DROP FOREIGN KEY fk_historibayar_pembelian");
        DB::statement("ALTER TABLE pembelian_historibayar DROP COLUMN id");
        DB::statement("ALTER TABLE pembelian_historibayar ADD PRIMARY KEY (no_bukti)");
    }
};
