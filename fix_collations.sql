-- Fix collations for production database
ALTER DATABASE gestiones_clubrotario COLLATE utf8mb4_general_ci;

-- Alter main tables
ALTER TABLE calendarios COLLATE utf8mb4_general_ci;
ALTER TABLE notas_personales COLLATE utf8mb4_general_ci;
ALTER TABLE miembros COLLATE utf8mb4_general_ci;
ALTER TABLE users COLLATE utf8mb4_general_ci;
ALTER TABLE proyectos COLLATE utf8mb4_general_ci;
ALTER TABLE reunions COLLATE utf8mb4_general_ci;
ALTER TABLE consultas COLLATE utf8mb4_general_ci;
ALTER TABLE asistencias COLLATE utf8mb4_general_ci;

-- Verify collations were fixed
SELECT TABLE_NAME, TABLE_COLLATION FROM INFORMATION_SCHEMA.TABLES 
WHERE TABLE_SCHEMA = 'gestiones_clubrotario' 
AND TABLE_NAME IN ('calendarios', 'notas_personales', 'users', 'miembros', 'proyectos', 'reunions')
ORDER BY TABLE_NAME;
