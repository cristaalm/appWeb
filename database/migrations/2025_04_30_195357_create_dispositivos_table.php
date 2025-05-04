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
        Schema::create('dispositivos', function (Blueprint $table) {
            $table->id('id_dispositivo');
            $table->string('nombre', 100)->notNullable();
            $table->boolean('requiere_contenedor')->nullable();
            $table->integer('tiempo_batido')->nullable();
            $table->tinyInteger('estado')->notNullable();
            $table->tinyInteger('sync')->notNullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispositivos');
    }
};
