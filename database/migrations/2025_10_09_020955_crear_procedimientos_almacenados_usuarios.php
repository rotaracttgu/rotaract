<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Eliminar procedimientos si existen
        $this->dropProcedures();
        
        // Crear procedimiento para obtener usuarios paginados
        DB::unprepared('
            CREATE PROCEDURE pa_obtener_usuarios_paginados(
                IN p_pagina INT,
                IN p_por_pagina INT,
                IN p_ordenar_por VARCHAR(50),
                IN p_direccion_orden VARCHAR(4)
            )
            BEGIN
                DECLARE v_offset INT;
                SET v_offset = (p_pagina - 1) * p_por_pagina;
                
                SELECT 
                    id,
                    name,
                    email,
                    email_verified_at,
                    created_at,
                    updated_at
                FROM users
                ORDER BY 
                    CASE 
                        WHEN p_ordenar_por = "created_at" AND p_direccion_orden = "desc" THEN created_at
                    END DESC,
                    CASE 
                        WHEN p_ordenar_por = "created_at" AND p_direccion_orden = "asc" THEN created_at
                    END ASC,
                    CASE 
                        WHEN p_ordenar_por = "name" AND p_direccion_orden = "desc" THEN name
                    END DESC,
                    CASE 
                        WHEN p_ordenar_por = "name" AND p_direccion_orden = "asc" THEN name
                    END ASC,
                    CASE 
                        WHEN p_ordenar_por = "email" AND p_direccion_orden = "desc" THEN email
                    END DESC,
                    CASE 
                        WHEN p_ordenar_por = "email" AND p_direccion_orden = "asc" THEN email
                    END ASC
                LIMIT p_por_pagina OFFSET v_offset;
            END
        ');
        
        // Crear procedimiento para contar usuarios
        DB::unprepared('
            CREATE PROCEDURE pa_contar_usuarios()
            BEGIN
                SELECT COUNT(*) as total FROM users;
            END
        ');
        
        // Crear procedimiento para obtener usuario por ID
        DB::unprepared('
            CREATE PROCEDURE pa_obtener_usuario_por_id(
                IN p_usuario_id BIGINT
            )
            BEGIN
                SELECT 
                    id,
                    name,
                    email,
                    email_verified_at,
                    created_at,
                    updated_at
                FROM users 
                WHERE id = p_usuario_id;
            END
        ');
        
        // Crear procedimiento para obtener usuarios activos
        DB::unprepared('
            CREATE PROCEDURE pa_obtener_usuarios_activos()
            BEGIN
                SELECT 
                    id,
                    name,
                    email,
                    email_verified_at,
                    created_at,
                    updated_at
                FROM users
                WHERE email_verified_at IS NOT NULL
                ORDER BY created_at DESC;
            END
        ');
        
        // Crear procedimiento para buscar usuarios
        DB::unprepared('
            CREATE PROCEDURE pa_buscar_usuarios(
                IN p_termino_busqueda VARCHAR(255),
                IN p_pagina INT,
                IN p_por_pagina INT
            )
            BEGIN
                DECLARE v_offset INT;
                SET v_offset = (p_pagina - 1) * p_por_pagina;
                
                SELECT 
                    id,
                    name,
                    email,
                    email_verified_at,
                    created_at,
                    updated_at
                FROM users
                WHERE name LIKE CONCAT("%", p_termino_busqueda, "%")
                   OR email LIKE CONCAT("%", p_termino_busqueda, "%")
                ORDER BY created_at DESC
                LIMIT p_por_pagina OFFSET v_offset;
                
                SELECT COUNT(*) as total
                FROM users
                WHERE name LIKE CONCAT("%", p_termino_busqueda, "%")
                   OR email LIKE CONCAT("%", p_termino_busqueda, "%");
            END
        ');
        
        // Crear procedimiento para estadísticas de usuarios
        DB::unprepared('
            CREATE PROCEDURE pa_estadisticas_usuarios()
            BEGIN
                SELECT 
                    COUNT(*) as total_usuarios,
                    COUNT(CASE WHEN email_verified_at IS NOT NULL THEN 1 END) as usuarios_verificados,
                    COUNT(CASE WHEN email_verified_at IS NULL THEN 1 END) as usuarios_no_verificados,
                    COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN 1 END) as usuarios_hoy,
                    COUNT(CASE WHEN YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1) THEN 1 END) as usuarios_semana,
                    COUNT(CASE WHEN MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) THEN 1 END) as usuarios_mes
                FROM users;
            END
        ');
        
        // Crear procedimiento para crear usuario
        DB::unprepared('
            CREATE PROCEDURE pa_crear_usuario(
                IN p_nombre VARCHAR(255),
                IN p_email VARCHAR(255),
                IN p_password VARCHAR(255)
            )
            BEGIN
                INSERT INTO users (name, email, password, created_at, updated_at)
                VALUES (p_nombre, p_email, p_password, NOW(), NOW());
                
                SELECT LAST_INSERT_ID() as id;
            END
        ');
        
        // Crear procedimiento para actualizar usuario
        DB::unprepared('
            CREATE PROCEDURE pa_actualizar_usuario(
                IN p_usuario_id BIGINT,
                IN p_nombre VARCHAR(255),
                IN p_email VARCHAR(255)
            )
            BEGIN
                UPDATE users 
                SET name = p_nombre,
                    email = p_email,
                    updated_at = NOW()
                WHERE id = p_usuario_id;
                
                SELECT ROW_COUNT() as filas_afectadas;
            END
        ');
        
        // Crear procedimiento para eliminar usuario
        DB::unprepared('
            CREATE PROCEDURE pa_eliminar_usuario(
                IN p_usuario_id BIGINT
            )
            BEGIN
                DELETE FROM users WHERE id = p_usuario_id;
                SELECT ROW_COUNT() as filas_afectadas;
            END
        ');
    }

    public function down(): void
    {
        $this->dropProcedures();
    }
    
    private function dropProcedures(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS pa_obtener_usuarios_paginados');
        DB::unprepared('DROP PROCEDURE IF EXISTS pa_contar_usuarios');
        DB::unprepared('DROP PROCEDURE IF EXISTS pa_obtener_usuario_por_id');
        DB::unprepared('DROP PROCEDURE IF EXISTS pa_obtener_usuarios_activos');
        DB::unprepared('DROP PROCEDURE IF EXISTS pa_buscar_usuarios');
        DB::unprepared('DROP PROCEDURE IF EXISTS pa_estadisticas_usuarios');
        DB::unprepared('DROP PROCEDURE IF EXISTS pa_crear_usuario');
        DB::unprepared('DROP PROCEDURE IF EXISTS pa_actualizar_usuario');
        DB::unprepared('DROP PROCEDURE IF EXISTS pa_eliminar_usuario');
    }
};