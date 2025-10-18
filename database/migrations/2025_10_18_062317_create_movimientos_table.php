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
        if (!Schema::hasTable('movimientos')) {
            Schema::create('movimientos', function (Blueprint $table) {
                $table->id('MovimientoID');
                $table->dateTime('FechaMovimiento')->useCurrent();
                $table->string('Descripcion', 200)->nullable();
                $table->enum('TipoMovimiento', ['Ingreso', 'Egreso']);
                $table->decimal('Monto', 14, 2);
                $table->enum('TipoEntrada', ['Membresia', 'Donacion', 'PagoDistrito'])->nullable();
                $table->enum('CategoriaEgreso', ['Compra', 'PagoProveedor', 'GastoOperativo', 'Otro'])->nullable();
                $table->unsignedBigInteger('MiembroID')->nullable();
                $table->unsignedBigInteger('ProyectoID')->nullable();
                $table->unsignedBigInteger('PagoID')->nullable();
                
                $table->foreign('MiembroID')->references('MiembroID')->on('miembros')->onDelete('set null');
                $table->foreign('ProyectoID')->references('ProyectoID')->on('proyectos')->onDelete('set null');
                $table->foreign('PagoID')->references('PagoID')->on('pagosmembresia')->onDelete('set null');
                
                $table->index(['FechaMovimiento', 'TipoMovimiento']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
