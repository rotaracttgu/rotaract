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
        Schema::table('gastos', function (Blueprint $table) {
            // Renombrar comprobante a numero_factura
            if (Schema::hasColumn('gastos', 'comprobante')) {
                $table->renameColumn('comprobante', 'numero_factura');
            }
            
            // Agregar nueva columna comprobante para la ruta del archivo
            if (!Schema::hasColumn('gastos', 'comprobante_archivo')) {
                $table->string('comprobante_archivo', 255)->nullable()->after('metodo_pago')->comment('Ruta del archivo de comprobante (PDF, imagen)');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gastos', function (Blueprint $table) {
            // Revertir: eliminar columna comprobante_archivo
            if (Schema::hasColumn('gastos', 'comprobante_archivo')) {
                $table->dropColumn('comprobante_archivo');
            }
            
            // Revertir: renombrar numero_factura de vuelta a comprobante
            if (Schema::hasColumn('gastos', 'numero_factura')) {
                $table->renameColumn('numero_factura', 'comprobante');
            }
        });
    }
};
