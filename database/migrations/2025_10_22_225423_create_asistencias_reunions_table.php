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
        Schema::create('asistencias_reunions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reunion_id');
            $table->unsignedBigInteger('usuario_id')->index('asistencias_reunions_usuario_id_foreign');
            $table->boolean('asistio')->default(false);
            $table->time('hora_llegada')->nullable();
            $table->enum('tipo_asistencia', ['Presente', 'Ausente', 'Justificada', 'Tardanza'])->default('Ausente');
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->unique(['reunion_id', 'usuario_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias_reunions');
    }
};
