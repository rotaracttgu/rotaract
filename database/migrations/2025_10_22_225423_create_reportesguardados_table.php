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
        Schema::create('reportesguardados', function (Blueprint $table) {
            $table->integer('ReporteGuardadoID', true);
            $table->integer('ReporteID')->nullable()->index('ix_repg_rep');
            $table->unsignedBigInteger('UsuarioID');
            $table->string('NombreGuardado', 100);
            $table->text('Descripcion')->nullable();
            $table->json('FiltrosJSON')->nullable();
            $table->dateTime('FechaGuardado')->useCurrent();
            $table->string('EstadoGuardado', 20)->default('Activo');

            $table->index(['UsuarioID', 'EstadoGuardado'], 'ix_repg_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportesguardados');
    }
};
