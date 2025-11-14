<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Procedimiento almacenado para búsqueda avanzada de documentos.
     * Parámetros: término_busqueda, tipo, categoria, fecha_inicio, fecha_fin
     */
    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS SP_BusquedaDocumentos');
        
        DB::unprepared("
            CREATE PROCEDURE SP_BusquedaDocumentos(
                IN p_busqueda VARCHAR(255),
                IN p_tipo VARCHAR(50),
                IN p_categoria VARCHAR(100),
                IN p_fecha_inicio DATE,
                IN p_fecha_fin DATE
            )
            BEGIN
                SELECT 
                    doc.id,
                    doc.titulo,
                    doc.tipo,
                    doc.categoria,
                    doc.descripcion,
                    doc.archivo_path,
                    doc.archivo_nombre,
                    doc.visible_para_todos,
                    u.name AS creador_nombre,
                    doc.created_at AS fecha_creacion,
                    doc.updated_at AS fecha_actualizacion,
                    CASE 
                        WHEN doc.archivo_nombre LIKE '%.pdf' THEN 'PDF'
                        WHEN doc.archivo_nombre LIKE '%.doc%' THEN 'Word'
                        WHEN doc.archivo_nombre LIKE '%.xls%' THEN 'Excel'
                        ELSE 'Otro'
                    END AS tipo_archivo
                FROM documentos doc
                LEFT JOIN users u ON doc.creado_por = u.id
                WHERE (
                    p_busqueda IS NULL 
                    OR p_busqueda = '' 
                    OR doc.titulo LIKE CONCAT('%', p_busqueda, '%')
                    OR doc.descripcion LIKE CONCAT('%', p_busqueda, '%')
                    OR doc.archivo_nombre LIKE CONCAT('%', p_busqueda, '%')
                )
                AND (p_tipo IS NULL OR p_tipo = '' OR doc.tipo = p_tipo)
                AND (p_categoria IS NULL OR p_categoria = '' OR doc.categoria = p_categoria)
                AND (
                    (p_fecha_inicio IS NULL AND p_fecha_fin IS NULL)
                    OR doc.created_at BETWEEN p_fecha_inicio AND p_fecha_fin
                )
                ORDER BY doc.created_at DESC;
                
                -- Resumen de búsqueda
                SELECT 
                    COUNT(*) AS total_encontrados,
                    SUM(CASE WHEN tipo = 'oficial' THEN 1 ELSE 0 END) AS oficiales,
                    SUM(CASE WHEN tipo = 'interno' THEN 1 ELSE 0 END) AS internos,
                    SUM(CASE WHEN tipo = 'comunicado' THEN 1 ELSE 0 END) AS comunicados,
                    SUM(CASE WHEN tipo = 'carta' THEN 1 ELSE 0 END) AS cartas,
                    SUM(CASE WHEN tipo = 'informe' THEN 1 ELSE 0 END) AS informes,
                    SUM(CASE WHEN visible_para_todos = 1 THEN 1 ELSE 0 END) AS publicos,
                    GROUP_CONCAT(DISTINCT categoria SEPARATOR ', ') AS categorias_encontradas
                FROM documentos doc
                WHERE (
                    p_busqueda IS NULL 
                    OR p_busqueda = '' 
                    OR doc.titulo LIKE CONCAT('%', p_busqueda, '%')
                    OR doc.descripcion LIKE CONCAT('%', p_busqueda, '%')
                    OR doc.archivo_nombre LIKE CONCAT('%', p_busqueda, '%')
                )
                AND (p_tipo IS NULL OR p_tipo = '' OR doc.tipo = p_tipo)
                AND (p_categoria IS NULL OR p_categoria = '' OR doc.categoria = p_categoria)
                AND (
                    (p_fecha_inicio IS NULL AND p_fecha_fin IS NULL)
                    OR doc.created_at BETWEEN p_fecha_inicio AND p_fecha_fin
                );
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS SP_BusquedaDocumentos');
    }
};
