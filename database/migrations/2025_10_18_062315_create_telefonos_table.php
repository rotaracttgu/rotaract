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
        if (!Schema::hasTable('telefonos')) {
            Schema::create('telefonos', function (Blueprint $table) {
                $table->id('TelefonoID');
                $table->unsignedInteger('MiembroID');
                $table->string('Numero', 20);
                $table->enum('TipoTelefono', ['Movil', 'Casa', 'Trabajo', 'Otro'])->default('Movil');
                
                $table->foreign('MiembroID')->references('MiembroID')->on('miembros')->onDelete('cascade');
                $table->index('MiembroID');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telefonos');
    }
};
