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
       Schema::create('infotanaman', function (Blueprint $table) {
        $table->increments('Id_Tanaman');
        $table->string('Nama', 255)->unique();
        $table->string('Gambar', 100)->nullable();
        $table->string('Klasifikasi', 255);
        $table->text('Deskripsi');
        $table->timestamps();
        $table->foreign('jenis_tanaman_id')->references('id')->on('jenis_tanaman');
       });

       Schema::create('infohama', function (Blueprint $table) {
        $table->increments('Id_Hama');
        $table->string('Nama', 255)->unique();
        $table->string('Gambar', 100)->nullable();
        $table->string('Klasifikasi', 255);
        $table->text('Deskripsi');
        $table->timestamps();
       });
     
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infotanaman');
        Schema::dropIfExists('infohama');
    }
};
