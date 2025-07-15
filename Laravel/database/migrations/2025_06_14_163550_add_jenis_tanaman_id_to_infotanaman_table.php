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
        Schema::table('infotanaman', function (Blueprint $table) {
            $table->unsignedBigInteger('jenis_tanaman_id')->nullable()->after('nama');
            $table->foreign('jenis_tanaman_id')->references('id')->on('jenis_tanaman')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('infotanaman', function (Blueprint $table) {
            //
        });
    }
};
