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
        Schema::create('notas_personales', function (Blueprint $table) {
            $table->integer('NotaID', true);
            $table->integer('MiembroID')->index('fk_notas_miembro');
            $table->string('Titulo', 200);
            $table->text('Contenido')->nullable();
            $table->enum('Categoria', ['proyecto', 'reunion', 'capacitacion', 'idea', 'personal'])->default('personal')->index('ix_notas_categoria');
            $table->enum('Visibilidad', ['privada', 'publica'])->default('privada')->index('ix_notas_visibilidad');
            $table->string('Etiquetas', 500)->nullable();
            $table->dateTime('FechaCreacion')->useCurrent()->index('ix_notas_fecha_creacion');
            $table->dateTime('FechaActualizacion')->useCurrentOnUpdate()->nullable();
            $table->dateTime('FechaRecordatorio')->nullable()->index('ix_notas_recordatorio');
            $table->enum('Estado', ['activa', 'archivada', 'eliminada'])->default('activa')->index('ix_notas_estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas_personales');
    }
};
