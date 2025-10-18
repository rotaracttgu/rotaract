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
        if (!Schema::hasTable('asignacionesmovimiento')) {
            Schema::create('asignacionesmovimiento', function (Blueprint $table) {
                $table->id('AsignacionID');
                $table->unsignedBigInteger('MovimientoID');
                $table->unsignedInteger('ProyectoID');
                $table->decimal('MontoAsignado', 12, 2);
                
                $table->foreign('MovimientoID')->references('MovimientoID')->on('movimientos')->onDelete('cascade');
                $table->foreign('ProyectoID')->references('ProyectoID')->on('proyectos')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacionesmovimiento');
    }
};
