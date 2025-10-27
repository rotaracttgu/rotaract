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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->enum('tipo', ['oficial', 'interno', 'comunicado', 'carta', 'informe', 'otro']);
            $table->text('descripcion')->nullable();
            $table->string('archivo_path');
            $table->string('archivo_nombre');
            $table->string('categoria', 100)->nullable();
            $table->foreignId('creado_por')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
