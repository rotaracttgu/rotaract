<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateResponderConsultaSP extends Command
{
    protected $signature = 'db:create-sp-responder-consulta';
    protected $description = 'Crear el stored procedure SP_ResponderConsulta';

    public function handle()
    {
        try {
            $sql = <<<SQL
CREATE PROCEDURE IF NOT EXISTS SP_ResponderConsulta(
    IN p_consulta_id INT,
    IN p_respuesta TEXT,
    IN p_user_id INT
)
BEGIN
    DECLARE v_exito INT DEFAULT 0;
    DECLARE v_mensaje VARCHAR(255) DEFAULT '';
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        SELECT 0 AS exito, 'Error al procesar respuesta' AS mensaje;
    END;

    START TRANSACTION;
    
    -- Validar que la consulta exista
    IF NOT EXISTS(SELECT 1 FROM Consultas WHERE ConsultaID = p_consulta_id) THEN
        SELECT 0 AS exito, 'Consulta no encontrada' AS mensaje;
    ELSE
        -- Actualizar consulta con respuesta
        UPDATE Consultas 
        SET 
            Estado = 'respondida',
            Respuesta = p_respuesta,
            FechaRespuesta = NOW(),
            RespondioPor = p_user_id
        WHERE ConsultaID = p_consulta_id;
        
        IF ROW_COUNT() > 0 THEN
            SET v_exito = 1;
            SET v_mensaje = 'Consulta respondida exitosamente';
        ELSE
            SET v_exito = 0;
            SET v_mensaje = 'Error al actualizar consulta';
        END IF;
        
        SELECT v_exito AS exito, v_mensaje AS mensaje, p_consulta_id AS ConsultaID;
    END IF;
    
    COMMIT;
END
SQL;

            DB::statement($sql);
            $this->info('✓ Stored Procedure SP_ResponderConsulta creado exitosamente');
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
