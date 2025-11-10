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
        Schema::create('membresias', function (Blueprint $table) {
            $table->id('id')->comment('ID único de la membresía');
            
            // DATOS DEL USUARIO
            $table->unsignedBigInteger('usuario_id')->comment('FK a tabla users - Usuario que paga la membresía');
            
            // DATOS DEL PAGO
            $table->enum('tipo_pago', ['mensual', 'trimestral', 'semestral', 'anual'])
                ->default('mensual')
                ->comment('Tipo de período de membresía');
            $table->decimal('monto', 10, 2)->comment('Monto pagado por la membresía');
            $table->date('fecha_pago')->comment('Fecha en que se realizó el pago');
            $table->enum('metodo_pago', ['efectivo', 'transferencia', 'tarjeta_credito', 'tarjeta_debito', 'cheque'])
                ->default('transferencia')
                ->comment('Método de pago utilizado');
            
            // PERÍODO DE VIGENCIA
            $table->date('periodo_inicio')->comment('Fecha de inicio de la vigencia');
            $table->date('periodo_fin')->comment('Fecha de fin de la vigencia');
            
            // DOCUMENTACIÓN
            $table->string('comprobante', 255)->nullable()->comment('Número o referencia del comprobante de pago');
            $table->text('notas')->nullable()->comment('Observaciones adicionales sobre el pago');
            
            // ESTADO Y CONTROL
            $table->enum('estado', ['activa', 'vencida', 'cancelada', 'completada'])
                ->default('activa')
                ->comment('Estado actual de la membresía');
            
            // TIMESTAMPS
            $table->timestamp('created_at')->useCurrent()->comment('Fecha de registro');
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate()->comment('Última actualización');
            
            // DEFINICIÓN DE CLAVE PRIMARIA
            $table->primary('id');
            
            // ÍNDICES PARA OPTIMIZACIÓN
            $table->index('usuario_id')->comment('Búsqueda rápida por usuario');
            $table->index('fecha_pago')->comment('Búsqueda por fecha de pago');
            $table->index('estado')->comment('Filtrado por estado');
            $table->index('periodo_fin')->comment('Para detectar membresías por vencer');
            $table->index('tipo_pago')->comment('Estadísticas por tipo de pago');
            
            // FOREIGN KEY
            if (Schema::hasTable('users')) {
                $table->foreign('usuario_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membresias');
    }
};
