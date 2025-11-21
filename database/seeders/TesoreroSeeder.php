<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TesoreroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener usuarios tesorero para asignaciones
        $tesoreros = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.name', 'Tesorero')
            ->orWhere('roles.name', 'Presidente')
            ->pluck('users.id')
            ->toArray();

        $tesorero_id = !empty($tesoreros) ? $tesoreros[0] : 1;

        // Obtener usuarios para membresías (Miembros del club)
        $miembros = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->whereIn('roles.name', ['Miembro', 'Socio'])
            ->pluck('users.id')
            ->toArray();

        // ============================================================================
        // INGRESOS
        // ============================================================================
        $ingresos_data = [
            // Ingresos de noviembre 2025
            [
                'descripcion' => 'Membresía mensual - Noviembre 2025',
                'monto' => 5000.00,
                'fecha' => '2025-11-01',
                'categoria' => 'Membresías',
                'fuente' => 'Miembros del Club',
                'metodo_pago' => 'transferencia',
                'comprobante' => 'TRF-2025-11-001',
                'referencia' => 'Depósito Banco A',
                'notas' => 'Recaudación de membresías del mes',
                'usuario_registro_id' => $tesorero_id,
                'estado' => 'confirmado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Donación empresa patrocinadora - Proyecto Solidario',
                'monto' => 15000.00,
                'fecha' => '2025-11-03',
                'categoria' => 'Patrocinios',
                'fuente' => 'Empresa TecnoSoluciones S.A.',
                'metodo_pago' => 'transferencia',
                'comprobante' => 'FAC-2025-11-0045',
                'referencia' => 'Transferencia bancaria',
                'notas' => 'Patrocinio para proyecto educativo',
                'usuario_registro_id' => $tesorero_id,
                'estado' => 'confirmado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Recaudación evento benéfico - Cena de gala',
                'monto' => 8500.00,
                'fecha' => '2025-11-05',
                'categoria' => 'Eventos',
                'fuente' => 'Evento benéfico - Cena de gala',
                'metodo_pago' => 'efectivo',
                'comprobante' => 'EVT-2025-11-001',
                'referencia' => 'Recaudación en efectivo',
                'notas' => 'Venta de boletos para cena de gala benéfica',
                'usuario_registro_id' => $tesorero_id,
                'estado' => 'confirmado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Donación voluntaria - Fondo de emergencia',
                'monto' => 3500.00,
                'fecha' => '2025-11-07',
                'categoria' => 'Donaciones',
                'fuente' => 'Miembro del club - Donación voluntaria',
                'metodo_pago' => 'transferencia',
                'comprobante' => 'TRF-2025-11-002',
                'referencia' => 'Transferencia personal',
                'notas' => 'Contribución voluntaria para fondo de emergencia social',
                'usuario_registro_id' => $tesorero_id,
                'estado' => 'confirmado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Venta de merchandising - Playeras y gorras',
                'monto' => 2200.00,
                'fecha' => '2025-11-10',
                'categoria' => 'Otros',
                'fuente' => 'Venta de merchandising',
                'metodo_pago' => 'efectivo',
                'comprobante' => 'VTA-2025-11-001',
                'referencia' => 'Venta directa',
                'notas' => 'Venta de playeras, gorras y accesorios con logo del club',
                'usuario_registro_id' => $tesorero_id,
                'estado' => 'confirmado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Intereses bancarios - Cuenta corriente',
                'monto' => 450.75,
                'fecha' => '2025-11-15',
                'categoria' => 'Otros',
                'fuente' => 'Banco principal',
                'metodo_pago' => 'transferencia',
                'comprobante' => 'INT-2025-11-001',
                'referencia' => 'Intereses cuenta corriente',
                'notas' => 'Intereses generados en noviembre',
                'usuario_registro_id' => $tesorero_id,
                'estado' => 'confirmado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Recaudación - Actividad educativa con estudiantes',
                'monto' => 4800.00,
                'fecha' => '2025-11-18',
                'categoria' => 'Eventos',
                'fuente' => 'Actividad educativa',
                'metodo_pago' => 'efectivo',
                'comprobante' => 'EDU-2025-11-001',
                'referencia' => 'Recaudación directa',
                'notas' => 'Ingresos por talleres educativos impartidos a estudiantes',
                'usuario_registro_id' => $tesorero_id,
                'estado' => 'confirmado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Membresía extra - Nuevos miembros',
                'monto' => 3000.00,
                'fecha' => '2025-11-20',
                'categoria' => 'Membresías',
                'fuente' => 'Nuevos miembros',
                'metodo_pago' => 'tarjeta_credito',
                'comprobante' => 'TRJ-2025-11-001',
                'referencia' => 'Pago con tarjeta',
                'notas' => 'Cuotas de admisión de nuevos miembros',
                'usuario_registro_id' => $tesorero_id,
                'estado' => 'confirmado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('ingresos')->insert($ingresos_data);

        // ============================================================================
        // GASTOS
        // ============================================================================
        $gastos_data = [
            [
                'descripcion' => 'Alquiler de oficina - Noviembre',
                'monto' => 8000.00,
                'fecha' => '2025-11-01',
                'categoria' => 'Oficina',
                'proveedor' => 'Inmobiliaria Centro',
                'metodo_pago' => 'transferencia',
                'comprobante' => 'REC-2025-11-001',
                'referencia' => 'Recibo de arrendamiento',
                'notas' => 'Pago de renta mensual de la oficina principal',
                'usuario_registro_id' => $tesorero_id,
                'usuario_aprobacion_id' => $tesorero_id,
                'fecha_aprobacion' => now(),
                'estado' => 'pagado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Servicio de electricidad - Noviembre',
                'monto' => 1200.00,
                'fecha' => '2025-11-02',
                'categoria' => 'Oficina',
                'proveedor' => 'Empresa de Servicios Eléctricos',
                'metodo_pago' => 'transferencia',
                'comprobante' => 'FAC-2025-11-0012',
                'referencia' => 'Factura eléctrica',
                'notas' => 'Pago de consumo eléctrico',
                'usuario_registro_id' => $tesorero_id,
                'usuario_aprobacion_id' => $tesorero_id,
                'fecha_aprobacion' => now(),
                'estado' => 'pagado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Servicio de Internet y telefonía',
                'monto' => 850.00,
                'fecha' => '2025-11-02',
                'categoria' => 'Oficina',
                'proveedor' => 'Operador de telecomunicaciones',
                'metodo_pago' => 'transferencia',
                'comprobante' => 'FAC-2025-11-0089',
                'referencia' => 'Factura de servicios',
                'notas' => 'Internet de banda ancha y líneas telefónicas',
                'usuario_registro_id' => $tesorero_id,
                'usuario_aprobacion_id' => $tesorero_id,
                'fecha_aprobacion' => now(),
                'estado' => 'pagado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Compra de insumos de oficina',
                'monto' => 650.00,
                'fecha' => '2025-11-05',
                'categoria' => 'Oficina',
                'proveedor' => 'Papelería Profesional',
                'metodo_pago' => 'efectivo',
                'comprobante' => 'BOL-2025-11-0001',
                'referencia' => 'Boleta de compra',
                'notas' => 'Papel, tóner, bolígrafos y otros suministros',
                'usuario_registro_id' => $tesorero_id,
                'usuario_aprobacion_id' => $tesorero_id,
                'fecha_aprobacion' => now(),
                'estado' => 'pagado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Viáticos y transporte - Actividad de integración',
                'monto' => 2500.00,
                'fecha' => '2025-11-08',
                'categoria' => 'Eventos',
                'proveedor' => 'Empresa de transporte',
                'metodo_pago' => 'cheque',
                'comprobante' => 'CHQ-2025-0542',
                'referencia' => 'Cheque número 542',
                'notas' => 'Transporte para actividad de integración del club',
                'usuario_registro_id' => $tesorero_id,
                'usuario_aprobacion_id' => $tesorero_id,
                'fecha_aprobacion' => now(),
                'estado' => 'pagado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Refrigerios para reunión del directorio',
                'monto' => 450.00,
                'fecha' => '2025-11-10',
                'categoria' => 'Eventos',
                'proveedor' => 'Catering "El Buen Sabor"',
                'metodo_pago' => 'efectivo',
                'comprobante' => 'BOL-2025-11-0045',
                'referencia' => 'Boleta de catering',
                'notas' => 'Café, pasteles y bebidas para reunión',
                'usuario_registro_id' => $tesorero_id,
                'usuario_aprobacion_id' => $tesorero_id,
                'fecha_aprobacion' => now(),
                'estado' => 'pagado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Mantenimiento de equipos de oficina',
                'monto' => 1800.00,
                'fecha' => '2025-11-12',
                'categoria' => 'Mantenimiento',
                'proveedor' => 'Técnicos Informáticos S.A.',
                'metodo_pago' => 'transferencia',
                'comprobante' => 'FAC-2025-11-0156',
                'referencia' => 'Factura de servicio técnico',
                'notas' => 'Reparación y mantenimiento de computadoras e impresoras',
                'usuario_registro_id' => $tesorero_id,
                'usuario_aprobacion_id' => $tesorero_id,
                'fecha_aprobacion' => now(),
                'estado' => 'pagado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Impresión de material promocional',
                'monto' => 1200.00,
                'fecha' => '2025-11-14',
                'categoria' => 'Marketing',
                'proveedor' => 'Imprenta Digital Express',
                'metodo_pago' => 'efectivo',
                'comprobante' => 'BOL-2025-11-0089',
                'referencia' => 'Boleta de impresión',
                'notas' => 'Flyers, afiches y tarjetas de presentación',
                'usuario_registro_id' => $tesorero_id,
                'usuario_aprobacion_id' => null,
                'fecha_aprobacion' => null,
                'estado' => 'pendiente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Donación a ONG local - Proyecto de educación',
                'monto' => 5000.00,
                'fecha' => '2025-11-20',
                'categoria' => 'Proyectos',
                'proveedor' => 'ONG Educación para Todos',
                'metodo_pago' => 'transferencia',
                'comprobante' => 'DON-2025-11-001',
                'referencia' => 'Recibo de donación',
                'notas' => 'Contribución a proyecto educativo comunitario',
                'usuario_registro_id' => $tesorero_id,
                'usuario_aprobacion_id' => $tesorero_id,
                'fecha_aprobacion' => now(),
                'estado' => 'aprobado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Compra de equipos para proyecto social',
                'monto' => 3500.00,
                'fecha' => '2025-11-22',
                'categoria' => 'Proyectos',
                'proveedor' => 'Proveedor de equipos educativos',
                'metodo_pago' => 'tarjeta_credito',
                'comprobante' => 'TRJ-2025-11-002',
                'referencia' => 'Tarjeta crédito',
                'notas' => 'Tabletas y laptop para distribución en escuelas',
                'usuario_registro_id' => $tesorero_id,
                'usuario_aprobacion_id' => $tesorero_id,
                'fecha_aprobacion' => now(),
                'estado' => 'aprobado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('gastos')->insert($gastos_data);

        // ============================================================================
        // MEMBRESÍAS
        // ============================================================================
        if (!empty($miembros)) {
            $membresias_data = [];
            $categorias_membresias = ['mensual', 'trimestral', 'semestral', 'anual'];
            $metodos_pago = ['transferencia', 'tarjeta_credito', 'efectivo', 'tarjeta_debito'];
            $estados = ['activa', 'vencida', 'completada'];
            
            // Crear membresías para cada miembro
            foreach ($miembros as $index => $miembro_id) {
                $tipo_pago = $categorias_membresias[array_rand($categorias_membresias)];
                $metodo = $metodos_pago[array_rand($metodos_pago)];
                $estado = $estados[array_rand($estados)];
                
                // Determinar monto según tipo
                $montos = [
                    'mensual' => 500.00,
                    'trimestral' => 1350.00,
                    'semestral' => 2700.00,
                    'anual' => 5000.00,
                ];
                
                $fecha_pago = Carbon::now()->subMonths(rand(0, 2));
                $periodo_inicio = clone $fecha_pago;
                
                // Calcular período final según tipo
                $periodo_fin = match($tipo_pago) {
                    'mensual' => $periodo_inicio->clone()->addMonth(),
                    'trimestral' => $periodo_inicio->clone()->addMonths(3),
                    'semestral' => $periodo_inicio->clone()->addMonths(6),
                    'anual' => $periodo_inicio->clone()->addYear(),
                };
                
                $membresias_data[] = [
                    'usuario_id' => $miembro_id,
                    'tipo_pago' => $tipo_pago,
                    'monto' => $montos[$tipo_pago],
                    'fecha_pago' => $fecha_pago->format('Y-m-d'),
                    'metodo_pago' => $metodo,
                    'periodo_inicio' => $periodo_inicio->format('Y-m-d'),
                    'periodo_fin' => $periodo_fin->format('Y-m-d'),
                    'comprobante' => 'MEM-' . str_pad($index + 1, 6, '0', STR_PAD_LEFT),
                    'notas' => 'Membresía ' . ucfirst($tipo_pago) . ' del club',
                    'estado' => $estado,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            DB::table('membresias')->insert($membresias_data);
        }

        // ============================================================================
        // PRESUPUESTOS POR CATEGORÍA (para noviembre y diciembre 2025)
        // ============================================================================
        // Nota: Las categorías base ya están creadas en la migración.
        // Solo actualizaremos los presupuestos si existen, o crearemos nuevos con mes/año específico
        
        $presupuestos_actuales = DB::table('presupuestos_categorias')
            ->whereNull('mes')
            ->pluck('id', 'categoria')
            ->toArray();

        // Si existen, no agregamos más presupuestos para evitar duplicados
        // Si no existen, crearemos presupuestos de ejemplo para esta demostración
        $presupuestos = [];
        if (count($presupuestos_actuales) === 0) {
            $categorias = [
                ['nombre' => 'Oficina', 'descripcion' => 'Gastos de operación y mantenimiento de la oficina'],
                ['nombre' => 'Eventos', 'descripcion' => 'Organización de eventos y actividades del club'],
                ['nombre' => 'Marketing', 'descripcion' => 'Publicidad y promoción del club'],
                ['nombre' => 'Mantenimiento', 'descripcion' => 'Mantenimiento de equipos e instalaciones'],
                ['nombre' => 'Proyectos', 'descripcion' => 'Proyectos sociales y comunitarios'],
            ];

            foreach ($categorias as $categoria) {
                $presupuesto_mensual = rand(5000, 20000);
                $presupuestos[] = [
                    'categoria' => $categoria['nombre'],
                    'descripcion' => $categoria['descripcion'],
                    'mes' => null,
                    'anio' => null,
                    'presupuesto_mensual' => $presupuesto_mensual,
                    'presupuesto_anual' => $presupuesto_mensual * 12,
                    'monto_gastado' => 0,
                    'monto_disponible' => $presupuesto_mensual,
                    'estado' => 'activa',
                    'alerta_activa' => false,
                    'porcentaje_alerta' => 80,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('presupuestos_categorias')->insert($presupuestos);
        }

        $this->command->info('✅ Datos del módulo Tesorero insertados exitosamente');
        $this->command->info('   - ' . count($ingresos_data) . ' ingresos');
        $this->command->info('   - ' . count($gastos_data) . ' gastos');
        $this->command->info('   - ' . count($membresias_data ?? []) . ' membresías');
        $this->command->info('   - ' . count($presupuestos) . ' presupuestos');
    }
}
