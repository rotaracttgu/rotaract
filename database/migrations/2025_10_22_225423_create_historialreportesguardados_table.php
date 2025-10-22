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
        Schema::create('historialreportesguardados', function (Blueprint $table) {
            $table->integer('HistorialGuardadoID', true);
            $table->integer('ReporteGuardadoID');
            $table->unsignedBigInteger('UsuarioID')->nullable();
            $table->enum('Accion', ['CREACION', 'ACTUALIZACION', 'CAMBIO_ESTADO', 'ELIMINACION']);
            $table->dateTime('FechaEvento')->useCurrent();
            $table->string('NombreSnapshot', 100)->nullable();
            $table->text('DescripcionSnapshot')->nullable();
            $table->json('FiltrosSnapshotJSON')->nullable();
            $table->string('EstadoSnapshot', 20)->nullable();

            $table->index(['ReporteGuardadoID', 'FechaEvento'], 'ix_histrepg_repg');
            $table->index(['UsuarioID', 'FechaEvento'], 'ix_histrepg_usr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historialreportesguardados');
    }
};
