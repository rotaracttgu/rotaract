<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bitacora_sistema', function (Blueprint $table) {
            $table->id('BitacoraID');
            
            // Usuario que realizó la acción
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('usuario_nombre', 100)->nullable();
            $table->string('usuario_email', 100)->nullable();
            $table->string('usuario_rol', 50)->nullable();
            
            // Información de la acción
            $table->enum('accion', [
                'login',
                'logout', 
                'login_fallido',
                'registro',
                'cambio_password',
                'verificacion_2fa',
                'create',
                'update',
                'delete',
                'restore',
                'view',
                'export',
                'import'
            ]);
            
            $table->string('modulo', 100); // usuarios, proyectos, asistencias, etc.
            $table->string('tabla', 100)->nullable();
            $table->unsignedBigInteger('registro_id')->nullable();
            $table->text('descripcion');
            
            // Datos del cambio (JSON)
            $table->json('datos_anteriores')->nullable();
            $table->json('datos_nuevos')->nullable();
            
            // Información técnica
            $table->string('ip_address', 45);
            $table->string('user_agent', 255)->nullable();
            $table->string('url', 255)->nullable();
            $table->string('metodo_http', 10)->nullable();
            
            // Contexto adicional
            $table->enum('estado', ['exitoso', 'fallido', 'pendiente'])->default('exitoso');
            $table->text('error_mensaje')->nullable();
            $table->json('metadata')->nullable();
            
            $table->timestamp('fecha_hora')->useCurrent();
            
            // Índices para búsqueda rápida
            $table->index('user_id');
            $table->index('accion');
            $table->index('modulo');
            $table->index('fecha_hora');
            $table->index(['user_id', 'accion', 'fecha_hora']);
            
            // Foreign key
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bitacora_sistema');
    }
};