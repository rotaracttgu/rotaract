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
        Schema::create('documentos', function (Blueprint $table) {
            $table->integer('DocumentoID', true);
            $table->enum('TipoDocumento', ['Acta', 'Carta', 'Diploma', 'Otro'])->default('Acta');
            $table->string('Titulo', 200)->nullable();
            $table->string('RutaArchivo')->nullable();
            $table->date('FechaSubida')->nullable();
            $table->date('FechaEmision')->nullable();
            $table->string('Autor', 100)->nullable();
            $table->integer('NumeroPaginas')->nullable();
            $table->integer('MiembroID')->nullable();
            $table->integer('ProyectoID')->nullable()->index('proyectoid');

            $table->index(['MiembroID', 'ProyectoID', 'TipoDocumento'], 'ix_docs_rel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
