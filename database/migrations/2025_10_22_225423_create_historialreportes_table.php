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
        Schema::create('historialreportes', function (Blueprint $table) {
            $table->integer('HistorialReporteID', true);
            $table->integer('ReporteID');
            $table->unsignedBigInteger('UsuarioID')->nullable();
            $table->enum('Accion', ['CREACION', 'REGENERACION', 'EDICION', 'ELIMINACION']);
            $table->dateTime('FechaEvento')->useCurrent();
            $table->string('TituloSnapshot', 100)->nullable();
            $table->string('RutaArchivoSnapshot')->nullable();
            $table->text('ResumenSnapshot')->nullable();
            $table->json('MetadataJSON')->nullable();

            $table->index(['ReporteID', 'FechaEvento'], 'ix_histrep_rep');
            $table->index(['UsuarioID', 'FechaEvento'], 'ix_histrep_usr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historialreportes');
    }
};
