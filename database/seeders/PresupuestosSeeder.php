<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PresupuestosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar presupuestos antiguos sin periodo
        DB::table('presupuestos_categorias')->whereNull('periodo')->delete();
        
        // Obtener el mes y año actual
        $mesActual = Carbon::now()->month;
        $anioActual = Carbon::now()->year;
        $periodo = Carbon::now()->startOfMonth();
        
        $categorias = [
            [
                'categoria' => 'Oficina',
                'descripcion' => 'Gastos de operación y mantenimiento de la oficina del club',
                'monto_presupuestado' => 2000.00,
                'presupuesto_mensual' => 2000.00,
                'presupuesto_anual' => 24000.00,
            ],
            [
                'categoria' => 'Eventos',
                'descripcion' => 'Organización y ejecución de eventos rotarios',
                'monto_presupuestado' => 5000.00,
                'presupuesto_mensual' => 5000.00,
                'presupuesto_anual' => 60000.00,
            ],
            [
                'categoria' => 'Proyectos',
                'descripcion' => 'Financiamiento de proyectos sociales y comunitarios',
                'monto_presupuestado' => 10000.00,
                'presupuesto_mensual' => 10000.00,
                'presupuesto_anual' => 120000.00,
            ],
            [
                'categoria' => 'Marketing',
                'descripcion' => 'Comunicación, publicidad y difusión del club',
                'monto_presupuestado' => 1500.00,
                'presupuesto_mensual' => 1500.00,
                'presupuesto_anual' => 18000.00,
            ],
            [
                'categoria' => 'Mantenimiento',
                'descripcion' => 'Mantenimiento y reparaciones de bienes y equipos',
                'monto_presupuestado' => 1000.00,
                'presupuesto_mensual' => 1000.00,
                'presupuesto_anual' => 12000.00,
            ],
            [
                'categoria' => 'Capacitación',
                'descripcion' => 'Talleres, cursos y formación de miembros',
                'monto_presupuestado' => 3000.00,
                'presupuesto_mensual' => 3000.00,
                'presupuesto_anual' => 36000.00,
            ],
        ];

        foreach ($categorias as $cat) {
            // Verificar si ya existe un presupuesto para esta categoría en este periodo
            $existe = DB::table('presupuestos_categorias')
                ->where('categoria', $cat['categoria'])
                ->whereYear('periodo', $anioActual)
                ->whereMonth('periodo', $mesActual)
                ->exists();
            
            if (!$existe) {
                DB::table('presupuestos_categorias')->insert([
                    'usuario_id' => 1, // Usuario admin
                    'categoria' => $cat['categoria'],
                    'descripcion' => $cat['descripcion'],
                    'monto_presupuestado' => $cat['monto_presupuestado'],
                    'presupuesto_mensual' => $cat['presupuesto_mensual'],
                    'presupuesto_anual' => $cat['presupuesto_anual'],
                    'mes' => $mesActual,
                    'anio' => $anioActual,
                    'periodo' => $periodo,
                    'monto_gastado' => 0.00,
                    'monto_disponible' => $cat['monto_presupuestado'],
                    'porcentaje_alerta' => 80,
                    'alerta_activa' => false,
                    'estado' => 'activa',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                echo "✅ Presupuesto creado: {$cat['categoria']}\n";
            } else {
                echo "⏭️  Presupuesto ya existe: {$cat['categoria']}\n";
            }
        }
        
        echo "\n✨ Presupuestos iniciales configurados correctamente\n";
    }
}
