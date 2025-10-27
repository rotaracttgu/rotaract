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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->integer('MovimientoID', true);
            $table->dateTime('FechaMovimiento')->useCurrent();
            $table->string('Descripcion', 200)->nullable();
            $table->enum('TipoMovimiento', ['Ingreso', 'Egreso'])->index('ix_mov_tipo');
            $table->decimal('Monto', 14);
            $table->enum('TipoEntrada', ['Membresia', 'Donacion', 'PagoDistrito'])->nullable();
            $table->enum('CategoriaEgreso', ['Compra', 'PagoProveedor', 'GastoOperativo', 'Otro'])->nullable();
            $table->integer('MiembroID')->nullable()->index('miembroid');
            $table->integer('ProyectoID')->nullable();
            $table->integer('PagoID')->nullable()->index('pagoid');

            $table->index(['FechaMovimiento', 'MovimientoID'], 'ix_mov_fecha');
            $table->index(['ProyectoID', 'MiembroID', 'PagoID'], 'ix_mov_rel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
