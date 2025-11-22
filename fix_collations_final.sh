#!/bin/bash

mysql -u dbadmin -p'NuevaContraseña123!' gestiones_clubrotario << 'EOSQL'
ALTER TABLE model_has_permissions COLLATE utf8mb4_general_ci;
ALTER TABLE model_has_roles COLLATE utf8mb4_general_ci;
ALTER TABLE role_has_permissions COLLATE utf8mb4_general_ci;
ALTER TABLE permissions COLLATE utf8mb4_general_ci;
ALTER TABLE roles COLLATE utf8mb4_general_ci;
ALTER TABLE sessions COLLATE utf8mb4_general_ci;
ALTER TABLE password_reset_tokens COLLATE utf8mb4_general_ci;
ALTER TABLE failed_jobs COLLATE utf8mb4_general_ci;
ALTER TABLE migrations COLLATE utf8mb4_general_ci;
ALTER TABLE jobs COLLATE utf8mb4_general_ci;
ALTER TABLE job_batches COLLATE utf8mb4_general_ci;
ALTER TABLE cache COLLATE utf8mb4_general_ci;
ALTER TABLE cache_locks COLLATE utf8mb4_general_ci;
EOSQL

echo "✅ Collations de tablas adicionales corregidas"
