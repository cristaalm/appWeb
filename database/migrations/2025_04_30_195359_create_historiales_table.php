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
        Schema::create('historiales', function (Blueprint $table) {
            $table->id('id_historial');
            $table->unsignedInteger('id_empresa')->index();
            $table->unsignedInteger('id_dispositivo')->index();
            $table->decimal('valor', 10, 2);
            $table->timestamp('fecha_ingreso');
            $table->unsignedTinyInteger('sync')->default(0);
            $table->primary('id_historial');
            $table->foreign('id_empresa')->references('id_empresa')->on('empresa');
            $table->foreign('id_dispositivo')->references('id_dispositivo')->on('dispositivos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historiales');
    }
};
