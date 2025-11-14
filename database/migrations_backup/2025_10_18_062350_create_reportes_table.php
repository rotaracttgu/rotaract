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
        if (!Schema::hasTable('reportes')) {
            Schema::create('reportes', function (Blueprint $table) {
                $table->id('ReporteID');
                $table->unsignedBigInteger('CalendarioID')->nullable();
                $table->string('TipoReporte', 50);
                $table->dateTime('FechaGeneracion')->useCurrent();
                $table->string('RutaArchivo', 255)->nullable();
                $table->text('Resumen')->nullable();
                
                $table->foreign('CalendarioID')->references('CalendarioID')->on('calendarios')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
