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
        Schema::create('bitacora_sistema', function (Blueprint $table) {
            $table->bigIncrements('BitacoraID');
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('usuario_nombre', 100)->nullable();
            $table->string('usuario_email', 100)->nullable();
            $table->string('usuario_rol', 50)->nullable();
            $table->enum('accion', ['login', 'logout', 'login_fallido', 'registro', 'cambio_password', 'verificacion_2fa', 'create', 'update', 'delete', 'restore', 'view', 'export', 'import', 'test'])->index();
            $table->string('modulo', 100)->index();
            $table->string('tabla', 100)->nullable();
            $table->unsignedBigInteger('registro_id')->nullable();
            $table->text('descripcion');
            $table->json('datos_anteriores')->nullable();
            $table->json('datos_nuevos')->nullable();
            $table->string('ip_address', 45);
            $table->string('user_agent')->nullable();
            $table->string('url')->nullable();
            $table->string('metodo_http', 10)->nullable();
            $table->enum('estado', ['exitoso', 'fallido', 'pendiente'])->default('exitoso');
            $table->text('error_mensaje')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('fecha_hora')->useCurrent()->index();

            $table->index(['user_id', 'accion', 'fecha_hora']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacora_sistema');
    }
};
