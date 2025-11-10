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
        Schema::create('auditoria_movimientos', function (Blueprint $table) {
            $table->id('id')->comment('ID único del registro de auditoría');
            
            // IDENTIFICACIÓN DEL CAMBIO
            $table->string('tabla_origen', 100)->comment('Nombre de la tabla donde se realizó el cambio');
            $table->unsignedBigInteger('registro_id')->comment('ID del registro afectado en la tabla origen');
            $table->enum('accion', ['insert', 'update', 'delete'])
                ->comment('Tipo de acción realizada');
            
            // USUARIO Y TIMESTAMP
            $table->unsignedBigInteger('usuario_id')->nullable()->comment('FK a tabla users - Usuario que realizó el cambio');
            $table->timestamp('fecha_accion')->useCurrent()->comment('Momento exacto del cambio');
            
            // INFORMACIÓN DEL CAMBIO
            $table->json('datos_anteriores')->nullable()->comment('JSON con valores anteriores del registro (NULL para INSERT)');
            $table->json('datos_nuevos')->nullable()->comment('JSON con nuevos valores del registro');
            $table->text('cambios_detectados')->nullable()->comment('Descripción textual de qué cambió');
            
            // CONTEXTO Y RASTREO
            $table->string('ip_address', 45)->nullable()->comment('Dirección IP del usuario que realizó el cambio');
            $table->text('user_agent')->nullable()->comment('User Agent del navegador que realizó el cambio');
            $table->string('url_origen', 500)->nullable()->comment('URL desde la que se realizó la acción');
            $table->text('notas_adicionales')->nullable()->comment('Notas adicionales para auditoría');
            
            // TIMESTAMPS (cuando se registró en auditoría)
            $table->timestamp('created_at')->useCurrent()->comment('Cuándo se registró este evento de auditoría');
            
            // DEFINICIÓN DE CLAVE PRIMARIA
            $table->primary('id');
            
            // ÍNDICES PARA BÚSQUEDA Y ANÁLISIS RÁPIDO
            $table->index('tabla_origen')->comment('Filtrar cambios por tabla específica');
            $table->index('registro_id')->comment('Buscar historial de un registro específico');
            $table->index('accion')->comment('Filtrar por tipo de acción (INSERT/UPDATE/DELETE)');
            $table->index('usuario_id')->comment('Ver cambios realizados por un usuario');
            $table->index('fecha_accion')->comment('Búsqueda por rango de fechas');
            $table->index(['tabla_origen', 'registro_id'])->comment('Historial completo de un registro específico');
            $table->index(['usuario_id', 'fecha_accion'])->comment('Auditoría por usuario en período');
            $table->index(['tabla_origen', 'accion', 'fecha_accion'])->comment('Análisis de cambios por tabla y tipo');
            
            // FOREIGN KEY
            if (Schema::hasTable('users')) {
                $table->foreign('usuario_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('set null')
                    ->onUpdate('cascade');
            }
        });

        // CREAR ÍNDICE FULLTEXT PARA BÚSQUEDAS TEXTUALES (opcional, pero muy útil)
        // Se puede descomentar si se desea búsqueda fulltext en cambios_detectados
        // DB::statement('ALTER TABLE auditoria_movimientos ADD FULLTEXT INDEX ft_cambios (cambios_detectados)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditoria_movimientos');
    }
};
