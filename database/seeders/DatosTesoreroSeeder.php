<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatosTesoreroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "🚀 Iniciando carga de datos del módulo Tesorero...\n\n";
        
        // Obtener el primer usuario disponible
        $userId = DB::table('users')->orderBy('id')->first()->id ?? null;
        
        if (!$userId) {
            echo "❌ ERROR: No hay usuarios en la base de datos\n";
            echo "   Por favor, crea al menos un usuario antes de ejecutar este seeder.\n";
            return;
        }
        
        echo "👤 Usuario para registros: ID {$userId}\n\n";
        
        $mesActual = Carbon::now()->month;
        $anioActual = Carbon::now()->year;
        
        // ==================== INGRESOS ====================
        echo "💰 Insertando INGRESOS...\n";
        
        $ingresos = [
            [
                'descripcion' => 'Cuota de membresía - Noviembre 2025',
                'categoria' => 'Membresías',
                'monto' => 1500.00,
                'fecha' => Carbon::now()->subDays(5),
                'fuente' => 'Miembros',
                'metodo_pago' => 'transferencia',
                'comprobante' => 'TRANS-' . rand(1000, 9999),
                'estado' => 'confirmado',
            ],
            [
                'descripcion' => 'Donación empresa local',
                'categoria' => 'Donaciones',
                'monto' => 5000.00,
                'fecha' => Carbon::now()->subDays(10),
                'fuente' => 'Empresa XYZ',
                'metodo_pago' => 'cheque',
                'comprobante' => 'CHQ-' . rand(1000, 9999),
                'estado' => 'confirmado',
            ],
            [
                'descripcion' => 'Venta de rifas - Evento benéfico',
                'categoria' => 'Eventos',
                'monto' => 2500.00,
                'fecha' => Carbon::now()->subDays(8),
                'fuente' => 'Evento Público',
                'metodo_pago' => 'efectivo',
                'estado' => 'confirmado',
            ],
            [
                'descripcion' => 'Patrocinio para proyecto comunitario',
                'categoria' => 'Proyectos',
                'monto' => 8000.00,
                'fecha' => Carbon::now()->subDays(15),
                'fuente' => 'Gobierno Local',
                'metodo_pago' => 'transferencia',
                'comprobante' => 'TRANS-' . rand(1000, 9999),
                'estado' => 'confirmado',
            ],
            [
                'descripcion' => 'Cuota trimestral rotarios',
                'categoria' => 'Membresías',
                'monto' => 3000.00,
                'fecha' => Carbon::now()->subDays(20),
                'fuente' => 'Miembros',
                'metodo_pago' => 'transferencia',
                'estado' => 'confirmado',
            ],
        ];
        
        foreach ($ingresos as $ingreso) {
            DB::table('ingresos')->insert(array_merge($ingreso, [
                'usuario_registro_id' => $userId,
                'notas' => 'Ingreso registrado automáticamente',
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
        
        echo "   ✅ " . count($ingresos) . " ingresos insertados\n\n";
        
        // ==================== GASTOS/EGRESOS ====================
        echo "💸 Insertando GASTOS/EGRESOS...\n";
        
        $gastos = [
            [
                'descripcion' => 'Compra de material de oficina',
                'categoria' => 'Oficina',
                'monto' => 450.00,
                'fecha' => Carbon::now()->subDays(3),
                'proveedor' => 'Papelería Central',
                'metodo_pago' => 'efectivo',
                'comprobante' => 'FAC-' . rand(1000, 9999),
                'estado' => 'aprobado',
                'tipo' => 'gasto',
            ],
            [
                'descripcion' => 'Alquiler de local para evento',
                'categoria' => 'Eventos',
                'monto' => 1200.00,
                'fecha' => Carbon::now()->subDays(7),
                'proveedor' => 'Salón de Eventos Aurora',
                'metodo_pago' => 'transferencia',
                'comprobante' => 'FAC-' . rand(1000, 9999),
                'estado' => 'aprobado',
                'tipo' => 'gasto',
            ],
            [
                'descripcion' => 'Catering para reunión mensual',
                'categoria' => 'Eventos',
                'monto' => 800.00,
                'fecha' => Carbon::now()->subDays(5),
                'proveedor' => 'Catering Delicias',
                'metodo_pago' => 'efectivo',
                'estado' => 'aprobado',
                'tipo' => 'gasto',
            ],
            [
                'descripcion' => 'Material didáctico para proyecto escolar',
                'categoria' => 'Proyectos',
                'monto' => 2500.00,
                'fecha' => Carbon::now()->subDays(12),
                'proveedor' => 'Librería Educativa',
                'metodo_pago' => 'cheque',
                'comprobante' => 'CHQ-' . rand(1000, 9999),
                'estado' => 'aprobado',
                'tipo' => 'gasto',
            ],
            [
                'descripcion' => 'Diseño de material publicitario',
                'categoria' => 'Marketing',
                'monto' => 600.00,
                'fecha' => Carbon::now()->subDays(9),
                'proveedor' => 'Diseño Creativo S.A.',
                'metodo_pago' => 'transferencia',
                'estado' => 'aprobado',
                'tipo' => 'gasto',
            ],
            [
                'descripcion' => 'Mantenimiento de equipos audiovisuales',
                'categoria' => 'Mantenimiento',
                'monto' => 350.00,
                'fecha' => Carbon::now()->subDays(6),
                'proveedor' => 'TecnoService',
                'metodo_pago' => 'efectivo',
                'estado' => 'aprobado',
                'tipo' => 'gasto',
            ],
            [
                'descripcion' => 'Impresión de volantes informativos',
                'categoria' => 'Marketing',
                'monto' => 280.00,
                'fecha' => Carbon::now()->subDays(4),
                'proveedor' => 'Imprenta Rápida',
                'metodo_pago' => 'efectivo',
                'estado' => 'pendiente',
                'tipo' => 'gasto',
            ],
        ];
        
        foreach ($gastos as $gasto) {
            DB::table('gastos')->insert(array_merge($gasto, [
                'usuario_registro_id' => $userId,
                'usuario_aprobacion_id' => $gasto['estado'] === 'aprobado' ? $userId : null,
                'notas' => 'Gasto registrado automáticamente',
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
        
        echo "   ✅ " . count($gastos) . " gastos insertados\n\n";
        
        // ==================== ACTUALIZAR PRESUPUESTOS ====================
        echo "📊 Actualizando montos gastados en presupuestos...\n";
        
        // Calcular gastos por categoría
        $gastoPorCategoria = DB::table('gastos')
            ->select('categoria', DB::raw('SUM(monto) as total'))
            ->where('estado', '!=', 'rechazado')
            ->groupBy('categoria')
            ->get();
        
        foreach ($gastoPorCategoria as $cat) {
            DB::table('presupuestos_categorias')
                ->where('categoria', $cat->categoria)
                ->whereMonth('periodo', $mesActual)
                ->whereYear('periodo', $anioActual)
                ->update([
                    'monto_gastado' => $cat->total,
                    'monto_disponible' => DB::raw('monto_presupuestado - ' . $cat->total),
                    'updated_at' => now(),
                ]);
            
            echo "   ✅ {$cat->categoria}: L.{$cat->total} gastados\n";
        }
        
        echo "\n✨ Datos del módulo Tesorero cargados correctamente\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        
        // Resumen
        $totalIngresos = DB::table('ingresos')->sum('monto');
        $totalGastos = DB::table('gastos')->where('estado', '!=', 'rechazado')->sum('monto');
        $balance = $totalIngresos - $totalGastos;
        
        echo "\n📈 RESUMEN FINANCIERO:\n";
        echo "   💰 Total Ingresos: L." . number_format($totalIngresos, 2) . "\n";
        echo "   💸 Total Gastos: L." . number_format($totalGastos, 2) . "\n";
        echo "   💵 Balance: L." . number_format($balance, 2) . "\n";
        echo "\n";
    }
}
