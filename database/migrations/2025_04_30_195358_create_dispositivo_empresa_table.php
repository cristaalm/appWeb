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
        Schema::create('dispositivo_empresa', function (Blueprint $table) {
            $table->id('id_dispositivo_empresa');
            $table->unsignedBigInteger('id_empresa');
            $table->unsignedBigInteger('id_dispositivo');
            $table->foreign('id_empresa')->references('id_empresa')->on('empresa');
            $table->foreign('id_dispositivo')->references('id_dispositivo')->on('dispositivos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispositivo_empresa');
    }
};
