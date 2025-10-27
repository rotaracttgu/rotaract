<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tabla principal de backups
        Schema::create('backups', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_archivo');
            $table->string('tipo', 50)->default('manual');
            $table->string('ruta_archivo');
            $table->string('tamaño')->nullable();
            $table->enum('estado', ['completado', 'en_proceso', 'fallido'])->default('en_proceso');
            $table->text('descripcion')->nullable();
            $table->text('error_mensaje')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->timestamp('fecha_ejecucion')->useCurrent();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->index('estado');
            $table->index('tipo');
        });

        // Tabla de configuración de backups automáticos
        Schema::create('backup_configuraciones', function (Blueprint $table) {
            $table->id();
            $table->enum('frecuencia', ['diario', 'semanal', 'mensual']);
            $table->time('hora_programada');
            $table->boolean('activo')->default(true);
            $table->string('dias_semana')->nullable();
            $table->integer('dia_mes')->nullable();
            $table->timestamp('ultima_ejecucion')->nullable();
            $table->timestamp('proxima_ejecucion')->nullable();
            $table->timestamps();
        });

        // Tabla de logs de backup
        Schema::create('backup_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('backup_id')->constrained('backups')->onDelete('cascade');
            $table->string('tipo_log');
            $table->text('mensaje');
            $table->timestamp('fecha_log')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('backup_logs');
        Schema::dropIfExists('backup_configuraciones');
        Schema::dropIfExists('backups');
    }
};