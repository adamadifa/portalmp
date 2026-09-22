<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('accounting_jurnalumum', function (Blueprint $table) {
            $table->string('no_bukti', 20)->nullable()->after('kode_ju')->index();
        });
    }

    public function down(): void
    {
        Schema::table('accounting_jurnalumum', function (Blueprint $table) {
            $table->dropColumn('no_bukti');
        });
    }
};
