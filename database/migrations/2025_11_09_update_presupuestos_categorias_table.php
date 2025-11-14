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
        if (Schema::hasTable('presupuestos_categorias')) {
            Schema::table('presupuestos_categorias', function (Blueprint $table) {
                if (!Schema::hasColumn('presupuestos_categorias', 'deleted_at')) {
                    $table->softDeletes()->after('updated_at');
                }
                if (!Schema::hasColumn('presupuestos_categorias', 'usuario_id')) {
                    $table->unsignedBigInteger('usuario_id')->nullable()->after('id');
                }
                if (!Schema::hasColumn('presupuestos_categorias', 'periodo')) {
                    $table->date('periodo')->nullable()->after('anio');
                }
                if (!Schema::hasColumn('presupuestos_categorias', 'fecha_inicio')) {
                    $table->date('fecha_inicio')->nullable()->after('periodo');
                }
                if (!Schema::hasColumn('presupuestos_categorias', 'fecha_fin')) {
                    $table->date('fecha_fin')->nullable()->after('fecha_inicio');
                }
                if (!Schema::hasColumn('presupuestos_categorias', 'monto_presupuestado')) {
                    $table->decimal('monto_presupuestado', 12, 2)->nullable()->after('presupuesto_anual');
                }
                if (!Schema::hasColumn('presupuestos_categorias', 'observaciones')) {
                    $table->text('observaciones')->nullable()->after('estado');
                }
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
                if (Schema::hasColumn('presupuestos_categorias', 'deleted_at')) {
                    $table->dropColumn('deleted_at');
                }
                if (Schema::hasColumn('presupuestos_categorias', 'usuario_id')) {
                    $table->dropColumn('usuario_id');
                }
                if (Schema::hasColumn('presupuestos_categorias', 'periodo')) {
                    $table->dropColumn('periodo');
                }
                if (Schema::hasColumn('presupuestos_categorias', 'fecha_inicio')) {
                    $table->dropColumn('fecha_inicio');
                }
                if (Schema::hasColumn('presupuestos_categorias', 'fecha_fin')) {
                    $table->dropColumn('fecha_fin');
                }
                if (Schema::hasColumn('presupuestos_categorias', 'monto_presupuestado')) {
                    $table->dropColumn('monto_presupuestado');
                }
                if (Schema::hasColumn('presupuestos_categorias', 'observaciones')) {
                    $table->dropColumn('observaciones');
                }
            });
        }
    }
};
