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
        Schema::create('hrd_group', function (Blueprint $table) {
            $table->char('kode_group', 3)->primary();
            $table->string('nama_group', 50);
            $table->char('kode_dept', 3);
            $table->foreign('kode_dept')->references('kode_dept')->on('hrd_departemen')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrd_group');
    }
};
