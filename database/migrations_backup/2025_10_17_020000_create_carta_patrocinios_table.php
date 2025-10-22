<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Solo crear si NO existe
        if (!Schema::hasTable('carta_patrocinios')) {
            Schema::create('carta_patrocinios', function (Blueprint $table) {
                $table->id();
                $table->string('numero_carta')->unique();
                $table->string('destinatario');
                $table->text('descripcion');
                $table->decimal('monto_solicitado', 10, 2)->nullable();
                $table->enum('estado', ['Pendiente', 'Aprobada', 'Rechazada', 'En Revision'])->default('Pendiente');
                $table->date('fecha_solicitud');
                $table->date('fecha_respuesta')->nullable();
                $table->unsignedInteger('proyecto_id')->nullable();
                $table->foreign('proyecto_id')->references('ProyectoID')->on('proyectos')->onDelete('set null');
                $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
                $table->text('observaciones')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('carta_patrocinios');
    }
};
