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
        if (!Schema::hasTable('pagosmembresia')) {
            Schema::create('pagosmembresia', function (Blueprint $table) {
                $table->id('PagoID');
                $table->unsignedBigInteger('MiembroID');
                $table->date('FechaPago');
                $table->decimal('Monto', 12, 2);
                $table->string('MetodoPago', 50)->nullable();
                $table->string('EstadoPago', 20)->nullable();
                $table->string('PeriodoPago', 20)->nullable();
                
                $table->foreign('MiembroID')->references('MiembroID')->on('miembros')->onDelete('cascade');
                $table->index('MiembroID');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagosmembresia');
    }
};
