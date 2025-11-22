#!/bin/bash

# Execute SQL to fix collations on production server
# This must be run as dbadmin to modify database collations

cd /var/www/laravel

# Execute the SQL file using dbadmin MySQL user
mysql -u dbadmin -p'NuevaContraseña123!' gestiones_clubrotario < fix_collations.sql

echo ""
echo "✅ Collations fixed!"
