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
        if (!Schema::hasTable('historialreportesguardados')) {
            Schema::create('historialreportesguardados', function (Blueprint $table) {
                $table->id('HistorialGuardadoID');
                $table->unsignedBigInteger('ReporteGuardadoID');
                $table->foreignId('UsuarioID')->nullable()->constrained('users')->onDelete('set null');
                $table->enum('Accion', ['CREACION', 'ACTUALIZACION', 'CAMBIO_ESTADO', 'ELIMINACION']);
                $table->dateTime('FechaEvento')->useCurrent();
                $table->string('NombreSnapshot', 100)->nullable();
                $table->text('DescripcionSnapshot')->nullable();
                $table->json('FiltrosSnapshotJSON')->nullable();
                $table->string('EstadoSnapshot', 20)->nullable();
                
                $table->foreign('ReporteGuardadoID')->references('ReporteGuardadoID')->on('reportesguardados')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historialreportesguardados');
    }
};
