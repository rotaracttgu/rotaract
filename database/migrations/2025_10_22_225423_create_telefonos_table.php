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
        Schema::create('telefonos', function (Blueprint $table) {
            $table->integer('TelefonoID', true);
            $table->integer('MiembroID');
            $table->string('Numero', 20);
            $table->enum('TipoTelefono', ['Movil', 'Casa', 'Trabajo', 'Otro'])->default('Movil');

            $table->index(['MiembroID', 'TipoTelefono'], 'ix_telefonos_miembro');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telefonos');
    }
};
