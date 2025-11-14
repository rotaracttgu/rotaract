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
        Schema::create('reportes', function (Blueprint $table) {
            $table->integer('ReporteID', true);
            $table->integer('CalendarioID')->nullable()->index('agendaid');
            $table->string('TipoReporte', 50);
            $table->dateTime('FechaGeneracion')->useCurrent();
            $table->string('RutaArchivo')->nullable();
            $table->text('Resumen')->nullable();

            $table->index(['TipoReporte', 'FechaGeneracion'], 'ix_reportes_tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
