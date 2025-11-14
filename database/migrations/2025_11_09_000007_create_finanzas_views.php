<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Registra las 6 Vistas SQL desde los archivos en la carpeta sql_import/Vistas/
     */
    public function up(): void
    {
        $vistasPath = database_path('../sql_import/Vistas');

        // Si la carpeta no existe o está vacía, no fallamos en producción: hacemos log y salimos.
        if (!File::isDirectory($vistasPath)) {
            \Log::warning("SQL Views Migration: carpeta no encontrada, se omite registro de vistas en: {$vistasPath}");
            return;
        }

        // Obtener todos los archivos .sql de la carpeta
        $sqlFiles = File::glob($vistasPath . '/*.sql');

        if (empty($sqlFiles)) {
            \Log::warning("SQL Views Migration: no se encontraron archivos .sql en: {$vistasPath}. Se omite registro de vistas.");
            return;
        }

        $vistasRegistradas = 0;
        $errores = [];
        $vistasNombres = [];

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

                // Extraer el nombre de la vista del archivo
                $nombreArchivo = File::basename($filePath, '.sql');
                
                // Remover DELIMITER y líneas vacías
                $sqlContent = preg_replace('/^DELIMITER\s+\/\//im', '', $sqlContent);
                $sqlContent = preg_replace('/\/\/\s*\nDELIMITER\s+;/im', '', $sqlContent);
                $sqlContent = preg_replace('/\s*\/\/\s*$/m', '', $sqlContent);
                $sqlContent = preg_replace('/^DELIMITER\s+;/im', '', $sqlContent);
                
                // Limpiar comentarios y USE
                $sqlContent = preg_replace('/^USE\s+gestiones_clubrotario;/im', '', $sqlContent);
                $sqlContent = preg_replace('/^--.*$/m', '', $sqlContent);
                $sqlContent = preg_replace('/^\/\*.*?\*\//ms', '', $sqlContent);
                $sqlContent = trim($sqlContent);
                
                // Saltar si está vacío
                if (empty($sqlContent)) {
                    continue;
                }

                // Intentar eliminar la vista existente (sin lanzar error si no existe)
                try {
                    DB::statement("DROP VIEW IF EXISTS {$nombreArchivo}");
                } catch (\Exception $e) {
                    // Ignorar errores de DROP, tal vez no existe
                }

                // Ejecutar el SQL para crear la vista
                DB::unprepared($sqlContent);
                
                $vistasRegistradas++;
                $vistasNombres[] = $nombreArchivo;
                
            } catch (\Exception $e) {
                $errores[] = "Error procesando " . File::basename($filePath) . ": " . $e->getMessage();
            }
        }

        // Si hay errores significativos, lanzar excepción
        if (!empty($errores) && $vistasRegistradas === 0) {
            throw new \Exception("No se pudo registrar ninguna vista. Errores: " . implode(", ", array_slice($errores, 0, 3)));
        }

        // Log de éxito
        \Log::info("SQL Views Migration: Se registraron exitosamente {$vistasRegistradas} vistas SQL.");
        \Log::info("  Vistas creadas: " . implode(", ", $vistasNombres));
        
        if (!empty($errores)) {
            \Log::warning("SQL Views Migration: Se encontraron " . count($errores) . " errores durante la migración.");
            foreach (array_slice($errores, 0, 5) as $error) {
                \Log::warning("  - " . $error);
            }
        }
    }

    /**
     * Reverse the migrations.
     * Elimina todas las Vistas SQL registradas
     */
    public function down(): void
    {
        $vistasAEliminar = [
            'v_balance_general',
            'v_movimientos_mes_actual',
            'Registros_financieros',
            'Control_presupuestos',
            'Alertas_presupuesto',
            'estadistica_usuario',
        ];

        foreach ($vistasAEliminar as $nombreVista) {
            try {
                DB::statement("DROP VIEW IF EXISTS {$nombreVista}");
            } catch (\Exception $e) {
                // Ignorar errores, algunas vistas pueden no existir
            }
        }

        \Log::info("SQL Views Migration Rollback: Se eliminaron las vistas SQL.");
    }
};
