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
        Schema::create('carta_patrocinios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('numero_carta');
            $table->string('destinatario');
            $table->text('descripcion');
            $table->decimal('monto_solicitado', 10)->nullable();
            $table->enum('estado', ['Pendiente', 'Aprobada', 'Rechazada', 'En Revision'])->default('Pendiente');
            $table->date('fecha_solicitud');
            $table->date('fecha_respuesta')->nullable();
            $table->unsignedBigInteger('proyecto_id')->nullable();
            $table->unsignedBigInteger('usuario_id');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carta_patrocinios');
    }
};
