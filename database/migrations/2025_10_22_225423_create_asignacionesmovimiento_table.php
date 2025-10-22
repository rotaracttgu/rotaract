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
        Schema::create('asignacionesmovimiento', function (Blueprint $table) {
            $table->integer('AsignacionID', true);
            $table->integer('MovimientoID');
            $table->integer('ProyectoID')->index('ix_asigmov_proyecto');
            $table->decimal('MontoAsignado', 12);

            $table->unique(['MovimientoID', 'ProyectoID'], 'ux_asigmov');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacionesmovimiento');
    }
};
