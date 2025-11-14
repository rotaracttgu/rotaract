<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Verificar si la tabla existe
        if (Schema::hasTable('presupuestos_categorias')) {
            Schema::table('presupuestos_categorias', function (Blueprint $table) {
                // Eliminar el índice unique de 'categoria' si existe
                try {
                    DB::statement('ALTER TABLE presupuestos_categorias DROP INDEX presupuestos_categorias_categoria_unique');
                } catch (\Exception $e) {
                    // Si no existe, continuar
                }
                
                // Eliminar el índice de 'categoria' si existe
                try {
                    $table->dropIndex(['categoria']);
                } catch (\Exception $e) {
                    // Si no existe, continuar
                }
            });
            
            // Agregar nuevo índice único compuesto
            Schema::table('presupuestos_categorias', function (Blueprint $table) {
                // Índice único compuesto: categoria + mes + anio
                // Esto permite la misma categoría en diferentes periodos
                $table->unique(['categoria', 'mes', 'anio'], 'presupuestos_categoria_periodo_unique');
                
                // Índice normal para búsquedas
                $table->index('categoria', 'presupuestos_categoria_index');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('presupuestos_categorias')) {
            Schema::table('presupuestos_categorias', function (Blueprint $table) {
                // Eliminar el índice único compuesto
                try {
                    $table->dropUnique('presupuestos_categoria_periodo_unique');
                } catch (\Exception $e) {
                    // Si no existe, continuar
                }
                
                // Eliminar el índice normal
                try {
                    $table->dropIndex('presupuestos_categoria_index');
                } catch (\Exception $e) {
                    // Si no existe, continuar
                }
            });
            
            // Restaurar el índice único simple
            Schema::table('presupuestos_categorias', function (Blueprint $table) {
                $table->unique('categoria', 'presupuestos_categorias_categoria_unique');
            });
        }
    }
};
