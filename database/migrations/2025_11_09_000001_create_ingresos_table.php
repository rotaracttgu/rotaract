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
        Schema::create('ingresos', function (Blueprint $table) {
            $table->id('id')->comment('ID único del ingreso');
            
            // INFORMACIÓN BÁSICA
            $table->string('descripcion', 255)->comment('Descripción detallada del ingreso');
            $table->decimal('monto', 10, 2)->comment('Cantidad del ingreso');
            $table->date('fecha')->comment('Fecha en que se recibió el ingreso');
            
            // CATEGORIZACIÓN
            $table->string('categoria', 100)->comment('Categoría: Membresías, Donaciones, Eventos, Patrocinios, Otros');
            $table->string('fuente', 100)->nullable()->comment('Origen del ingreso (nombre de persona, empresa, etc.)');
            
            // MÉTODO DE PAGO
            $table->enum('metodo_pago', ['efectivo', 'transferencia', 'tarjeta_credito', 'tarjeta_debito', 'cheque', 'otro'])
                ->default('transferencia')
                ->comment('Forma de pago recibida');
            
            // DOCUMENTACIÓN
            $table->string('comprobante', 255)->nullable()->comment('Número de comprobante, factura o recibo');
            $table->string('referencia', 100)->nullable()->comment('Referencia adicional (número de transacción, etc.)');
            $table->text('notas')->nullable()->comment('Observaciones o comentarios adicionales');
            
            // CONTROL Y AUDITORÍA
            $table->unsignedBigInteger('usuario_registro_id')->nullable()->comment('Usuario que registró el ingreso (FK a users)');
            $table->enum('estado', ['pendiente', 'confirmado', 'anulado'])
                ->default('confirmado')
                ->comment('Estado del registro: pendiente de confirmar, confirmado, anulado');
            
            // TIMESTAMPS
            $table->timestamp('created_at')->useCurrent()->comment('Fecha de registro en sistema');
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate()->comment('Última actualización del registro');
            
            // DEFINICIÓN DE CLAVE PRIMARIA
            $table->primary('id');
            
            // ÍNDICES PARA OPTIMIZACIÓN
            $table->index('fecha')->comment('Búsqueda y ordenamiento por fecha');
            $table->index('categoria')->comment('Filtrado por categoría');
            $table->index('estado')->comment('Filtrado por estado');
            $table->index('usuario_registro_id')->comment('Auditoría por usuario');
            $table->index('fuente')->comment('Búsqueda por origen del ingreso');
            $table->index('metodo_pago')->comment('Estadísticas por método de pago');
            
            // FOREIGN KEY
            if (Schema::hasTable('users')) {
                $table->foreign('usuario_registro_id')
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
        Schema::dropIfExists('ingresos');
    }
};
