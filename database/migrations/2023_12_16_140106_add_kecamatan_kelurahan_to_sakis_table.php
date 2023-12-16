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
        Schema::table('saksi', function (Blueprint $table) {
               // Tambahkan kolom kecamatan_id dan kelurahan_id
               $table->unsignedBigInteger('kecamatan_id')->nullable();
               $table->unsignedBigInteger('kelurahan_id')->nullable();
   
               // Hapus kolom kecamatan dan kelurahan jika sudah ada
               $table->dropColumn('kecamatan');
               $table->dropColumn('kelurahan');
   
               // Tambahkan foreign key kecamatan_id
               $table->foreign('kecamatan_id')->references('id')->on('kecamatan')->onDelete('set null');
   
               // Tambahkan foreign key kelurahan_id
               $table->foreign('kelurahan_id')->references('id')->on('kelurahan')->onDelete('set null');
           });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sakis', function (Blueprint $table) {
            //
        });
    }
};
