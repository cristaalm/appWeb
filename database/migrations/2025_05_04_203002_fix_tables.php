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
        Schema::table('dispositivos', function (Blueprint $table) {
            $table->dropColumn('sync');
            $table->decimal('valor_maximo', 10, 2)->nullable();
            $table->decimal('valor_minimo', 10, 2)->nullable();
        });
        Schema::table('historiales', function (Blueprint $table) {
            $table->dropColumn('sync');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dispositivos', function (Blueprint $table) {
            $table->tinyInteger('sync')->notNullable()->default(0);
            $table->dropColumn('valor_maximo');
            $table->dropColumn('valor_minimo');
        });
        Schema::table('historiales', function (Blueprint $table) {
            $table->tinyInteger('sync')->notNullable()->default(0);
        });
    }
};
