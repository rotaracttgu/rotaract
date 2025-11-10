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
        Schema::table('membresias', function (Blueprint $table) {
            // Agregar miembro_id como alias de usuario_id (para compatibilidad)
            if (!Schema::hasColumn('membresias', 'miembro_id')) {
                $table->unsignedBigInteger('miembro_id')->nullable()->after('usuario_id')->comment('FK a tabla users (alias de usuario_id)');
            }
            
            // Agregar tipo_membresia
            if (!Schema::hasColumn('membresias', 'tipo_membresia')) {
                $table->string('tipo_membresia', 100)->nullable()->after('tipo_pago')->default('Membresía Mensual')->comment('Descripción del tipo de membresía');
            }
            
            // Agregar fecha_vencimiento
            if (!Schema::hasColumn('membresias', 'fecha_vencimiento')) {
                $table->date('fecha_vencimiento')->nullable()->after('periodo_fin')->comment('Fecha de vencimiento de la membresía');
            }
            
            // Agregar numero_comprobante
            if (!Schema::hasColumn('membresias', 'numero_comprobante')) {
                $table->string('numero_comprobante', 100)->nullable()->after('comprobante')->comment('Número único del comprobante');
            }
            
            // Agregar numero_referencia
            if (!Schema::hasColumn('membresias', 'numero_referencia')) {
                $table->string('numero_referencia', 100)->nullable()->after('numero_comprobante')->comment('Número de referencia bancaria');
            }
            
            // Agregar banco_origen
            if (!Schema::hasColumn('membresias', 'banco_origen')) {
                $table->string('banco_origen', 100)->nullable()->after('numero_referencia')->comment('Banco de origen de la transferencia');
            }
        });
        
        // Actualizar miembro_id con los valores de usuario_id para datos existentes
        DB::statement('UPDATE membresias SET miembro_id = usuario_id WHERE miembro_id IS NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('membresias', function (Blueprint $table) {
            $table->dropColumn([
                'miembro_id',
                'tipo_membresia',
                'fecha_vencimiento',
                'numero_comprobante',
                'numero_referencia',
                'banco_origen'
            ]);
        });
    }
};
