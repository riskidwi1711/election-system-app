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
        Schema::create('suara', function (Blueprint $table) {
            $table->id();
            $table->foreignId('saksi_id')->constrained('saksi', 'id');
            $table->foreignId('calon_presiden_id')->constrained('calon_presiden', 'id');
            $table->integer('suara_sah')->default(0);
            $table->integer('suara_tidak_sah')->default(0);
            $table->integer('suara_sisa')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suara');
    }
};
