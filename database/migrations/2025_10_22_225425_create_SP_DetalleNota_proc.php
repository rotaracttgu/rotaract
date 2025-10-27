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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_DetalleNota`(IN `p_user_id` BIGINT, IN `p_nota_id` INT)
BEGIN
    DECLARE v_miembro_id INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
    SELECT 
        n.NotaID,
        n.Titulo,
        n.Contenido,
        n.Categoria,
        n.Visibilidad,
        n.Etiquetas,
        n.FechaCreacion,
        n.FechaActualizacion,
        n.FechaRecordatorio,
        n.Estado,
        m.Nombre AS autor
    FROM notas_personales n
    INNER JOIN miembros m ON n.MiembroID = m.MiembroID
    WHERE n.NotaID = p_nota_id
    AND (n.MiembroID = v_miembro_id OR n.Visibilidad = 'publica')
    AND n.Estado = 'activa';
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_DetalleNota");
    }
};
