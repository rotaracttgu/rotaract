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
            \Log::warning("SQL Triggers Migration: Error al crear trigger: " . $e->getMessage());
            throw new \Exception("No se pudo registrar el trigger. Error: " . $e->getMessage());
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
