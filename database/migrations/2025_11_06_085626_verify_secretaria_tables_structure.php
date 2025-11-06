<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Verifica y agrega columnas faltantes en las tablas del módulo de secretaría
     */
    public function up(): void
    {
        // Verificar tabla consultas
        Schema::table('consultas', function (Blueprint $table) {
            if (!Schema::hasColumn('consultas', 'created_at')) {
                $table->timestamps();
            }
        });

        // Verificar tabla actas
        Schema::table('actas', function (Blueprint $table) {
            if (!Schema::hasColumn('actas', 'created_at')) {
                $table->timestamps();
            }
        });

        // Verificar tabla diplomas
        Schema::table('diplomas', function (Blueprint $table) {
            if (!Schema::hasColumn('diplomas', 'created_at')) {
                $table->timestamps();
            }
        });

        // Verificar tabla documentos (ya debería tener las columnas)
        Schema::table('documentos', function (Blueprint $table) {
            if (!Schema::hasColumn('documentos', 'tipo')) {
                $table->enum('tipo', ['oficial', 'interno', 'comunicado', 'carta', 'informe', 'otro'])->default('otro')->after('titulo');
            }
            if (!Schema::hasColumn('documentos', 'created_at')) {
                $table->timestamps();
            }
            if (!Schema::hasColumn('documentos', 'categoria')) {
                $table->string('categoria', 100)->nullable();
            }
            if (!Schema::hasColumn('documentos', 'visible_para_todos')) {
                $table->boolean('visible_para_todos')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No revertir los cambios para mantener la integridad de los datos
    }
};
