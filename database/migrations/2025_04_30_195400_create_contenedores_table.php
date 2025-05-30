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
        Schema::create('contenedores', function (Blueprint $table) {
            $table->id('id_contenedor');
            $table->unsignedInteger('id_empresa')->index();
            $table->unsignedInteger('id_dispositivo')->index();
            $table->string('nombre', 255)->notNullable();
            $table->primary('id_contenedor');
            $table->foreign('id_empresa')->references('id_empresa')->on('empresa');
            $table->foreign('id_dispositivo')->references('id_dispositivo')->on('dispositivos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contenedores');
    }
};
