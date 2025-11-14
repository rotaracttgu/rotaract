<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Crea el Trigger SQL para sincronizar nombres de usuarios
     */
    public function up(): void
    {
        // Eliminar trigger si existe
        try {
            DB::statement("DROP TRIGGER IF EXISTS `trg_actualizar_nombre_usuario`");
        } catch (\Exception $e) {
            // Ignorar
        }

        // Crear el trigger para sincronizar nombre de usuario cuando cambia en miembros
        $triggerSQL = <<<SQL
            CREATE TRIGGER `trg_actualizar_nombre_usuario`
            AFTER UPDATE ON `miembros`
            FOR EACH ROW
            BEGIN
                -- Solo actualizar si el nombre cambió y existe user_id
                IF OLD.Nombre != NEW.Nombre AND NEW.user_id IS NOT NULL THEN
                    UPDATE users 
                    SET name = NEW.Nombre 
                    WHERE id = NEW.user_id;
                END IF;
            END
        SQL;

        try {
            DB::unprepared($triggerSQL);
            \Log::info("SQL Triggers Migration: Se registró exitosamente el trigger trg_actualizar_nombre_usuario.");
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            \Log::warning("SQL Triggers Migration: Error al crear trigger: " . $msg);

            // Si el error es por falta de privilegios con binary logging activo (MySQL 1419),
            // no hacemos throw para evitar que la migración falle en producción.
            if (strpos($msg, '1419') !== false || stripos($msg, 'log_bin_trust_function_creators') !== false || stripos($msg, 'SUPER privilege') !== false) {
                \Log::warning("SQL Triggers Migration: Se omitió la creación del trigger trg_actualizar_nombre_usuario debido a permisos/ log_bin (1419). Para crear triggers en este servidor habilita log_bin_trust_function_creators=1 o utiliza un usuario con SUPER.");
                return;
            }

            throw new \Exception("No se pudo registrar el trigger. Error: " . $msg);
        }
    }

    /**
     * Reverse the migrations.
     * Elimina todos los Triggers SQL registrados
     */
    public function down(): void
    {
        $triggersAEliminar = [
            'trg_actualizar_nombre_usuario',
        ];

        foreach ($triggersAEliminar as $nombreTrigger) {
            try {
                DB::statement("DROP TRIGGER IF EXISTS {$nombreTrigger}");
            } catch (\Exception $e) {
                // Ignorar errores, algunos triggers pueden no existir
            }
        }

        \Log::info("SQL Triggers Migration Rollback: Se eliminaron los triggers.");
    }
};
