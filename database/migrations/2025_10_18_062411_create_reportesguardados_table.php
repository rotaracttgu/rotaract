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
        if (!Schema::hasTable('reportesguardados')) {
            Schema::create('reportesguardados', function (Blueprint $table) {
                $table->id('ReporteGuardadoID');
                $table->unsignedBigInteger('ReporteID')->nullable();
                $table->foreignId('UsuarioID')->constrained('users')->onDelete('cascade');
                $table->string('NombreGuardado', 100);
                $table->text('Descripcion')->nullable();
                $table->json('FiltrosJSON')->nullable();
                $table->dateTime('FechaGuardado')->useCurrent();
                $table->string('EstadoGuardado', 20)->default('Activo');
                
                $table->foreign('ReporteID')->references('ReporteID')->on('reportes')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportesguardados');
    }
};
