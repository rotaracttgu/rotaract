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
        Schema::create('backup_configuraciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('frecuencia', ['diario', 'semanal', 'mensual']);
            $table->time('hora_programada');
            $table->boolean('activo')->default(true);
            $table->string('dias_semana')->nullable();
            $table->integer('dia_mes')->nullable();
            $table->timestamp('ultima_ejecucion')->nullable();
            $table->timestamp('proxima_ejecucion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backup_configuraciones');
    }
};
