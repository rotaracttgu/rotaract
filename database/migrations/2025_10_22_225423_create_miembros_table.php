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
        Schema::create('miembros', function (Blueprint $table) {
            $table->integer('MiembroID', true);
            $table->unsignedBigInteger('user_id')->nullable()->index('ix_miembros_user');
            $table->string('DNI_Pasaporte', 20)->nullable()->unique('ux_miembros_dni');
            $table->string('Nombre', 100);
            $table->string('Rol', 20)->nullable();
            $table->string('Correo', 100)->nullable();
            $table->date('FechaIngreso')->nullable();
            $table->text('Apuntes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('miembros');
    }
};
