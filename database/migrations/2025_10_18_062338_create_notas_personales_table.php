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
        if (!Schema::hasTable('notas_personales')) {
            Schema::create('notas_personales', function (Blueprint $table) {
                $table->id('NotaID');
                $table->unsignedInteger('MiembroID');
                $table->string('Titulo', 200);
                $table->text('Contenido')->nullable();
                $table->enum('Categoria', ['proyecto', 'reunion', 'capacitacion', 'idea', 'personal'])->default('personal');
                $table->enum('Visibilidad', ['privada', 'publica'])->default('privada');
                $table->string('Etiquetas', 500)->nullable();
                $table->dateTime('FechaCreacion')->useCurrent();
                $table->dateTime('FechaActualizacion')->nullable()->useCurrentOnUpdate();
                $table->dateTime('FechaRecordatorio')->nullable();
                $table->enum('Estado', ['activa', 'archivada', 'eliminada'])->default('activa');
                
                $table->foreign('MiembroID')->references('MiembroID')->on('miembros')->onDelete('cascade');
                $table->index('MiembroID');
                $table->index('Estado');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas_personales');
    }
};
