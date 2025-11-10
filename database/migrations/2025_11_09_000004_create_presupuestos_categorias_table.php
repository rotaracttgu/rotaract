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
        Schema::create('presupuestos_categorias', function (Blueprint $table) {
            $table->id('id')->comment('ID único de la categoría presupuestaria');
            
            // DATOS DE LA CATEGORÍA
            $table->string('categoria', 100)->unique()->comment('Nombre de la categoría presupuestaria');
            $table->text('descripcion')->nullable()->comment('Descripción detallada de la categoría');
            
            // MONTOS PRESUPUESTARIOS
            $table->decimal('presupuesto_mensual', 12, 2)->comment('Presupuesto asignado para el mes');
            $table->decimal('presupuesto_anual', 12, 2)->comment('Presupuesto asignado para el año');
            
            // INFORMACIÓN DEL PERÍODO
            $table->integer('mes')->nullable()->comment('Mes específico (1-12), NULL si aplica a todos los meses');
            $table->integer('anio')->nullable()->comment('Año específico, NULL si no aplica a un año en particular');
            
            // CONTROL DE GASTO
            $table->decimal('monto_gastado', 12, 2)->default(0)->comment('Monto total gastado en esta categoría hasta la fecha');
            $table->decimal('monto_disponible', 12, 2)->comment('Monto aún disponible para gastar (calculado)');
            
            // ALERTAS Y NOTIFICACIONES
            $table->decimal('porcentaje_alerta', 5, 2)->default(80)->comment('Porcentaje de presupuesto usado para generar alertas');
            $table->boolean('alerta_activa')->default(false)->comment('Si hay alerta activa por presupuesto cercano a vencerse');
            
            // ESTADO
            $table->enum('estado', ['activa', 'inactiva', 'pausada', 'archivada'])
                ->default('activa')
                ->comment('Estado de la categoría presupuestaria');
            
            // TIMESTAMPS
            $table->timestamp('created_at')->useCurrent()->comment('Fecha de creación');
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate()->comment('Última actualización');
            
            // DEFINICIÓN DE CLAVE PRIMARIA
            $table->primary('id');
            
            // ÍNDICES PARA OPTIMIZACIÓN
            $table->index('categoria')->comment('Búsqueda rápida por nombre de categoría');
            $table->index('estado')->comment('Filtrado por estado');
            $table->index('mes')->comment('Búsqueda por mes específico');
            $table->index('anio')->comment('Búsqueda por año específico');
            $table->index('alerta_activa')->comment('Para identificar presupuestos con alerta');
            $table->index(['mes', 'anio'])->comment('Búsqueda compuesta por período');
        });

        // INSERTAR CATEGORÍAS INICIALES CON PRESUPUESTOS BASE
        DB::table('presupuestos_categorias')->insert([
            [
                'categoria' => 'Oficina',
                'descripcion' => 'Gastos de operación y mantenimiento de la oficina del club',
                'presupuesto_mensual' => 2000.00,
                'presupuesto_anual' => 24000.00,
                'monto_gastado' => 0.00,
                'monto_disponible' => 2000.00,
                'porcentaje_alerta' => 80,
                'estado' => 'activa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoria' => 'Eventos',
                'descripcion' => 'Organización y ejecución de eventos rotarios',
                'presupuesto_mensual' => 5000.00,
                'presupuesto_anual' => 60000.00,
                'monto_gastado' => 0.00,
                'monto_disponible' => 5000.00,
                'porcentaje_alerta' => 75,
                'estado' => 'activa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoria' => 'Proyectos',
                'descripcion' => 'Financiamiento de proyectos sociales y comunitarios',
                'presupuesto_mensual' => 10000.00,
                'presupuesto_anual' => 120000.00,
                'monto_gastado' => 0.00,
                'monto_disponible' => 10000.00,
                'porcentaje_alerta' => 85,
                'estado' => 'activa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoria' => 'Marketing',
                'descripcion' => 'Comunicación, publicidad y difusión del club',
                'presupuesto_mensual' => 1500.00,
                'presupuesto_anual' => 18000.00,
                'monto_gastado' => 0.00,
                'monto_disponible' => 1500.00,
                'porcentaje_alerta' => 80,
                'estado' => 'activa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoria' => 'Mantenimiento',
                'descripcion' => 'Mantenimiento y reparaciones de bienes y equipos',
                'presupuesto_mensual' => 1000.00,
                'presupuesto_anual' => 12000.00,
                'monto_gastado' => 0.00,
                'monto_disponible' => 1000.00,
                'porcentaje_alerta' => 75,
                'estado' => 'activa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presupuestos_categorias');
    }
};
