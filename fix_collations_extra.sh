#!/bin/bash

# Corregir collations adicionales
mysql -u dbadmin -p'NuevaContraseña123!' gestiones_clubrotario -e "
ALTER TABLE mensajes_consultas COLLATE utf8mb4_general_ci;
ALTER TABLE conversaciones_chat COLLATE utf8mb4_general_ci;
ALTER TABLE actas COLLATE utf8mb4_general_ci;
ALTER TABLE asistencias_reunions COLLATE utf8mb4_general_ci;
ALTER TABLE participaciones COLLATE utf8mb4_general_ci;
ALTER TABLE roles COLLATE utf8mb4_general_ci;
"

echo "✅ Collations adicionales corregidas"
