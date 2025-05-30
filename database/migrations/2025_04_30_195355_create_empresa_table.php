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
        Schema::create('empresa', function (Blueprint $table) {
            $table->id('id_empresa');
            $table->string('razon_social', 100)->notNullable();
            $table->string('nombre_comercial', 100)->notNullable();
            $table->string('rfc', 20)->nullable();
            $table->string('telefono', 15)->nullable();
            $table->string('logotipo', 255)->nullable();
            $table->timestamp('fecha_ingreso')->notNullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa');
    }
};
