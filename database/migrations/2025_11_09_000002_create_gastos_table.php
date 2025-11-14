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
        Schema::create('gastos', function (Blueprint $table) {
            $table->id('id')->comment('ID único del gasto');
            
            // INFORMACIÓN BÁSICA
            $table->string('descripcion', 255)->comment('Descripción detallada del gasto');
            $table->decimal('monto', 10, 2)->comment('Cantidad del gasto');
            $table->date('fecha')->comment('Fecha del gasto o fecha programada');
            
            // CATEGORIZACIÓN
            $table->string('categoria', 100)->comment('Categoría: Oficina, Eventos, Proyectos, Marketing, Mantenimiento, etc.');
            $table->string('proveedor', 100)->nullable()->comment('Nombre del proveedor o beneficiario del pago');
            
            // MÉTODO DE PAGO
            $table->enum('metodo_pago', ['efectivo', 'transferencia', 'tarjeta_credito', 'tarjeta_debito', 'cheque', 'otro'])
                ->default('transferencia')
                ->comment('Forma de pago a utilizar');
            
            // DOCUMENTACIÓN
            $table->string('comprobante', 255)->nullable()->comment('Número de factura, recibo o comprobante');
            $table->string('referencia', 100)->nullable()->comment('Referencia adicional (orden de compra, número de cheque, etc.)');
            $table->text('notas')->nullable()->comment('Observaciones, justificación del gasto, comentarios');
            
            // CONTROL Y AUDITORÍA
            $table->unsignedBigInteger('usuario_registro_id')->nullable()->comment('Usuario que registró el gasto (FK a users)');
            $table->unsignedBigInteger('usuario_aprobacion_id')->nullable()->comment('Usuario que aprobó/rechazó el gasto (FK a users)');
            $table->timestamp('fecha_aprobacion')->nullable()->comment('Fecha y hora de aprobación o rechazo');
            
            // ESTADO DEL GASTO
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado', 'anulado', 'pagado'])
                ->default('pendiente')
                ->comment('Estado actual: pendiente→aprobado→pagado, o pendiente→rechazado, o anulado');
            
            // TIMESTAMPS
            $table->timestamp('created_at')->useCurrent()->comment('Fecha de registro en sistema');
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate()->comment('Última actualización del registro');
            
            // DEFINICIÓN DE CLAVE PRIMARIA
            $table->primary('id');
            
            // ÍNDICES PARA OPTIMIZACIÓN
            $table->index('fecha')->comment('Búsqueda y ordenamiento por fecha');
            $table->index('categoria')->comment('Filtrado por categoría');
            $table->index('proveedor')->comment('Búsqueda por proveedor');
            $table->index('estado')->comment('Filtrado por estado (importante para aprobaciones)');
            $table->index('usuario_registro_id')->comment('Auditoría: quién registró');
            $table->index('usuario_aprobacion_id')->comment('Auditoría: quién aprobó');
            $table->index('metodo_pago')->comment('Estadísticas por método de pago');
            $table->index(['estado', 'fecha'])->comment('Índice compuesto para reportes');
            
            // FOREIGN KEYS
            if (Schema::hasTable('users')) {
                $table->foreign('usuario_registro_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('set null')
                    ->onUpdate('cascade');
                
                $table->foreign('usuario_aprobacion_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('set null')
                    ->onUpdate('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gastos');
    }
};
