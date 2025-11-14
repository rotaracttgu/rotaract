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
        Schema::create('pagosmembresia', function (Blueprint $table) {
            $table->integer('PagoID', true);
            $table->integer('MiembroID');
            $table->date('FechaPago');
            $table->decimal('Monto', 12);
            $table->string('MetodoPago', 50)->nullable();
            $table->string('EstadoPago', 20)->nullable();
            $table->string('PeriodoPago', 20)->nullable()->index('ix_pagos_periodo');

            $table->index(['MiembroID', 'FechaPago'], 'ix_pagos_miembro');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagosmembresia');
    }
};
