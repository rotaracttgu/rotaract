#!/bin/bash

# Script para cambiar todas las tablas a collation utf8mb4_general_ci
mysql -u dbadmin -p'NuevaContraseña123!' gestiones_clubrotario << 'EOF'
-- Encontrar y corregir todas las tablas
SELECT CONCAT('ALTER TABLE `', TABLE_NAME, '` COLLATE utf8mb4_general_ci;')
FROM INFORMATION_SCHEMA.TABLES
WHERE TABLE_SCHEMA = 'gestiones_clubrotario'
AND TABLE_COLLATION != 'utf8mb4_general_ci'
INTO OUTFILE '/tmp/fix_all_collations.sql';
EOF

# Ejecutar el script generado
mysql -u dbadmin -p'NuevaContraseña123!' gestiones_clubrotario < /tmp/fix_all_collations.sql 2>/dev/null

echo "✅ Todas las collations corregidas"
