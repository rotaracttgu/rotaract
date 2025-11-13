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
        // First extend the enum to include the new values so we can safely update rows
        // Keep existing legacy values plus the new ones
        DB::statement("ALTER TABLE `membresias` MODIFY `estado` ENUM('activa','vencida','cancelada','completada','pagado','pendiente') NOT NULL DEFAULT 'pendiente'");
        
        // Normalize legacy values so they fit the new enum set
        // Map historical/old states to the new values
        DB::statement("UPDATE `membresias` SET `estado` = 'pagado' WHERE `estado` IN ('activa','completada')");
        DB::statement("UPDATE `membresias` SET `estado` = 'pendiente' WHERE `estado` IN ('vencida','vencido')");
        DB::statement("UPDATE `membresias` SET `estado` = 'cancelado' WHERE `estado` IN ('cancelada')");

        // Finally alter the column to the new ENUM definition (only final allowed values)
        DB::statement("ALTER TABLE `membresias` MODIFY `estado` ENUM('pendiente','pagado','cancelado') NOT NULL DEFAULT 'pendiente'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert enum to previous values as defined originally (keep the old labels)
        DB::statement("ALTER TABLE `membresias` MODIFY `estado` ENUM('activa','vencida','cancelada','completada') NOT NULL DEFAULT 'activa'");
        
        // Note: We don't attempt to revert normalized data back to original exact values,
        // because mapping back is ambiguous. If needed, handle manually.
    }
};
