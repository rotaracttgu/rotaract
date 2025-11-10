<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("CREATE PROCEDURE `SP_EliminarNota`(IN `p_user_id` BIGINT, IN `p_nota_id` INT)
BEGIN
    DECLARE v_miembro_id INT;
    DECLARE v_propietario INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
    SELECT MiembroID INTO v_propietario
    FROM notas_personales
    WHERE NotaID = p_nota_id;
    
    IF v_propietario = v_miembro_id THEN
        UPDATE notas_personales
        SET Estado = 'eliminada'
        WHERE NotaID = p_nota_id;
        
        SELECT 'Nota eliminada exitosamente' AS mensaje, 1 AS exito;
    ELSE
        SELECT 'No tienes permiso para eliminar esta nota' AS mensaje, 0 AS exito;
    END IF;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_EliminarNota");
    }
};
