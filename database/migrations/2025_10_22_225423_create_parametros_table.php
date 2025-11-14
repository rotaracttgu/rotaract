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
        Schema::create('parametros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('clave')->unique()->comment('Clave única del parámetro');
            $table->string('valor')->comment('Valor del parámetro');
            $table->string('descripcion')->nullable()->comment('Descripción del parámetro');
            $table->string('tipo')->default('string')->comment('Tipo de dato: string, integer, boolean');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametros');
    }
};
