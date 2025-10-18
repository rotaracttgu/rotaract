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
        if (!Schema::hasTable('documentos')) {
            Schema::create('documentos', function (Blueprint $table) {
                $table->id('DocumentoID');
                $table->enum('TipoDocumento', ['Acta', 'Carta', 'Diploma', 'Otro'])->default('Acta');
                $table->string('Titulo', 200)->nullable();
                $table->string('RutaArchivo', 255)->nullable();
                $table->date('FechaSubida')->nullable();
                $table->date('FechaEmision')->nullable();
                $table->string('Autor', 100)->nullable();
                $table->integer('NumeroPaginas')->nullable();
                $table->unsignedBigInteger('MiembroID')->nullable();
                $table->unsignedInteger('ProyectoID')->nullable();
                
                $table->foreign('MiembroID')->references('MiembroID')->on('miembros')->onDelete('set null');
                $table->foreign('ProyectoID')->references('ProyectoID')->on('proyectos')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
