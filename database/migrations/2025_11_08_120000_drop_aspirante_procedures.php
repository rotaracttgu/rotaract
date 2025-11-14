<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This migration will remove all stored procedures whose name contains "Aspirante".
     * It queries information_schema.ROUTINES for the current database and drops each
     * matching procedure. This approach is safer than hard-coding names because it
     * will catch any similarly named procedures.
     */
    public function up(): void
    {
        $procedures = DB::select("SELECT ROUTINE_NAME FROM information_schema.ROUTINES WHERE ROUTINE_TYPE='PROCEDURE' AND ROUTINE_SCHEMA=DATABASE() AND ROUTINE_NAME LIKE ?", ['%Aspirante%']);

        foreach ($procedures as $proc) {
            $name = $proc->ROUTINE_NAME ?? $proc->routine_name ?? null;
            if ($name) {
                // Use unprepared to execute the DROP
                DB::unprepared("DROP PROCEDURE IF EXISTS `" . str_replace('`', '``', $name) . "`");
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * We do not attempt to recreate the procedures here because their original
     * definitions are part of older migrations; restoring them automatically may
     * be unsafe. If needed, roll back the specific migrations that created them.
     */
    public function down(): void
    {
        // Intentionally left blank.
    }
};
