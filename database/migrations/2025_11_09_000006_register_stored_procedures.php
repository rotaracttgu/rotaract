<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Registra los 60 Stored Procedures desde los archivos SQL en la carpeta sql_import/Procedimientos/
     */
    public function up(): void
    {
        $procedimientosPath = database_path('../sql_import/Procedimientos');
        
        if (!File::isDirectory($procedimientosPath)) {
            throw new \Exception("La carpeta de procedimientos no existe en: {$procedimientosPath}");
        }

        // Obtener todos los archivos .sql de la carpeta
        $sqlFiles = File::glob($procedimientosPath . '/*.sql');
        
        if (empty($sqlFiles)) {
            throw new \Exception("No se encontraron archivos SQL en: {$procedimientosPath}");
        }

        $procedimientosRegistrados = 0;
        $errores = [];

        // Procesar cada archivo SQL
        foreach ($sqlFiles as $filePath) {
            try {
                // Leer el contenido del archivo
                $sqlContent = File::get($filePath);
                
                // Limpiar el contenido
                $sqlContent = trim($sqlContent);
                
                // Saltar archivos vacíos
                if (empty($sqlContent)) {
                    continue;
                }

                // Extraer el nombre del procedimiento del archivo
                $nombreArchivo = File::basename($filePath, '.sql');
                $nombreProcedimiento = str_replace('sp_', '', $nombreArchivo);
                
                // Remover DELIMITER y líneas vacías
                $sqlContent = preg_replace('/^DELIMITER\s+\/\//im', '', $sqlContent);
                $sqlContent = preg_replace('/\/\/\s*\nDELIMITER\s+;/im', '', $sqlContent);
                $sqlContent = preg_replace('/\s*\/\/\s*$/m', '', $sqlContent);
                $sqlContent = preg_replace('/^DELIMITER\s+;/im', '', $sqlContent);
                
                // Limpiar comentarios del inicio
                $sqlContent = preg_replace('/^USE\s+gestiones_clubrotario;/im', '', $sqlContent);
                $sqlContent = preg_replace('/^--.*$/m', '', $sqlContent);
                $sqlContent = preg_replace('/^\/\*.*?\*\//ms', '', $sqlContent);
                $sqlContent = trim($sqlContent);
                
                // Saltar si el contenido resultante está vacío
                if (empty($sqlContent)) {
                    continue;
                }

                // Intentar eliminar el procedimiento existente (sin lanzar error si no existe)
                try {
                    DB::statement("DROP PROCEDURE IF EXISTS {$nombreProcedimiento}");
                } catch (\Exception $e) {
                    // Ignorar errores de DROP, tal vez no existe
                }

                // Ejecutar el SQL para crear el procedimiento
                DB::unprepared($sqlContent);
                
                $procedimientosRegistrados++;
                
            } catch (\Exception $e) {
                $errores[] = "Error procesando " . File::basename($filePath) . ": " . $e->getMessage();
            }
        }

        // Si hay errores significativos, lanzar excepción
        if (!empty($errores) && $procedimientosRegistrados === 0) {
            throw new \Exception("No se pudo registrar ningún procedimiento. Errores: " . implode(", ", array_slice($errores, 0, 3)));
        }

        // Log de éxito
        \Log::info("Stored Procedures Migration: Se registraron exitosamente {$procedimientosRegistrados} procedimientos almacenados.");
        
        if (!empty($errores)) {
            \Log::warning("Stored Procedures Migration: Se encontraron " . count($errores) . " errores durante la migración.");
            foreach (array_slice($errores, 0, 5) as $error) {
                \Log::warning("  - " . $error);
            }
        }
    }

    /**
     * Reverse the migrations.
     * Elimina todos los Stored Procedures registrados
     */
    public function down(): void
    {
        $procedimientosAEliminar = [
            'sp_actualizar_registro_general',
            'sp_analisis_tendencias',
            'sp_aprobar_gasto',
            'sp_analisis_rentabilidad',
            'sp_actualizar_membresia',
            'sp_actualizar_ingreso',
            'sp_actualizar_gasto',
            'sp_auditoria_registro',
            'sp_busqueda_avanzada_registros',
            'sp_historial_membresias_usuario',
            'sp_historico_saldos_diarios',
            'sp_ingresos_mensuales',
            'sp_generar_reporte_periodo',
            'sp_gastos_por_proveedor',
            'sp_gastos_por_metodo_pago',
            'sp_gastos_por_categoria',
            'sp_gastos_pendientes_aprobacion',
            'sp_gastos_mensuales',
            'sp_exportar_datos_analisis',
            'sp_estadisticas_por_usuario',
            'sp_obtener_balance_general',
            'sp_obtener_correlativo_siguiente',
            'sp_obtener_datos_ingreso',
            'sp_obtener_datos_gasto',
            'sp_obtener_gastos_por_periodo',
            'sp_obtener_ingresos_actuales',
            'sp_obtener_membresias_activas',
            'sp_obtener_movimientos_diarios',
            'sp_obtener_movimientos_mes',
            'sp_obtener_movimientos_periodo',
            'sp_obtener_presupuesto_actual',
            'sp_obtener_resumen_flujo_caja',
            'sp_obtener_totales_por_categoria',
            'sp_obtener_totales_por_usuario',
            'sp_registrar_egreso',
            'sp_registrar_ingreso',
            'sp_registrar_membresia',
            'sp_registrar_pago_membresia',
            'sp_registrar_transferencia',
            'sp_transferencia_fondos',
            'sp_analizar_rentabilidad_periodos',
            'sp_buscar_movimientos_avanzado',
            'sp_calculo_presupuesto_disponible',
            'sp_comparar_periodos',
            'sp_estadisticas_movimientos_generales',
            'sp_exportar_movimientos_excel',
            'sp_generar_alertas_presupuesto',
            'sp_generar_reporte_auditoria',
            'sp_generar_reporte_flujo_caja',
            'sp_generar_reporte_gestion_presupuesto',
            'sp_generar_reporte_movimientos',
            'sp_historial_cambios_membresias',
            'sp_identificar_gastos_recurrentes',
            'sp_listar_proveedores_frecuentes',
            'sp_obtener_detalles_movimiento',
            'sp_proyeccion_saldos_futuros',
            'sp_registrar_pago_proyecto',
            'sp_resumen_movimientos_usuario',
            'sp_validar_disponibilidad_presupuesto',
            'sp_validar_saldo_suficiente',
            'sp_verificar_membresía_activa',
        ];

        foreach ($procedimientosAEliminar as $nombreProcedimiento) {
            try {
                DB::statement("DROP PROCEDURE IF EXISTS {$nombreProcedimiento}");
            } catch (\Exception $e) {
                // Ignorar errores, algunos procedimientos pueden no existir
            }
        }

        \Log::info("Stored Procedures Migration Rollback: Se eliminaron los procedimientos almacenados.");
    }
};
